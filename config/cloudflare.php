<?php

return [
    'zone_id' => env('CLOUDFLARE_ZONE_ID'),
    'api_token' => env('CLOUDFLARE_API_TOKEN'),
    'public_image_host' => env('CLOUDFLARE_PUBLIC_IMAGE_HOST', env('R2_PUBLIC_URL', 'https://img.moruzzi.it')),
];
