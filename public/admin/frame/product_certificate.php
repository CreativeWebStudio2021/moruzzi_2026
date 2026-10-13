<?php
session_start();

if (! isset($_SESSION['loggato']) || $_SESSION['loggato'] !== 'si') {
    echo 'Accesso non autorizzato.';
    exit;
}

require_once __DIR__.'/../config/db.php';

$id_prod = isset($_GET['id_prod']) ? (int) $_GET['id_prod'] : 0;
if ($id_prod <= 0) {
    echo 'Prodotto non valido.';
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <base href="<?php echo htmlspecialchars($http.'://'.$ind_sito.'/admin/', ENT_QUOTES, 'UTF-8'); ?>" />
    <title>Certificato online</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/mws-style.css" media="screen">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        body { background:#fff; padding:24px; font-family:Arial,sans-serif; color:#333; }
        h2 { margin:0 0 8px; font-size:22px; }
        h3 { margin:22px 0 8px; font-size:16px; border-bottom:1px solid #ddd; padding-bottom:4px; }
        .meta { color:#666; margin-bottom:18px; font-size:13px; }
        label { display:block; font-weight:bold; margin:12px 0 4px; }
        input[type=text], textarea { width:100%; max-width:520px; padding:6px 8px; box-sizing:border-box; }
        textarea { min-height:60px; }
        .hint { font-size:12px; color:#777; margin-top:4px; }
        .help-toggle { display:inline-block; width:20px; height:20px; border-radius:50%; background:#6c757d; color:#fff; text-align:center; line-height:20px; font-weight:bold; font-size:13px; cursor:pointer; margin-left:6px; vertical-align:middle; }
        .help-toggle:hover { background:#495057; }
        #notarizeHelp { display:none; margin-top:10px; }
        .frame-spacer { width:100%; height:80px; background:#fff; display:block; }
        #legalFooterBox {
            margin-top:10px; padding:10px; background:#f9f9f9; border:1px solid #ddd;
            font-size:13px; line-height:1.5; display:none;
        }
        #legalFooterBox strong { display:block; margin-bottom:6px; font-size:12px; color:#555; }
        .infoBox { margin:12px 0; padding:10px; background:#eef7e0; border:1px solid #c5df9a; display:none; word-break:break-all; }
        .infoBox a { color:#406000; font-weight:bold; }
        .warnBox { margin:12px 0; padding:10px; background:#fff8e6; border:1px solid #e6c97a; display:none; word-break:break-all; font-size:13px; }
        .okBox { margin:12px 0; padding:10px; background:#e8f6ec; border:1px solid #9ed0ad; display:none; word-break:break-all; font-size:13px; }
        .actions { margin-top:18px; display:flex; gap:10px; flex-wrap:wrap; }
        .err { color:#b00020; margin-top:10px; }
        .ok { color:#0a7a2f; margin-top:10px; }
        code { background:#f0f0f0; padding:1px 4px; }
        #notarizeSection { display:none; }
        #body_text { width:100%; min-height:130px; max-width:100%; font-family:inherit; line-height:1.5; }
        #body_text[readonly] { background:#f5f5f5; color:#666; }
    </style>
</head>
<body>
    <h2>Certificato online + PDF / notarizzazione</h2>
    <div class="meta" id="productMeta">Caricamento…</div>

    <div class="infoBox" id="urlBox">
        Pagina pubblica:<br>
        <a id="publicUrl" href="#" target="_blank" rel="noopener"></a>
    </div>

    <label for="registry_number">N. registro commercio *</label>
    <input type="text" id="registry_number" placeholder="es. 1884" autocomplete="off">

    <label for="access_code">Codice accesso URL</label>
    <input type="text" id="access_code" placeholder="es. I19872" autocomplete="off">
    <div class="hint">Lascia vuoto in creazione per generarne uno nuovo. URL: /h/<em>codice</em>.html</div>

    <label for="body_text">Testo certificato (parte descrittiva)</label>
    <textarea id="body_text" placeholder="Anteprima modificabile alla prima emissione."></textarea>
    <div class="hint" id="bodyHint">Puoi modificare il testo prima del primo salvataggio.</div>

    <div id="legalFooterBox">
        <strong>Testo legale (aggiunto automaticamente)</strong>
        <div id="legalFooterText"></div>
    </div>

    <div class="actions">
        <button type="button" class="btn btn-warning" id="btnNewCertification" style="display:none;">Nuova certificazione (annulla precedente)</button>
        <button type="button" class="btn btn-danger" id="btnSave">Salva certificato + PDF</button>
        <a class="btn btn-primary" id="btnOpenCertificatePage" href="#" target="_blank" rel="noopener" style="display:none;">Vai alla pagina del certificato</a>
        <button type="button" class="btn" onclick="parent.$('#mask').fadeOut();">Chiudi</button>
    </div>

    <div id="message" class="err"></div>

    <div id="notarizeSection">
        <h3>PDF</h3>
        <div class="warnBox" id="pdfBox" style="display:block">
            <div>URL: <a id="pageUrl" href="#" target="_blank" rel="noopener">—</a></div>
            <div style="margin-top:6px">File: <a id="pdfLink" href="#" target="_blank" rel="noopener">—</a></div>
            <div class="actions" style="margin-top:10px">
                <button type="button" class="btn" id="btnRegenPdf">Rigenera PDF</button>
                <button type="button" class="btn btn-success" id="btnAutoNotarize">Notarizza</button>
                <span class="help-toggle" id="notarizeHelpToggle" title="Informazioni sulla notarizzazione">?</span>
            </div>
            <div class="hint" id="autoNotarizeStatus" style="margin-top:8px; display:none;"></div>
        </div>

        <div id="notarizeHelp" class="hint" style="max-width:640px; line-height:1.55; padding:10px; background:#f9f9f9; border:1px solid #ddd;">
            <strong>A cosa serve la notarizzazione.</strong>
            Registra l’impronta digitale (hash) del PDF sulla blockchain Polygon:
            chiunque può verificare in seguito che il certificato non è stato modificato dopo la firma.
            <br><br>
            <strong>Come funziona.</strong>
            <br>Clicca «Notarizza» e il sistema invia automaticamente la transazione alla blockchain.
            Attendi pochi secondi: vedrai comparire il transaction hash e lo stato «confermato».
            Il testo del certificato viene incluso automaticamente nelle note della notarizzazione.
        </div>

        <div class="okBox" id="notarizedBox"></div>
        <div class="actions" id="verifyActions" style="display:none;">
            <a class="btn" id="btnVerifyPage" href="#" target="_blank" rel="noopener">Pagina verifica pubblica</a>
        </div>
        <div class="frame-spacer" aria-hidden="true"></div>
    </div>

    <script>
        const productId = <?php echo (int) $id_prod; ?>;
        let existing = false;
        let replaceExisting = false;

        function setMessage(text, ok) {
            const el = document.getElementById('message');
            el.className = ok ? 'ok' : 'err';
            el.textContent = text || '';
        }

        function showLegalFooter(text) {
            const box = document.getElementById('legalFooterBox');
            const el = document.getElementById('legalFooterText');
            if (!text) {
                box.style.display = 'none';
                el.textContent = '';
                return;
            }
            box.style.display = 'block';
            el.textContent = text;
        }

        function showUrl(url) {
            const openBtn = document.getElementById('btnOpenCertificatePage');
            if (!url) {
                openBtn.style.display = 'none';
                openBtn.href = '#';
                return;
            }
            const box = document.getElementById('urlBox');
            const link = document.getElementById('publicUrl');
            link.href = url;
            link.textContent = url;
            box.style.display = 'block';
            openBtn.href = url;
            openBtn.style.display = 'inline-block';
        }

        function applyCertificate(cert) {
            if (!cert) {
                document.getElementById('notarizeSection').style.display = 'none';
                document.getElementById('btnNewCertification').style.display = 'none';
                document.getElementById('btnOpenCertificatePage').style.display = 'none';
                document.getElementById('body_text').readOnly = false;
                document.getElementById('bodyHint').textContent = 'Puoi modificare il testo prima del primo salvataggio.';
                return;
            }
            existing = true;
            replaceExisting = false;
            document.getElementById('notarizeSection').style.display = 'block';
            document.getElementById('btnNewCertification').style.display = 'inline-block';
            document.getElementById('registry_number').value = cert.registry_number || '';
            document.getElementById('access_code').value = cert.access_code || '';
            document.getElementById('body_text').value = cert.core_body || cert.body_text || '';
            document.getElementById('body_text').readOnly = true;
            document.getElementById('bodyHint').textContent = 'Testo bloccato: per modificarlo devi creare una nuova certificazione.';
            showUrl(cert.url);
            showLegalFooter(cert.legal_footer || '');

            const pageUrl = document.getElementById('pageUrl');
            if (cert.url) {
                pageUrl.href = cert.url;
                pageUrl.textContent = cert.url;
            } else {
                pageUrl.href = '#';
                pageUrl.textContent = '—';
            }

            if (cert.pdf_url) {
                const pdfLink = document.getElementById('pdfLink');
                pdfLink.href = cert.pdf_url;
                pdfLink.textContent = cert.pdf_url;
            }

            const statusBox = document.getElementById('autoNotarizeStatus');
            const btnAuto = document.getElementById('btnAutoNotarize');
            const status = cert.notarization_status;
            const error = cert.notarization_error;
            if (status === 'pending') {
                statusBox.style.display = 'block';
                statusBox.textContent = 'Notarizzazione automatica in corso…';
                btnAuto.disabled = true;
                startAutoPolling();
            } else if (status === 'failed') {
                statusBox.style.display = 'block';
                statusBox.textContent = 'Notarizzazione automatica fallita: ' + (error || 'errore non specificato');
                btnAuto.disabled = false;
            } else if (status === 'confirmed') {
                statusBox.style.display = 'block';
                statusBox.textContent = 'Notarizzazione completata.';
                btnAuto.disabled = true;
            } else {
                statusBox.style.display = 'none';
                btnAuto.disabled = false;
            }
            if (cert.verify_url) {
                document.getElementById('btnVerifyPage').href = cert.verify_url;
            }

            const nb = document.getElementById('notarizedBox');
            if (cert.notarized) {
                nb.style.display = 'block';
                document.getElementById('verifyActions').style.display = 'flex';
                nb.innerHTML = 'Notarizzato il <strong>' + (cert.notarized_at || '') + '</strong><br>' +
                    'Hash: <code>' + (cert.notarization_hash || '') + '</code><br>' +
                    (cert.polygonscan_url
                        ? ('Tx: <a href="' + cert.polygonscan_url + '" target="_blank" rel="noopener">' + cert.notarization_tx_hash + '</a>')
                        : ('Tx: <code>' + (cert.notarization_tx_hash || '') + '</code>'));
            } else {
                nb.style.display = 'none';
                nb.innerHTML = '';
            }
        }

        function load() {
            $.getJSON('ajax/productCertificate.php', { action: 'get', product_id: productId })
                .done(function (data) {
                    if (!data.ok) {
                        setMessage(data.message || 'Errore caricamento');
                        return;
                    }
                    document.getElementById('productMeta').textContent =
                        (data.product.name || '') + ' — SKU ' + (data.product.sku || '');

                    if (data.certificate) {
                        applyCertificate(data.certificate);
                    } else {
                        document.getElementById('body_text').value = data.core_body || data.preview_body || '';
                                showLegalFooter(data.legal_footer || '');
                    }
                })
                .fail(function () {
                    setMessage('Errore di rete durante il caricamento.');
                });
        }

        $('#btnNewCertification').on('click', function () {
            if (!confirm('Questa operazione annulla la certificazione precedente e ne crea una nuova. Continuare?')) {
                return;
            }
            replaceExisting = true;
            existing = false;
            $('#body_text').prop('readonly', false);
            $('#bodyHint').text('Modifica il testo e salva: verrà creata una nuova certificazione.');
            setMessage('Modalità nuova certificazione attivata. Alla conferma verrà annullata la notarizzazione precedente.', true);
        });

        $('#btnSave').on('click', function () {
            const registry = $('#registry_number').val().trim();
            const accessCode = $('#access_code').val().trim();
            const bodyText = $('#body_text').val().trim();

            if (!registry || !/^\d+$/.test(registry)) {
                setMessage('Inserisci il numero di registro commercio (solo cifre).');
                return;
            }

            if (existing && !replaceExisting) {
                setMessage('Per modificare un certificato già esistente usa "Nuova certificazione (annulla precedente)".');
                return;
            }

            setMessage('');
            $.ajax({
                url: 'ajax/productCertificate.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'save',
                    product_id: productId,
                    registry_number: registry,
                    access_code: accessCode,
                    body_text: bodyText,
                    replace_existing: replaceExisting ? 1 : 0
                }
            }).done(function (data) {
                if (!data.ok) {
                    setMessage(data.message || 'Salvataggio non riuscito');
                    return;
                }
                applyCertificate(data.certificate);
                setMessage(
                    (data.created ? 'Certificato creato.' : 'Certificato aggiornato.') +
                    (data.certificate && data.certificate.pdf_sha256 ? ' PDF pronto per la notarizzazione.' : ''),
                    true
                );

                if (parent && typeof parent.markProductCertified === 'function') {
                    parent.markProductCertified(productId, data.url, data.access_code);
                }
            }).fail(function (xhr) {
                let msg = 'Errore durante il salvataggio.';
                try {
                    const j = JSON.parse(xhr.responseText);
                    if (j.message) msg = j.message;
                } catch (e) {}
                setMessage(msg);
            });
        });

        $('#btnRegenPdf').on('click', function () {
            if (!confirm('Rigenerare il PDF annulla la notarizzazione precedente. Continuare?')) return;
            setMessage('');
            $.ajax({
                url: 'ajax/productCertificate.php',
                method: 'POST',
                dataType: 'json',
                data: { action: 'generate_pdf', product_id: productId }
            }).done(function (data) {
                if (!data.ok) {
                    setMessage(data.message || 'Generazione PDF fallita');
                    return;
                }
                applyCertificate(data.certificate);
                setMessage(data.message || 'PDF generato.', true);
            }).fail(function (xhr) {
                let msg = 'Errore generazione PDF.';
                try {
                    const j = JSON.parse(xhr.responseText);
                    if (j.message) msg = j.message;
                } catch (e) {}
                setMessage(msg);
            });
        });

        let autoPollTimer = null;
        function startAutoPolling() {
            if (autoPollTimer) return;
            autoPollTimer = setInterval(() => {
                $.getJSON('ajax/productCertificate.php', { action: 'get', product_id: productId })
                    .done(function (data) {
                        if (!data.ok || !data.certificate) return;
                        const s = data.certificate.notarization_status;
                        if (s === 'confirmed' || s === 'failed') {
                            clearInterval(autoPollTimer);
                            autoPollTimer = null;
                            applyCertificate(data.certificate);
                        }
                    });
            }, 3000);
        }

        $('#btnAutoNotarize').on('click', function () {
            const btn = this;
            btn.disabled = true;
            setMessage('');

            const notes = $('#notarization_notes').val();
            $.ajax({
                url: 'ajax/productCertificate.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'auto_notarize_start',
                    product_id: productId,
                    notarization_notes: notes
                }
            }).done(function (data) {
                if (!data.ok) {
                    setMessage(data.message || 'Avvio notarizzazione fallito');
                    btn.disabled = false;
                    return;
                }
                if (data.certificate) {
                    applyCertificate(data.certificate);
                }
                setMessage(data.message || 'Notarizzazione in corso…', true);
                startAutoPolling();
            }).fail(function (xhr) {
                let msg = 'Errore avvio notarizzazione automatica.';
                try {
                    const j = JSON.parse(xhr.responseText);
                    if (j.message) msg = j.message;
                } catch (e) {}
                setMessage(msg);
                btn.disabled = false;
            });
        });

        // Toggle help
        $('#notarizeHelpToggle').on('click', function () {
            $('#notarizeHelp').slideToggle(200);
        });

        load();
    </script>
</body>
</html>
