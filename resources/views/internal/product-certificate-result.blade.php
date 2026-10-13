<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Certificato prodotto</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; color: #222; }
        .ok { color: #0a7a2f; }
        .err { color: #b00020; }
        pre { white-space: pre-wrap; background: #f7f7f7; padding: 16px; border-radius: 8px; }
        a { color: #880002; }
    </style>
</head>
<body>
    <h1>Certificato online prodotto</h1>

    @if(!($ok ?? false))
        <p class="err">{{ $message ?? 'Operazione non riuscita.' }}</p>
    @else
        <p class="ok">{{ ($created ?? false) ? 'Certificato creato.' : 'Certificato aggiornato.' }}</p>
        <p><strong>Codice:</strong> {{ $access_code ?? '' }}</p>
        <p><strong>Registro commercio n.</strong> {{ $registry_number ?? '' }}</p>
        <p><strong>URL pubblico:</strong> <a href="{{ $url ?? '#' }}" target="_blank" rel="noopener">{{ $url ?? '' }}</a></p>
        @if(!empty($image_url))
            <p><strong>Immagine:</strong> <a href="{{ $image_url }}" target="_blank" rel="noopener">{{ $image_url }}</a></p>
        @endif
        @if(!empty($body_text))
            <h2>Testo certificato</h2>
            <pre>{{ $body_text }}</pre>
        @endif
    @endif
</body>
</html>
