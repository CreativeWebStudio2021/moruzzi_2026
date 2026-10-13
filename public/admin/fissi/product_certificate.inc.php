<?php

if (! defined('MORUZZI_PRODUCT_CERTIFICATE_BOOTSTRAP')) {
    define('MORUZZI_PRODUCT_CERTIFICATE_BOOTSTRAP', true);

    $laravelRoot = dirname(__DIR__, 3);
    require_once $laravelRoot.'/vendor/autoload.php';
    $app = require $laravelRoot.'/bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
}

use App\Models\ProductCertificate;

$pc_site_base = rtrim(config('app.url', 'https://www.moruzzi.it'), '/');
$pc_token = (string) config('product_certificates.webhook_secret');
$pc_existing = null;
$pc_registry = '';
$pc_access_code = '';
$pc_public_url = '';
$pc_error = '';

try {
    $pc_existing = ProductCertificate::query()->where('product_id', (int) $id_rec)->first();
    $pc_registry = (string) ($pc_existing?->registry_number ?? '');
    $pc_access_code = (string) ($pc_existing?->access_code ?? '');
    $pc_public_url = $pc_existing?->publicUrl() ?? '';
} catch (\Throwable $e) {
    $pc_error = $e->getMessage();
}

$pc_has_token = $pc_token !== '';
?>

<div class="mws-form-row" style="margin-top:24px; border-top:2px solid #E3E3E3; padding-top:16px;">
    <label class="mws-form-label">Certificato online<br /><i>(QR code / pagina /h/)</i></label>
    <div class="mws-form-item">
        <?php if ($pc_error !== ''): ?>
            <p style="color:#b00020;">Certificato online non disponibile: <?php echo htmlspecialchars($pc_error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php elseif (! $pc_has_token): ?>
            <p style="color:#b00020;">Configura <code>PRODUCT_CERTIFICATE_WEBHOOK_SECRET</code> o <code>DROPBOX_SYNC_WEBHOOK_SECRET</code> nel file .env per abilitare la generazione.</p>
        <?php else: ?>
            <div style="margin-bottom:10px;">
                <label for="certificate_registry_number" style="display:block; font-weight:600;">N. registro commercio *</label>
                <input type="text" id="certificate_registry_number" class="small" style="width:120px;" value="<?php echo htmlspecialchars((string) $pc_registry, ENT_QUOTES, 'UTF-8'); ?>" placeholder="es. 1884">
            </div>
            <div style="margin-bottom:10px;">
                <label for="certificate_access_code" style="display:block; font-weight:600;">Codice accesso URL</label>
                <input type="text" id="certificate_access_code" class="small" style="width:120px;" value="<?php echo htmlspecialchars((string) $pc_access_code, ENT_QUOTES, 'UTF-8'); ?>" placeholder="es. I19872">
                <small style="display:block; margin-top:4px;">Lascia vuoto per generarne uno nuovo. Il link sarà <?php echo htmlspecialchars($pc_site_base, ENT_QUOTES, 'UTF-8'); ?>/h/<em>codice</em>.html</small>
            </div>
            <?php if ($pc_public_url !== ''): ?>
                <p style="margin-bottom:10px;">
                    Certificato attivo:
                    <a href="<?php echo htmlspecialchars($pc_public_url, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($pc_public_url, ENT_QUOTES, 'UTF-8'); ?></a>
                </p>
            <?php endif; ?>
            <div style="margin-bottom:10px;">
                <input type="button" value="Anteprima testo" class="btn" onclick="productCertificatePreview()">
                <input type="button" value="Genera / aggiorna certificato" class="btn btn-danger" onclick="productCertificateGenerate()">
            </div>
            <div id="certificatePreviewBox" style="display:none; margin-top:10px; padding:12px; background:#f7f7f7; border-radius:6px; max-height:260px; overflow:auto; white-space:pre-wrap; font-size:13px;"></div>
            <script>
                const productCertificateBase = <?php echo json_encode($pc_site_base, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
                const productCertificateToken = <?php echo json_encode($pc_token, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
                const productCertificateProductId = <?php echo (int) $id_rec; ?>;

                function productCertificateParams() {
                    const registry = document.getElementById('certificate_registry_number').value.trim();
                    const accessCode = document.getElementById('certificate_access_code').value.trim();
                    if (!registry || !/^\d+$/.test(registry)) {
                        alert('Inserisci il numero di registro commercio (solo cifre).');
                        return null;
                    }
                    const params = new URLSearchParams({
                        token: productCertificateToken,
                        product_id: String(productCertificateProductId),
                        registry_number: registry,
                        format: 'json',
                    });
                    if (accessCode !== '') {
                        params.set('access_code', accessCode);
                    }
                    return params;
                }

                function productCertificatePreview() {
                    const params = productCertificateParams();
                    if (!params) return;
                    fetch(productCertificateBase + '/internal/product-certificate/preview?' + params.toString())
                        .then(r => r.json())
                        .then(data => {
                            const box = document.getElementById('certificatePreviewBox');
                            if (!data.ok) {
                                alert(data.message || 'Anteprima non disponibile.');
                                return;
                            }
                            box.style.display = 'block';
                            box.textContent = data.body_text || '';
                        })
                        .catch(() => alert('Errore durante l\'anteprima.'));
                }

                function productCertificateGenerate() {
                    const params = productCertificateParams();
                    if (!params) return;
                    if (!confirm('Generare o aggiornare il certificato online per questo prodotto?')) return;
                    window.open(productCertificateBase + '/internal/product-certificate/generate?' + params.toString(), '_blank');
                }
            </script>
        <?php endif; ?>
    </div>
</div>
