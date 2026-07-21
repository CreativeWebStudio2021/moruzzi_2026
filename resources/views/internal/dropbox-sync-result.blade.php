<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sincronizzazione Dropbox</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f6f3ef;
            --card: #ffffff;
            --text: #1f1f1f;
            --muted: #666;
            --ok: #1b6b3a;
            --ok-bg: #e8f5ec;
            --warn: #8a5a00;
            --warn-bg: #fff6df;
            --err: #8b1e1e;
            --err-bg: #fdecec;
            --border: #ddd4c8;
            --accent: #800000;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        .wrap {
            max-width: 720px;
            margin: 48px auto;
            padding: 0 20px 40px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px 32px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
            color: var(--accent);
            font-style: italic;
        }

        .subtitle {
            margin: 0 0 24px;
            color: var(--muted);
            font-family: system-ui, sans-serif;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 999px;
            font-family: system-ui, sans-serif;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .badge.ok { background: var(--ok-bg); color: var(--ok); }
        .badge.warn { background: var(--warn-bg); color: var(--warn); }
        .badge.err { background: var(--err-bg); color: var(--err); }

        .stats {
            width: 100%;
            border-collapse: collapse;
            font-family: system-ui, sans-serif;
            font-size: 15px;
        }

        .stats th,
        .stats td {
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .stats th {
            width: 70%;
            font-weight: 500;
            color: var(--muted);
        }

        .stats td {
            font-weight: 700;
            text-align: right;
        }

        .stats tr:last-child th,
        .stats tr:last-child td {
            border-bottom: none;
        }

        .errors {
            margin-top: 24px;
            padding: 16px 18px;
            background: var(--err-bg);
            border-radius: 8px;
            color: var(--err);
            font-family: system-ui, sans-serif;
            font-size: 14px;
        }

        .errors ul {
            margin: 8px 0 0;
            padding-left: 18px;
        }

        .footer {
            margin-top: 20px;
            font-family: system-ui, sans-serif;
            font-size: 13px;
            color: var(--muted);
        }

        .footer code {
            background: #eee;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            @if (! $ok)
                <span class="badge err">Errore</span>
                <h1>Sincronizzazione non riuscita</h1>
                <p class="subtitle">{{ $message ?? 'Si è verificato un errore.' }}</p>
            @elseif ($dryRun)
                <span class="badge warn">Anteprima</span>
                <h1>Sincronizzazione Dropbox</h1>
                <p class="subtitle">Modalità dry-run: nessun file è stato scaricato.</p>
            @elseif ($downloaded > 0)
                <span class="badge ok">Completata</span>
                <h1>Sincronizzazione Dropbox</h1>
                <p class="subtitle">Nuovi file scaricati in <strong>public/h</strong>.</p>
            @else
                <span class="badge ok">Aggiornata</span>
                <h1>Sincronizzazione Dropbox</h1>
                <p class="subtitle">Nessun nuovo file da scaricare: tutto già presente.</p>
            @endif

            @if ($ok)
                <table class="stats">
                    <tr>
                        <th>File trovati su Dropbox</th>
                        <td>{{ number_format($listed, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Già presenti / ignorati</th>
                        <td>{{ number_format($skipped, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>File mancanti</th>
                        <td>{{ number_format($missing, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>File scaricati</th>
                        <td>{{ number_format($downloaded, 0, ',', '.') }}</td>
                    </tr>
                </table>

                @if ($errors !== [])
                    <div class="errors">
                        <strong>{{ count($errors) }} errori durante il download:</strong>
                        <ul>
                            @foreach ($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif

            <p class="footer">
                Eseguita il {{ $executedAt }}.
                Per la risposta JSON aggiungi <code>&format=json</code>.
            </p>
        </div>
    </div>
</body>
</html>
