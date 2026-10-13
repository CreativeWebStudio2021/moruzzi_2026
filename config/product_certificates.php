<?php

return [
    /*
    | Token per generazione da backoffice:
    | GET /internal/product-certificate/generate?token=...&product_id=...&registry_number=...
    */
    'webhook_secret' => env('PRODUCT_CERTIFICATE_WEBHOOK_SECRET', env('DROPBOX_SYNC_WEBHOOK_SECRET')),

    'storage_path' => public_path('h'),

    'pdf_path' => public_path('h/pdf'),

    /*
    | Se l'immagine certificato non è in public/h/ (tipico su staging),
    | usa questo host per servire /h/{filename}.
    */
    'image_fallback_base' => rtrim(env('PRODUCT_CERTIFICATE_IMAGE_FALLBACK', 'https://www.moruzzi.it'), '/'),

    'copyright_from_year' => 1999,

    'ylium_verify_url' => env('YLIUM_VERIFY_URL', 'https://gw.ylium.tech/dapp_24.5.3/verify.html'),

    'ylium_notarization_url' => env(
        'YLIUM_NOTARIZATION_URL',
        'https://gw.ylium.tech/dapp_24.5.3/notarization.html?operation-code=announce'
    ),

    'ylium_wizard_url' => env(
        'YLIUM_WIZARD_URL',
        'https://gw.ylium.tech/dapp_24.5.3/wizard.html'
    ),

    'polygonscan_tx_url' => env('POLYGONSCAN_TX_URL', 'https://polygonscan.com/tx/'),

    /*
    |--------------------------------------------------------------------------
    | Notarizzazione automatica (background)
    |--------------------------------------------------------------------------
    |
    | Per evitare la procedura MetaMask lato cliente, il backoffice può
    | inviare direttamente la transazione al contratto notarization su Polygon
    * usando una wallet "custodial".
    |
    | Attenzione: NON impostare valori sensibili in git. Devono stare in .env.
    */
    'ylium_auto_enabled' => env('YLIUM_AUTO_ENABLED', false),
    'ylium_auto_private_key' => env('YLIUM_AUTO_PRIVATE_KEY', ''),

    // RPC HTTP/HTTPS per Polygon Mainnet.
    'ylium_polygon_rpc_url' => env('YLIUM_POLYGON_RPC_URL', ''),

    // Indirizzo contratto notarization (Polygon Mainnet / ChainId 137).
    'ylium_notarization_contract_address' => env(
        'YLIUM_NOTARIZATION_CONTRACT_ADDRESS',
        '0xAFCe9B7560BC81020B7455a7B55f6277eE68723E'
    ),

    // Indirizzo "delegee" opzionale (se serve per la variante announce con 4 arg).
    'ylium_delegee_address' => env('YLIUM_DELEGEE_ADDRESS', ''),

    // Document id (pdata0) default: bytes32 zero.
    'ylium_zero_pdata0' => env('YLIUM_ZERO_PDATA0', '0x0000000000000000000000000000000000000000000000000000000000000000'),
];
