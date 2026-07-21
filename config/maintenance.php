<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Modalita "sito in manutenzione" (gestita dall'app, non da artisan down)
    |--------------------------------------------------------------------------
    |
    | Quando "enabled" e true, tutte le richieste gestite da Laravel mostrano
    | la pagina public/manutenzione.php con HTTP 503, TRANNE per i visitatori
    | il cui IP e elencato in "allowed_ips".
    |
    | Si controlla tutto da .env:
    |   MAINTENANCE_MODE=true|false
    |   MAINTENANCE_ALLOWED_IPS=1.2.3.4,5.6.7.8   (lista separata da virgole)
    |
    */

    'enabled' => env('MAINTENANCE_MODE', false),

    'allowed_ips' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('MAINTENANCE_ALLOWED_IPS', ''))
    ))),

];
