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

try {
    $announcement = SiteAnnouncement::current();
    if (! $announcement) {
        $announcement = SiteAnnouncement::query()->create([
            'enabled' => false,
            'message' => null,
            'starts_at' => null,
            'ends_at' => null,
        ]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_announcement'])) {
        $enabled = isset($_POST['enabled']) && (string) $_POST['enabled'] === '1';
        $message = trim((string) ($_POST['message'] ?? ''));
        $reopenLabel = trim((string) ($_POST['reopen_label'] ?? ''));
        if (mb_strlen($reopenLabel) > 120) {
            $reopenLabel = mb_substr($reopenLabel, 0, 120);
        }
        $startsRaw = trim((string) ($_POST['starts_at'] ?? ''));
        $endsRaw = trim((string) ($_POST['ends_at'] ?? ''));

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

        if ($enabled && $message === '') {
            throw new RuntimeException('Per attivare il messaggio inserisci un testo.');
        }

        $announcement->enabled = $enabled;
        $announcement->message = $message !== '' ? $message : null;
        $announcement->reopen_label = $reopenLabel !== '' ? $reopenLabel : null;
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
                <div style="margin-bottom:14px; padding:10px; background:<?php echo $isActiveNow ? '#fff8e6' : '#f5f5f5'; ?>; border:1px solid #ddd;">
                    Stato attuale:
                    <?php if ($isActiveNow): ?>
                        <strong style="color:#0a7a2f;">VISIBILE ora sul sito</strong>
                    <?php else: ?>
                        <strong style="color:#777;">non visibile</strong>
                        <?php if (! $announcement->enabled): ?> (disattivato)<?php elseif (! trim((string) $announcement->message)): ?> (testo vuoto)<?php else: ?> (fuori intervallo date)<?php endif; ?>
                    <?php endif; ?>
                </div>

                <form method="post" action="admin.php?cmd=annuncio" class="mws-form">
                    <style>
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
                        <label class="mws-form-label" for="announcement_message">Testo messaggio</label>
                        <div class="mws-form-item clearfix">
                            <textarea id="announcement_message" name="message" rows="5" style="width:100%; max-width:640px;"><?php echo htmlspecialchars((string) $announcement->message, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <div style="font-size:12px; color:#777; margin-top:4px;">Testo semplice. Andrà a capo dove inserisci un ritorno a capo.</div>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label" for="reopen_label">Testo bottone (avviso chiuso)</label>
                        <div class="mws-form-item clearfix">
                            <input type="text" id="reopen_label" name="reopen_label" class="large" maxlength="120" style="max-width:420px;" value="<?php echo htmlspecialchars((string) $announcement->reopen_label, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Mostra avviso">
                            <div style="font-size:12px; color:#777; margin-top:4px;">Comparve quando il visitatore chiude il banner. Vuoto = «Mostra avviso».</div>
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
