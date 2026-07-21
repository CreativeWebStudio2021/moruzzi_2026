<?php

return [
    'site_id' => (int) env('IUBENDA_SITE_ID', 3725391),

    'default_cookie_policy_id' => (int) env('IUBENDA_COOKIE_POLICY_ID', 91003345),

    /*
     * Chiavi = codici lingua Iubenda (en-GB per l'inglese del sito).
     * app_locale = locale Laravel usato per generare cookiePolicyUrl.
     */
    'languages' => [
        'it' => [
            'cookie_policy_id' => (int) env('IUBENDA_COOKIE_POLICY_ID_IT', 91003345),
            'app_locale' => 'it',
        ],
        'en-GB' => [
            'cookie_policy_id' => (int) env('IUBENDA_COOKIE_POLICY_ID_EN', 50359807),
            'app_locale' => 'en',
        ],
        'fr' => [
            'cookie_policy_id' => (int) env('IUBENDA_COOKIE_POLICY_ID_FR', 79804040),
            'app_locale' => 'fr',
        ],
        'de' => [
            'cookie_policy_id' => (int) env('IUBENDA_COOKIE_POLICY_ID_DE', 34931481),
            'app_locale' => 'de',
        ],
        'es' => [
            'cookie_policy_id' => (int) env('IUBENDA_COOKIE_POLICY_ID_ES', 64003416),
            'app_locale' => 'es',
        ],
    ],
];
