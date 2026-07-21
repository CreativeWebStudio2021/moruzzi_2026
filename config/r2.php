<?php

return [
    'account_id' => env('R2_ACCOUNT_ID'),
    'access_key_id' => env('R2_ACCESS_KEY_ID'),
    'secret_access_key' => env('R2_SECRET_ACCESS_KEY'),
    'bucket' => env('R2_BUCKET_NAME', 'moruzzi'),
    'public_url' => rtrim(env('R2_PUBLIC_URL', 'https://img.moruzzi.it'), '/'),
    'product_folder' => env('R2_PRODUCT_FOLDER', 'prodotti'),
];
