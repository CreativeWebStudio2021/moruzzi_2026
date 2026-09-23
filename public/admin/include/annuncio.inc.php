<?php
/**
 * Messaggio sito (banner sotto testata).
 * admin.php?cmd=annuncio
 */
$laravelRoot = dirname(__DIR__, 3);
if (! defined('MORUZZI_SITE_ANNOUNCEMENT_BOOTSTRAP')) {
    define('MORUZZI_SITE_ANNOUNCEMENT_BOOTSTRAP', true);
    require_once $laravelRoot.'/vendor/autoload.php';
    $app = require $laravelRoot.'/bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
}

use App\Models\SiteAnnouncement;
use Illuminate\Support\Carbon;

$okMsg = '';
$errMsg = '';

$localeLabels = [
    'it' => 'Italiano',
    'en' => 'English',
    'fr' => 'Français',
    'de' => 'Deutsch',
    'es' => 'Español',
];

try {
    $announcement = SiteAnnouncement::current();
    if (! $announcement) {
        $announcement = SiteAnnouncement::query()->create([
            'enabled' => false,
            'outside_italy_only' => false,
            'message' => null,
            'messages' => null,
            'starts_at' => null,
            'ends_at' => null,
        ]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_announcement'])) {
        $enabled = isset($_POST['enabled']) && (string) $_POST['enabled'] === '1';
        $outsideItalyOnly = isset($_POST['outside_italy_only']) && (string) $_POST['outside_italy_only'] === '1';
        $startsRaw = trim((string) ($_POST['starts_at'] ?? ''));
        $endsRaw = trim((string) ($_POST['ends_at'] ?? ''));

        $messages = [];
        $postedMessages = $_POST['messages'] ?? [];
        if (! is_array($postedMessages)) {
            $postedMessages = [];
        }
        foreach (SiteAnnouncement::LOCALES as $locale) {
            $html = SiteAnnouncement::sanitizeHtml((string) ($postedMessages[$locale] ?? ''));
            if (! SiteAnnouncement::isBlankHtml($html)) {
                $messages[$locale] = $html;
            }
        }

        $reopenLabels = [];
        $postedReopen = $_POST['reopen_labels'] ?? [];
        if (! is_array($postedReopen)) {
            $postedReopen = [];
        }
        foreach (SiteAnnouncement::LOCALES as $locale) {
            $label = trim((string) ($postedReopen[$locale] ?? ''));
            if ($label !== '') {
                if (mb_strlen($label) > 120) {
                    $label = mb_substr($label, 0, 120);
                }
                $reopenLabels[$locale] = $label;
            }
        }

        $startsAt = null;
        $endsAt = null;
        if ($startsRaw !== '') {
            $startsAt = Carbon::createFromFormat('Y-m-d\TH:i', $startsRaw) ?: Carbon::parse($startsRaw);
        }
        if ($endsRaw !== '') {
            $endsAt = Carbon::createFromFormat('Y-m-d\TH:i', $endsRaw) ?: Carbon::parse($endsRaw);
        }

        if ($startsAt && $endsAt && $endsAt->lt($startsAt)) {
            throw new RuntimeException('La data di fine deve essere successiva alla data di inizio.');
        }

        if ($enabled && $messages === []) {
            throw new RuntimeException('Per attivare il messaggio inserisci almeno un testo (consigliato: italiano).');
        }

        $announcement->enabled = $enabled;
        $announcement->outside_italy_only = $outsideItalyOnly;
        $announcement->messages = $messages !== [] ? $messages : null;
        // Retrocompatibilità: colonna message = testo italiano
        $announcement->message = $messages['it'] ?? null;
        $announcement->reopen_labels = $reopenLabels !== [] ? $reopenLabels : null;
        $announcement->reopen_label = $reopenLabels['it'] ?? null;
        $announcement->starts_at = $startsAt;
        $announcement->ends_at = $endsAt;
        $announcement->save();

        $okMsg = 'Messaggio salvato.';
    }

    $announcement->refresh();
} catch (Throwable $e) {
    $errMsg = $e->getMessage();
    $announcement = $announcement ?? null;
}

function annuncio_dt_local(?Carbon $dt): string
{
    if (! $dt) {
        return '';
    }

    return $dt->format('Y-m-d\TH:i');
}

$isActiveNow = $announcement && $announcement->isActive();
$inactiveReason = $announcement ? $announcement->inactiveReason() : null;
$messagesMap = $announcement ? $announcement->messagesMap() : [];
$reopenLabelsMap = $announcement ? $announcement->reopenLabelsMap() : [];
?>

<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span class="mws-i-24 i-create">Messaggio sito (banner pubblico)</span>
    </div>
    <div class="mws-panel-body">
        <div class="mws-panel-content">
            <p style="margin:0 0 16px; color:#555; line-height:1.5;">
                Messaggio mostrato su tutte le pagine pubbliche, subito sotto la testata.
                Se attivo e nella finestra di date, resta visibile finché il visitatore non lo chiude
                (per la sessione). Può riaprirlo con un pulsante dedicato.
            </p>

            <?php if ($okMsg !== ''): ?>
                <div style="margin-bottom:14px; padding:10px; background:#e8f6ec; border:1px solid #9ed0ad;"><?php echo htmlspecialchars($okMsg, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <?php if ($errMsg !== ''): ?>
                <div style="margin-bottom:14px; padding:10px; background:#fdecea; border:1px solid #e8a0a0; color:#8a1f1f;"><?php echo htmlspecialchars($errMsg, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if ($announcement): ?>
                <?php if ($isActiveNow): ?>
                    <div class="annuncio-status annuncio-status--on" role="status">
                        <span class="annuncio-status__badge">ATTIVO</span>
                        <div class="annuncio-status__body">
                            <strong>Stato attuale: VISIBILE ora sul sito</strong>
                            <?php if ($announcement->outside_italy_only): ?>
                                <span class="annuncio-status__detail">— solo visitatori fuori dall’Italia</span>
                            <?php else: ?>
                                <span class="annuncio-status__detail">— tutti i visitatori</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="annuncio-status annuncio-status--off" role="status">
                        <span class="annuncio-status__badge">NON VISIBILE</span>
                        <div class="annuncio-status__body">
                            <strong>Stato attuale: non visibile</strong>
                            <span class="annuncio-status__detail">(<?php echo htmlspecialchars((string) $inactiveReason, ENT_QUOTES, 'UTF-8'); ?>)</span>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="post" action="admin.php?cmd=annuncio" class="mws-form">
                    <style>
                        .annuncio-status {
                            display: flex;
                            align-items: stretch;
                            gap: 0;
                            margin-bottom: 18px;
                            border-radius: 6px;
                            overflow: hidden;
                            border: 2px solid;
                            font-size: 15px;
                            line-height: 1.4;
                        }
                        .annuncio-status--on {
                            border-color: #1b7a3a;
                            background: #e8f8ee;
                            color: #0d5c2a;
                        }
                        .annuncio-status--off {
                            border-color: #b53a2e;
                            background: #fdecea;
                            color: #7a1f18;
                        }
                        .annuncio-status__badge {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            padding: 14px 16px;
                            font-weight: 800;
                            font-size: 13px;
                            letter-spacing: .04em;
                            text-transform: uppercase;
                            white-space: nowrap;
                            color: #fff;
                        }
                        .annuncio-status--on .annuncio-status__badge { background: #1b7a3a; }
                        .annuncio-status--off .annuncio-status__badge { background: #b53a2e; }
                        .annuncio-status__body {
                            padding: 14px 16px;
                            flex: 1;
                        }
                        .annuncio-status__detail {
                            display: inline;
                            font-weight: 600;
                            opacity: .9;
                        }
                        .annuncio-switch {
                            display: inline-flex;
                            align-items: center;
                            gap: 12px;
                            cursor: pointer;
                            user-select: none;
                            font-weight: normal;
                        }
                        .annuncio-switch input {
                            position: absolute;
                            opacity: 0;
                            width: 0;
                            height: 0;
                        }
                        .annuncio-switch__track {
                            position: relative;
                            width: 52px;
                            height: 28px;
                            background: #c5c5c5;
                            border-radius: 999px;
                            transition: background .2s ease;
                            flex-shrink: 0;
                            box-shadow: inset 0 1px 3px rgba(0,0,0,.15);
                        }
                        .annuncio-switch__thumb {
                            position: absolute;
                            top: 3px;
                            left: 3px;
                            width: 22px;
                            height: 22px;
                            background: #fff;
                            border-radius: 50%;
                            transition: transform .2s ease;
                            box-shadow: 0 1px 3px rgba(0,0,0,.25);
                        }
                        .annuncio-switch input:checked + .annuncio-switch__track {
                            background: #5a9e3a;
                        }
                        .annuncio-switch input:checked + .annuncio-switch__track .annuncio-switch__thumb {
                            transform: translateX(24px);
                        }
                        .annuncio-switch__text strong {
                            display: inline-block;
                            min-width: 28px;
                        }
                        .annuncio-switch__hint {
                            display: block;
                            font-size: 12px;
                            color: #777;
                            margin-top: 2px;
                        }
                        .annuncio-langs {
                            display: flex;
                            flex-direction: column;
                            gap: 14px;
                            max-width: 760px;
                        }
                        .annuncio-lang {
                            border: 1px solid #ddd;
                            border-radius: 4px;
                            background: #fafafa;
                            padding: 10px 12px;
                        }
                        .annuncio-lang__label {
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            font-weight: 700;
                            margin-bottom: 6px;
                            color: #333;
                        }
                        .annuncio-lang__code {
                            display: inline-block;
                            font-size: 11px;
                            font-weight: 800;
                            letter-spacing: .03em;
                            text-transform: uppercase;
                            background: #333;
                            color: #fff;
                            padding: 2px 6px;
                            border-radius: 3px;
                        }
                        .annuncio-lang textarea {
                            width: 100%;
                            box-sizing: border-box;
                            min-height: 100px;
                        }
                        .annuncio-lang .cke {
                            width: 100% !important;
                        }
                    </style>
                    <div class="mws-form-row">
                        <label class="mws-form-label">Attivo</label>
                        <div class="mws-form-item clearfix">
                            <label class="annuncio-switch" for="announcement_enabled">
                                <input type="checkbox" id="announcement_enabled" name="enabled" value="1" <?php echo $announcement->enabled ? 'checked' : ''; ?>>
                                <span class="annuncio-switch__track" aria-hidden="true">
                                    <span class="annuncio-switch__thumb"></span>
                                </span>
                                <span class="annuncio-switch__text">
                                    <strong id="announcement_enabled_label"><?php echo $announcement->enabled ? 'ON' : 'OFF'; ?></strong>
                                    <span class="annuncio-switch__hint">Mostra il messaggio (entro le date sotto)</span>
                                </span>
                            </label>
                            <script>
                                (function () {
                                    var input = document.getElementById('announcement_enabled');
                                    var label = document.getElementById('announcement_enabled_label');
                                    if (!input || !label) return;
                                    function sync() { label.textContent = input.checked ? 'ON' : 'OFF'; }
                                    input.addEventListener('change', sync);
                                    sync();
                                })();
                            </script>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label">Solo fuori Italia</label>
                        <div class="mws-form-item clearfix">
                            <label class="annuncio-switch" for="announcement_outside_italy">
                                <input type="checkbox" id="announcement_outside_italy" name="outside_italy_only" value="1" <?php echo $announcement->outside_italy_only ? 'checked' : ''; ?>>
                                <span class="annuncio-switch__track" aria-hidden="true">
                                    <span class="annuncio-switch__thumb"></span>
                                </span>
                                <span class="annuncio-switch__text">
                                    <strong id="announcement_outside_italy_label"><?php echo $announcement->outside_italy_only ? 'ON' : 'OFF'; ?></strong>
                                    <span class="annuncio-switch__hint">Se ON, il banner è nascosto ai visitatori in Italia (rilevamento via Cloudflare)</span>
                                </span>
                            </label>
                            <script>
                                (function () {
                                    var input = document.getElementById('announcement_outside_italy');
                                    var label = document.getElementById('announcement_outside_italy_label');
                                    if (!input || !label) return;
                                    function sync() { label.textContent = input.checked ? 'ON' : 'OFF'; }
                                    input.addEventListener('change', sync);
                                    sync();
                                })();
                            </script>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label">Testo messaggio</label>
                        <div class="mws-form-item clearfix">
                            <div class="annuncio-langs">
                                <?php foreach ($localeLabels as $code => $label): ?>
                                    <div class="annuncio-lang">
                                        <label class="annuncio-lang__label" for="announcement_message_<?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>">
                                            <span class="annuncio-lang__code"><?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?></span>
                                            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                                            <?php if ($code === 'it'): ?>
                                                <span style="font-weight:500; color:#777; font-size:12px;">(fallback per tutti se unico)</span>
                                            <?php elseif ($code === 'en'): ?>
                                                <span style="font-weight:500; color:#777; font-size:12px;">(fallback per le altre lingue)</span>
                                            <?php endif; ?>
                                        </label>
                                        <textarea
                                            class="annuncio-ckeditor"
                                            id="announcement_message_<?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>"
                                            name="messages[<?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>]"
                                            rows="5"
                                        ><?php echo htmlspecialchars((string) ($messagesMap[$code] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div style="font-size:12px; color:#777; margin-top:8px; max-width:760px; line-height:1.45;">
                                Editor semplificato: grassetto, corsivo, sottolineato, elenchi e link.<br>
                                Se c’è solo l’italiano, viene mostrato a tutti. Se c’è anche l’inglese, le lingue senza testo proprio vedono l’inglese. Altrimenti ogni lingua mostra il proprio testo.
                            </div>
                            <script>
                                (function () {
                                    if (typeof CKEDITOR === 'undefined') return;
                                    var cfg = {
                                        language: 'it',
                                        height: 140,
                                        resize_enabled: true,
                                        removePlugins: 'elementspath,image,flash,iframe,smiley,specialchar,pagebreak,forms,about',
                                        removeButtons: '',
                                        toolbar: [
                                            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', '-', 'RemoveFormat'] },
                                            { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
                                            { name: 'links', items: ['Link', 'Unlink'] },
                                            { name: 'clipboard', items: ['Undo', 'Redo'] }
                                        ],
                                        enterMode: CKEDITOR.ENTER_P,
                                        shiftEnterMode: CKEDITOR.ENTER_BR,
                                        forcePasteAsPlainText: false,
                                        allowedContent: 'p br strong b em i u ul ol li; a[!href,target,rel]'
                                    };
                                    var nodes = document.querySelectorAll('textarea.annuncio-ckeditor');
                                    for (var i = 0; i < nodes.length; i++) {
                                        if (CKEDITOR.instances[nodes[i].id]) {
                                            CKEDITOR.instances[nodes[i].id].destroy(true);
                                        }
                                        CKEDITOR.replace(nodes[i].id, cfg);
                                    }
                                    var form = nodes[0] && nodes[0].form;
                                    if (form && !form.__annuncioCkBound) {
                                        form.__annuncioCkBound = true;
                                        form.addEventListener('submit', function () {
                                            for (var name in CKEDITOR.instances) {
                                                if (Object.prototype.hasOwnProperty.call(CKEDITOR.instances, name)) {
                                                    CKEDITOR.instances[name].updateElement();
                                                }
                                            }
                                        });
                                    }
                                })();
                            </script>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label">Testo bottone (avviso chiuso)</label>
                        <div class="mws-form-item clearfix">
                            <div class="annuncio-langs">
                                <?php
                                $reopenPlaceholders = [
                                    'it' => 'Mostra avviso',
                                    'en' => 'Show notice',
                                    'fr' => 'Afficher l’avis',
                                    'de' => 'Hinweis anzeigen',
                                    'es' => 'Mostrar aviso',
                                ];
                                foreach ($localeLabels as $code => $label):
                                    ?>
                                    <div class="annuncio-lang">
                                        <label class="annuncio-lang__label" for="reopen_label_<?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>">
                                            <span class="annuncio-lang__code"><?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?></span>
                                            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                                            <?php if ($code === 'it'): ?>
                                                <span style="font-weight:500; color:#777; font-size:12px;">(fallback per tutti se unico)</span>
                                            <?php elseif ($code === 'en'): ?>
                                                <span style="font-weight:500; color:#777; font-size:12px;">(fallback per le altre lingue)</span>
                                            <?php endif; ?>
                                        </label>
                                        <input
                                            type="text"
                                            id="reopen_label_<?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>"
                                            name="reopen_labels[<?php echo htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>]"
                                            maxlength="120"
                                            style="width:100%; box-sizing:border-box;"
                                            value="<?php echo htmlspecialchars((string) ($reopenLabelsMap[$code] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                            placeholder="<?php echo htmlspecialchars($reopenPlaceholders[$code] ?? 'Mostra avviso', ENT_QUOTES, 'UTF-8'); ?>"
                                        >
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div style="font-size:12px; color:#777; margin-top:8px; max-width:760px; line-height:1.45;">
                                Comparve quando il visitatore chiude il banner. Stesse regole di fallback del messaggio. Vuoto = testo predefinito nella lingua del visitatore.
                            </div>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label" for="starts_at">Data inizio</label>
                        <div class="mws-form-item clearfix">
                            <input type="datetime-local" id="starts_at" name="starts_at" value="<?php echo htmlspecialchars(annuncio_dt_local($announcement->starts_at), ENT_QUOTES, 'UTF-8'); ?>">
                            <div style="font-size:12px; color:#777; margin-top:4px;">Vuoto = subito (se attivo).</div>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label" for="ends_at">Data fine</label>
                        <div class="mws-form-item clearfix">
                            <input type="datetime-local" id="ends_at" name="ends_at" value="<?php echo htmlspecialchars(annuncio_dt_local($announcement->ends_at), ENT_QUOTES, 'UTF-8'); ?>">
                            <div style="font-size:12px; color:#777; margin-top:4px;">Vuoto = senza scadenza.</div>
                        </div>
                    </div>

                    <div class="mws-button-row" style="margin-top:18px;">
                        <input type="submit" name="save_announcement" value="Salva" class="btn btn-danger">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
