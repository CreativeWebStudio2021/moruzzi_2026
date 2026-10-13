<?php

/**
 * Redirect alla dApp Ylium (Announce).
 * La vecchia pagina locale dipendeva da include CWS assenti su questo sito.
 */
$target = 'https://gw.ylium.tech/dapp_24.5.3/notarization.html?operation-code=announce';

// Bootstrap Laravel se disponibile, per rispettare YLIUM_NOTARIZATION_URL da .env
$autoload = dirname(__DIR__).'/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
    $app = require dirname(__DIR__).'/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    $configured = (string) config('product_certificates.ylium_notarization_url', '');
    if ($configured !== '' && preg_match('#^https?://#i', $configured)) {
        $target = $configured;
    }
}

header('Location: '.$target, true, 302);
exit;
