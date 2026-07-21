<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Istruzioni bonifico bancario (HTML consentito)
    |--------------------------------------------------------------------------
    */
    'bank_transfer_details' => env(
        'SHOP_BANK_TRANSFER_DETAILS',
        'MORUZZI NUMISMATICA FILATELIA DON BOSCO di Moruzzi Umberto SNC<br>'
        .'Monte dei Paschi di Siena Agenzia 133 di Roma<br>'
        .'IBAN: IT41U0103003315000000081225<br>'
        .'Codice BIC: PASCITM1Z76'
    ),

];
