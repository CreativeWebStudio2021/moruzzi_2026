<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cartella condivisa Dropbox → public/h
    |--------------------------------------------------------------------------
    |
    | Richiede un'app Dropbox (scopes: sharing.read, files.content.read)
    | e un access token nel .env (DROPBOX_ACCESS_TOKEN).
    |
    | URL completo del link condiviso, incluso rlkey:
    | https://www.dropbox.com/scl/fo/.../...?rlkey=...&dl=0
    */
    'shared_link_url' => env('DROPBOX_SHARED_LINK_URL'),

    'app_key' => env('DROPBOX_APP_KEY'),
    'app_secret' => env('DROPBOX_APP_SECRET'),
    'access_token' => env('DROPBOX_ACCESS_TOKEN'),
    'refresh_token' => env('DROPBOX_REFRESH_TOKEN'),

    'token_cache_file' => storage_path('app/dropbox_access_token.json'),

    'target_path' => public_path('h'),

    'allowed_extensions' => ['html', 'jpg', 'jpeg', 'psd'],

    /*
    | Staging temporaneo per JPG/PSD prima dell'upload su R2 (chiave h/<file>).
    | Dopo upload riuscito la copia locale viene eliminata. HTML restano in public/h.
    | Se l'upload R2 fallisce, il file resta qui per un retry successivo.
    */
    'images_subdirectory' => 'img',

    /*
    | Se true, mantiene le sottocartelle del link Dropbox sotto public/h.
    | Se false, salva tutti i file nella root di public/h (comportamento attuale).
    */
    'preserve_paths' => (bool) env('DROPBOX_SYNC_PRESERVE_PATHS', false),

    'state_file' => storage_path('app/dropbox_h_sync_state.json'),

    /*
    | Sync manuale:
    |   php artisan dropbox:sync-h
    |   php artisan dropbox:sync-h --dry-run
    |   GET /internal/dropbox-sync?token=IL_TUO_SEGRETO
    |   Opzionale: &dry_run=1 per solo anteprima
    |
    | Scheduler: dailyAt 02:30 (routes/console.php).
    */
    'webhook_secret' => env('DROPBOX_SYNC_WEBHOOK_SECRET'),
];

