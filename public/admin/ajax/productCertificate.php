<?php

/**
 * AJAX certificato prodotto (admin).
 * Azioni: get | preview | save | generate_pdf | save_notarization
 */
session_start();

header('Content-Type: application/json; charset=utf-8');

if (! isset($_SESSION['loggato']) || $_SESSION['loggato'] !== 'si') {
    http_response_code(403);
    echo json_encode(['ok' => false, 'message' => 'Non autenticato.']);
    exit;
}

require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../include/product_image_r2.php';

use App\Models\Product;
use App\Models\ProductCertificate;
use App\Services\ProductCertificateService;
use App\Services\ProductCertificateTextBuilder;
use App\Jobs\AutoNotarizeProductCertificateJob;
use Symfony\Component\Process\Process;

$action = (string) ($_REQUEST['action'] ?? 'get');
$productId = (int) ($_REQUEST['product_id'] ?? 0);

if ($productId <= 0) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'product_id mancante.']);
    exit;
}

$product = Product::query()->where('entity_id', $productId)->first();
if (! $product) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'message' => 'Prodotto non trovato.']);
    exit;
}

$siteBase = rtrim($http.'://'.$ind_sito, '/');

function cert_payload(?ProductCertificate $existing, string $siteBase): ?array
{
    if (! $existing) {
        return null;
    }

    $builder = app(ProductCertificateTextBuilder::class);
    $combined = trim((string) ($existing->product?->description ?? ''));
    $type = $builder->detectType((string) ($existing->product_name ?? $existing->product?->name ?? ''), $combined);
    $registry = (int) $existing->registry_number;

    $pdfUrl = null;
    if ($existing->pdf_filename) {
        // Host corrente (staging/prod), non APP_URL: i PDF non sono condivisi tra ambienti.
        $pdfUrl = $siteBase.'/h/pdf/'.$existing->pdf_filename;
    }

    $yliumNotarize = (string) config('product_certificates.ylium_notarization_url');
    if ($yliumNotarize !== '' && ! preg_match('#^https?://#i', $yliumNotarize)) {
        $yliumNotarize = $siteBase.'/'.ltrim($yliumNotarize, '/');
    }

    return [
        'access_code' => $existing->access_code,
        'registry_number' => $registry,
        'body_text' => $existing->body_text,
        'core_body' => $builder->stripLegalFooter((string) $existing->body_text),
        'legal_footer' => $registry > 0 ? $builder->legalFooter($registry, $type) : '',
        'url' => $siteBase.'/h/'.$existing->access_code.'.html',
        'published' => (bool) $existing->published,
        'pdf_url' => $pdfUrl,
        'pdf_sha256' => $existing->pdf_sha256 ? ('0x'.$existing->pdf_sha256) : null,
        'issued_on' => optional($existing->issued_on)->format('Y-m-d'),
        'notarized' => $existing->isNotarized(),
        'notarization_hash' => $existing->notarization_hash,
        'notarization_tx_hash' => $existing->notarization_tx_hash,
        'notarization_notes' => $existing->notarization_notes,
        'notarized_at' => optional($existing->notarized_at)->format('Y-m-d H:i'),
        'notarization_status' => $existing->notarization_status,
        'notarization_started_at' => optional($existing->notarization_started_at)->format('Y-m-d H:i'),
        'notarization_error' => $existing->notarization_error,
        'polygonscan_url' => $existing->polygonscanUrl(),
        'verify_url' => $siteBase.'/h/verifica.html'.($existing->pdf_sha256 ? ('?hash=0x'.$existing->pdf_sha256) : ''),
        'ylium_verify_url' => config('product_certificates.ylium_verify_url'),
        'ylium_notarization_url' => $yliumNotarize,
        'ylium_wizard_url' => config('product_certificates.ylium_wizard_url'),
        'scores' => [
            'conservazione' => $existing->score_conservazione,
            'rarita' => $existing->score_rarita,
            'battuta' => $existing->score_battuta,
            'metallo' => $existing->score_metallo,
            'stile' => $existing->score_stile,
            'provenienza' => $existing->score_provenienza,
        ],
    ];
}

try {
    if ($action === 'get') {
        $existing = ProductCertificate::query()->where('product_id', $productId)->first();
        $builder = app(ProductCertificateTextBuilder::class);
        $registry = (int) ($existing?->registry_number ?? 0);
        $editedBody = $existing?->body_text;
        $composed = $builder->composeBody($product, $editedBody, $registry);

        echo json_encode([
            'ok' => true,
            'product' => [
                'id' => (int) $product->entity_id,
                'sku' => (string) $product->sku,
                'name' => (string) $product->name,
            ],
            'certificate' => cert_payload($existing, $siteBase),
            'core_body' => $composed['core_body'],
            'legal_footer' => $composed['legal_footer'],
            'preview_body' => $composed['body_text'],
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'preview') {
        $registry = (int) ($_REQUEST['registry_number'] ?? 0);
        $editedBody = isset($_REQUEST['body_text']) ? trim((string) $_REQUEST['body_text']) : '';
        $builder = app(ProductCertificateTextBuilder::class);
        $composed = $builder->composeBody(
            $product,
            $editedBody !== '' ? $editedBody : null,
            $registry
        );

        echo json_encode([
            'ok' => true,
            'core_body' => $composed['core_body'],
            'legal_footer' => $composed['legal_footer'],
            'body_text' => $composed['body_text'],
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'save') {
        $registry = (int) ($_REQUEST['registry_number'] ?? 0);
        $accessCode = isset($_REQUEST['access_code']) ? trim((string) $_REQUEST['access_code']) : null;
        $bodyText = isset($_REQUEST['body_text']) ? trim((string) $_REQUEST['body_text']) : null;
        $replaceExisting = in_array((string) ($_REQUEST['replace_existing'] ?? ''), ['1', 'true', 'yes'], true);
        if ($accessCode === '') {
            $accessCode = null;
        }
        if ($bodyText === '') {
            $bodyText = null;
        }

        $existing = ProductCertificate::query()->where('product_id', $productId)->first();
        if ($existing && $bodyText !== null && ! $replaceExisting) {
            throw new RuntimeException('Per modificare un certificato già esistente devi creare una nuova certificazione (annulla e rigenera).');
        }

        $service = app(ProductCertificateService::class);
        $result = $service->generateOrUpdate($product, $registry, $accessCode, $bodyText);

        $cert = $result['certificate'];
        echo json_encode([
            'ok' => true,
            'created' => $result['created'],
            'access_code' => $cert->access_code,
            'registry_number' => $cert->registry_number,
            'body_text' => $cert->body_text,
            'url' => $siteBase.'/h/'.$cert->access_code.'.html',
            'product_id' => $productId,
            'certificate' => cert_payload($cert, $siteBase),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'generate_pdf') {
        $existing = ProductCertificate::query()->where('product_id', $productId)->first();
        if (! $existing) {
            throw new RuntimeException('Salva prima il certificato online.');
        }

        $service = app(ProductCertificateService::class);
        $cert = $service->regeneratePdf($existing);

        echo json_encode([
            'ok' => true,
            'message' => 'PDF generato. Notarizzazione precedente annullata: rifare la firma su blockchain.',
            'certificate' => cert_payload($cert, $siteBase),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'auto_notarize_start') {
        $existing = ProductCertificate::query()->where('product_id', $productId)->first();
        if (! $existing) {
            throw new RuntimeException('Certificato non trovato.');
        }
        if (! $existing->pdf_sha256) {
            throw new RuntimeException('Genera prima il PDF da notarizzare.');
        }

        $enabled = (bool) config('product_certificates.ylium_auto_enabled', false);
        if (! $enabled) {
            throw new RuntimeException('Notarizzazione automatica non abilitata. Usa la dApp Ylium manuale.');
        }

        $notes = isset($_REQUEST['notarization_notes']) ? trim((string) $_REQUEST['notarization_notes']) : '';
        if ($notes === '') {
            // Default: usa il testo completo del certificato come nota notarizzazione.
            $notes = trim((string) $existing->body_text);
        }
        $existing->notarization_notes = $notes !== '' ? $notes : null;
        $existing->notarization_status = 'pending';
        $existing->notarization_started_at = now();
        $existing->notarization_error = null;
        $existing->notarization_hash = null;
        $existing->notarization_tx_hash = null;
        $existing->notarized_at = null;
        $existing->save();

        // Background: processo staccato (setsid+nohup) con php CLI esplicito.
        // PHP_BINARY sotto Apache/mod_php può essere inutilizzabile; usiamo php8.2.
        $artisan = base_path('artisan');
        $php = '/usr/bin/php8.2';
        if (! is_file($php)) {
            $php = '/usr/bin/php';
        }
        $logFile = storage_path('logs/auto-notarize.log');
        @touch($logFile);
        @chmod($logFile, 0664);
        $cmd = sprintf(
            'cd %s && setsid nohup %s %s certificates:auto-notarize %d >> %s 2>&1 < /dev/null &',
            escapeshellarg(base_path()),
            escapeshellarg($php),
            escapeshellarg($artisan),
            (int) $existing->id,
            escapeshellarg($logFile)
        );
        exec($cmd);

        echo json_encode([
            'ok' => true,
            'message' => 'Notarizzazione automatica avviata.',
            'certificate' => cert_payload($existing->fresh(), $siteBase),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'save_notarization') {
        $existing = ProductCertificate::query()->where('product_id', $productId)->first();
        if (! $existing) {
            throw new RuntimeException('Certificato non trovato.');
        }
        if (! $existing->pdf_sha256) {
            throw new RuntimeException('Genera prima il PDF da notarizzare.');
        }

        $hash = (string) ($_REQUEST['notarization_hash'] ?? '');
        $tx = (string) ($_REQUEST['notarization_tx_hash'] ?? '');
        $notes = isset($_REQUEST['notarization_notes']) ? (string) $_REQUEST['notarization_notes'] : null;

        $service = app(ProductCertificateService::class);
        $cert = $service->saveNotarization($existing, $hash, $tx, $notes);

        echo json_encode([
            'ok' => true,
            'message' => 'Notarizzazione salvata.',
            'certificate' => cert_payload($cert, $siteBase),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Azione non valida.']);
} catch (Throwable $e) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => $e->getMessage()]);
}
