<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayPal Website Payments Standard (legacy IPN)
    |--------------------------------------------------------------------------
    |
    | Integrazione basata sul flusso del vecchio sito: form POST verso PayPal,
    | conferma asincrona via IPN e fallback sul ritorno utente (rm=2).
    |
    */

    'sandbox' => env('PAYPAL_SANDBOX', false),

    'business_email' => env('PAYPAL_BUSINESS_EMAIL', 'umberto@moruzzi.it'),

    'sandbox_business_email' => env('PAYPAL_SANDBOX_BUSINESS_EMAIL', 'sb-bq8fd4042191@business.example.com'),

    'currency' => 'EUR',

    'locale' => 'IT',

    /*
    | Importo simbolico per test pagamento reale da IP autorizzati.
    | Disattivare impostando PAYPAL_TEST_PAYMENT_ENABLED=false in .env
    */
    'test_payment_enabled' => env('PAYPAL_TEST_PAYMENT_ENABLED', false),

    'test_payment_ips' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('PAYPAL_TEST_PAYMENT_IPS', ''))
    ))),

    'test_payment_amount' => (float) env('PAYPAL_TEST_PAYMENT_AMOUNT', 0.01),

    /*
    | Mappatura nomi nazione (minuscolo, senza spazi) -> codice ISO PayPal.
    | Estratta dal vecchio array.inc.php del sito.
    */
    'country_codes' => [
        'italia' => 'it',
        'francia' => 'fr',
        'germania' => 'de',
        'spagna' => 'es',
        'regno unito' => 'gb',
        'regnounito' => 'gb',
        'stati uniti' => 'us',
        'statiuniti' => 'us',
        'svizzera' => 'ch',
        'austria' => 'at',
        'belgio' => 'be',
        'olanda' => 'nl',
        'paesibassi' => 'nl',
        'portogallo' => 'pt',
        'grecia' => 'gr',
        'irlanda' => 'ie',
        'polonia' => 'pl',
        'romania' => 'ro',
        'ungheria' => 'hu',
        'repubblicaceca' => 'cz',
        'croazia' => 'hr',
        'slovenia' => 'si',
        'slovacchia' => 'sk',
        'danimarca' => 'dk',
        'svezia' => 'se',
        'norvegia' => 'no',
        'finlandia' => 'fi',
        'canada' => 'ca',
        'australia' => 'au',
        'giappone' => 'jp',
        'cina' => 'c2',
        'russia' => 'ru',
        'brasile' => 'br',
        'messico' => 'mx',
        'argentina' => 'ar',
        'turchia' => 'tr',
        'israele' => 'il',
        'emiratiarabiuniti' => 'ae',
        'india' => 'in',
        'australia' => 'au',
        'luxembourg' => 'lu',
        'lussemburgo' => 'lu',
        'malta' => 'mt',
        'cipro' => 'cy',
        'bulgaria' => 'bg',
        'estonia' => 'ee',
        'lettonia' => 'lv',
        'lituania' => 'lt',
    ],
];
