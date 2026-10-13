<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCertificate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class ProductCertificateService
{
    public function __construct(
        private readonly ProductCertificateTextBuilder $builder,
        private readonly ProductCertificatePdfGenerator $pdfGenerator,
    ) {}

    public function findByAccessCode(string $code): ?ProductCertificate
    {
        return ProductCertificate::query()
            ->where('access_code', strtoupper(trim($code)))
            ->where('published', true)
            ->with('product')
            ->first();
    }

    /**
     * @return array{certificate: ProductCertificate, url: string, created: bool}
     */
    public function generateOrUpdate(
        Product $product,
        int $registryNumber,
        ?string $accessCode = null,
        ?string $bodyOverride = null,
    ): array {
        if ($registryNumber <= 0) {
            throw new RuntimeException('Numero registro commercio obbligatorio.');
        }

        $combined = trim(
            html_entity_decode(strip_tags((string) ($product->description ?? '')."\n".(string) ($product->short_description ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8')
        );
        $type = $this->builder->detectType((string) $product->name, $combined);

        $bodyText = trim($bodyOverride ?? $this->builder->build($product));
        if ($bodyOverride !== null) {
            $bodyText = $this->builder->stripLegalFooter($bodyText);
        }
        $legal = $this->builder->legalFooter($registryNumber, $type);
        $fullBody = trim($bodyText.'  '.$legal);

        $imageFilename = $this->resolveImageFilename($product);

        return DB::transaction(function () use ($product, $registryNumber, $accessCode, $fullBody, $imageFilename) {
            $existing = ProductCertificate::query()->where('product_id', $product->entity_id)->first();
            $created = $existing === null;

            $certificate = $existing ?? new ProductCertificate(['product_id' => $product->entity_id]);

            if ($accessCode !== null && $accessCode !== '') {
                $normalized = strtoupper(trim($accessCode));
                if ($certificate->access_code !== $normalized) {
                    $this->assertAccessCodeAvailable($normalized, $product->entity_id);
                }
                $certificate->access_code = $normalized;
            } elseif (! $certificate->exists || ! $certificate->access_code) {
                $certificate->access_code = $this->generateUniqueAccessCode();
            }

            $certificate->registry_number = $registryNumber;
            $certificate->body_text = $fullBody;
            $certificate->image_filename = $imageFilename;
            $certificate->product_sku = trim((string) $product->sku) ?: null;
            $certificate->product_name = trim((string) $product->name) ?: null;
            $certificate->published = true;

            // Ogni salvataggio rigenera il PDF: la notarizzazione va rifatta.
            $certificate->notarization_hash = null;
            $certificate->notarization_tx_hash = null;
            $certificate->notarized_at = null;
            $certificate->notarization_notes = null;
            $certificate->notarization_status = null;
            $certificate->notarization_started_at = null;
            $certificate->notarization_error = null;
            $certificate->pdf_sha256 = null;
            $certificate->score_conservazione = null;
            $certificate->score_rarita = null;
            $certificate->score_battuta = null;
            $certificate->score_metallo = null;
            $certificate->score_stile = null;
            $certificate->score_provenienza = null;
            $certificate->issued_on = now()->toDateString();

            $certificate->save();

            $certificate = $this->pdfGenerator->generate($certificate->fresh('product'), $product);

            return [
                'certificate' => $certificate->fresh('product'),
                'url' => $certificate->publicUrl(),
                'created' => $created,
            ];
        });
    }

    public function regeneratePdf(ProductCertificate $certificate): ProductCertificate
    {
        $certificate->score_conservazione = null;
        $certificate->score_rarita = null;
        $certificate->score_battuta = null;
        $certificate->score_metallo = null;
        $certificate->score_stile = null;
        $certificate->score_provenienza = null;
        $certificate->issued_on = now()->toDateString();
        $certificate->notarization_hash = null;
        $certificate->notarization_tx_hash = null;
        $certificate->notarized_at = null;
        $certificate->notarization_notes = null;
        $certificate->notarization_status = null;
        $certificate->notarization_started_at = null;
        $certificate->notarization_error = null;
        $certificate->save();

        return $this->pdfGenerator->generate($certificate->fresh('product'), $certificate->product);
    }

    /**
     * Salva esito notarizzazione semi-manuale (dopo firma MetaMask / Ylium).
     */
    public function saveNotarization(
        ProductCertificate $certificate,
        string $documentHash,
        string $txHash,
        ?string $notes = null,
    ): ProductCertificate {
        $documentHash = strtolower(ltrim(trim($documentHash), '0x'));
        $txHash = strtolower(ltrim(trim($txHash), '0x'));

        if (! preg_match('/^[a-f0-9]{64}$/', $documentHash)) {
            throw new RuntimeException('Hash documento non valido (attesi 32 byte hex).');
        }
        if (! preg_match('/^[a-f0-9]{64}$/', $txHash)) {
            throw new RuntimeException('Transaction hash non valido (attesi 32 byte hex).');
        }

        if ($certificate->pdf_sha256 && ! hash_equals($certificate->pdf_sha256, $documentHash)) {
            throw new RuntimeException(
                'L\'hash inserito non coincide con lo SHA-256 del PDF generato (0x'.$certificate->pdf_sha256.').'
            );
        }

        $certificate->notarization_hash = '0x'.$documentHash;
        $certificate->notarization_tx_hash = '0x'.$txHash;
        $certificate->notarized_at = now();
        $certificate->notarization_notes = $notes !== null ? trim($notes) : null;
        $certificate->notarization_status = 'confirmed';
        $certificate->notarization_started_at = $certificate->notarization_started_at ?: now();
        $certificate->notarization_error = null;
        $certificate->save();

        return $certificate->fresh();
    }

    public function importFromLegacyHtml(string $htmlPath): ?ProductCertificate
    {
        if (! is_file($htmlPath)) {
            return null;
        }

        $accessCode = pathinfo($htmlPath, PATHINFO_FILENAME);
        $html = file_get_contents($htmlPath);

        if (! preg_match('/imTextObject_22.*?<p[^>]*>(.*?)<\/p>/s', $html, $bodyMatch)) {
            return null;
        }

        $bodyHtml = $bodyMatch[1];
        $plain = html_entity_decode(strip_tags($bodyHtml), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plain = preg_replace('/\s+/u', ' ', trim($plain)) ?? '';

        if (! preg_match('/codice (\d+)/', $plain, $skuMatch)) {
            return null;
        }

        $sku = $skuMatch[1];
        $product = Product::query()->where('sku', $sku)->first();

        if (! $product) {
            return null;
        }

        preg_match("/src='([^']+\\.jpg)'/i", $html, $imgMatch);
        $imageFilename = isset($imgMatch[1]) ? basename($imgMatch[1]) : $sku.'.jpg';

        preg_match('/iscritta al n\. (\d+) del Registro/i', $plain, $regMatch);
        $registryNumber = isset($regMatch[1]) ? (int) $regMatch[1] : 0;

        $certificate = ProductCertificate::query()->firstOrNew(['product_id' => $product->entity_id]);
        $certificate->access_code = strtoupper($accessCode);
        $certificate->registry_number = $registryNumber;
        $certificate->body_text = $plain;
        $certificate->image_filename = $imageFilename;
        $certificate->product_sku = $sku;
        $certificate->product_name = trim((string) $product->name) ?: null;
        $certificate->published = true;
        $certificate->save();

        return $certificate;
    }

    private function resolveImageFilename(Product $product): ?string
    {
        $sku = trim((string) $product->sku);
        if ($sku === '') {
            return null;
        }

        $candidates = [
            $sku.'.jpg',
            $sku.'.jpeg',
        ];

        foreach ($candidates as $filename) {
            if (is_file(config('product_certificates.storage_path').'/'.$filename)) {
                return $filename;
            }
        }

        return $sku.'.jpg';
    }

    private function generateUniqueAccessCode(): string
    {
        do {
            $code = chr(random_int(65, 90)).str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (ProductCertificate::query()->where('access_code', $code)->exists());

        return $code;
    }

    private function assertAccessCodeAvailable(string $code, int $productId): void
    {
        if (! preg_match('/^[A-Z][0-9]{4,8}$/', $code)) {
            throw new RuntimeException('Codice accesso non valido (es. I19872, S111821).');
        }

        $exists = ProductCertificate::query()
            ->where('access_code', $code)
            ->where('product_id', '!=', $productId)
            ->exists();

        if ($exists) {
            throw new RuntimeException('Codice accesso già in uso: '.$code);
        }
    }
}
