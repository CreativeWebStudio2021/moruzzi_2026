<?php

namespace App\Jobs;

use App\Models\ProductCertificate;
use App\Services\ProductCertificateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;
use Symfony\Component\Process\Process;

class AutoNotarizeProductCertificateJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly int $certificateId,
    ) {}

    public function handle(ProductCertificateService $service): void
    {
        $certificate = ProductCertificate::query()->find($this->certificateId);
        if (! $certificate) {
            throw new RuntimeException('Certificato non trovato: '.$this->certificateId);
        }

        $enabled = (bool) config('product_certificates.ylium_auto_enabled', false);
        if (! $enabled) {
            throw new RuntimeException('Notarizzazione automatica non abilitata.');
        }

        $rpcUrl = (string) config('product_certificates.ylium_polygon_rpc_url', '');
        $privateKey = (string) config('product_certificates.ylium_auto_private_key', '');
        $contractAddress = (string) config('product_certificates.ylium_notarization_contract_address', '');
        $delegeeAddress = (string) config('product_certificates.ylium_delegee_address', '');

        if ($rpcUrl === '' || $privateKey === '' || $contractAddress === '') {
            throw new RuntimeException('Config blockchain mancante (YLIUM_AUTO_PRIVATE_KEY / YLIUM_POLYGON_RPC_URL / YLIUM_NOTARIZATION_CONTRACT_ADDRESS).');
        }

        if (! $certificate->pdf_sha256) {
            throw new RuntimeException('PDF SHA-256 non disponibile sul certificato.');
        }

        // Stato controllato lato job per evitare doppie esecuzioni.
        // Se già confermata non rilanciamo.
        if ($certificate->notarization_status === 'confirmed') {
            return;
        }

        $note = (string) ($certificate->notarization_notes ?? '');
        $noteB64 = base64_encode($note);

        $hash = strtolower(ltrim(trim((string) $certificate->pdf_sha256), '0x'));
        if (! preg_match('/^[a-f0-9]{64}$/', $hash)) {
            throw new RuntimeException('SHA-256 PDF non valido: '.$hash);
        }

        $pdata0 = (string) config('product_certificates.ylium_zero_pdata0', '0x'.str_repeat('0', 64));
        if (! str_starts_with($pdata0, '0x')) {
            $pdata0 = '0x'.$pdata0;
        }

        $nodeScript = base_path('scripts/ylium_auto_notarize.mjs');
        if (! is_file($nodeScript)) {
            throw new RuntimeException('Node script notarization mancante: '.$nodeScript);
        }

        try {
            $process = new Process([
                'node',
                $nodeScript,
                '--rpc', $rpcUrl,
                '--privateKey', $privateKey,
                '--contract', $contractAddress,
                '--hash', '0x'.$hash,
                '--pdata0', $pdata0,
                '--noteB64', $noteB64,
                '--delegee', $delegeeAddress,
            ]);

            // La notarizzazione può richiedere un po’: lasciamo un budget generoso.
            $process->setTimeout(240);
            $process->run();

            $stdout = trim((string) $process->getOutput());
            $stderr = trim((string) $process->getErrorOutput());

            if (! $process->isSuccessful()) {
                $decodedErr = json_decode($stderr, true);
                $safeMessage = is_array($decodedErr) && ! empty($decodedErr['error'])
                    ? (string) $decodedErr['error']
                    : ($stderr !== '' ? $stderr : $stdout);
                $safeMessage = Str::limit(preg_replace('/\s+/u', ' ', trim($safeMessage)) ?? 'Errore notarizzazione', 1000, '');
                throw new RuntimeException($safeMessage);
            }

            $decoded = json_decode($stdout, true);
            if (! is_array($decoded) || empty($decoded['txHash'])) {
                throw new RuntimeException('Output script non valido: '.Str::limit($stdout.$stderr, 1000, ''));
            }

            $txHash = (string) $decoded['txHash'];
            $txHash = strtolower(ltrim(trim($txHash), '0x'));

            if (! preg_match('/^[a-f0-9]{64}$/', $txHash)) {
                throw new RuntimeException('Transaction hash non valido: '.$txHash);
            }

            // Conferma e persistenza su DB
            $service->saveNotarization($certificate->fresh(), $hash, $txHash, $note !== '' ? $note : null);
        } catch (Throwable $e) {
            // Evita che l'eccezione termini in modo “silenzioso”: salviamo lo stato.
            Log::error('AutoNotarize failed', [
                'certificate_id' => $this->certificateId,
                'error' => $e->getMessage(),
            ]);

            $certificate->notarization_status = 'failed';
            $msg = trim($e->getMessage());
            // Sanitizza eventuali segreti accidentalmente presenti nei messaggi.
            $msg = preg_replace('/(0x)?[a-fA-F0-9]{64}/', '[redacted]', $msg) ?? $msg;
            $certificate->notarization_error = Str::limit($msg, 2000, '');
            $certificate->save();

            throw $e;
        }
    }
}

