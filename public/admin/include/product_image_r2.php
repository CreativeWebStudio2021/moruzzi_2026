<?php

/**
 * Bridge admin legacy → Laravel ProductImageService (Cloudflare R2).
 */
if (!defined('MORUZZI_R2_BOOTSTRAPPED')) {
    define('MORUZZI_R2_BOOTSTRAPPED', true);

    $laravelRoot = dirname(__DIR__, 3);
    require_once $laravelRoot . '/vendor/autoload.php';
    $app = require $laravelRoot . '/bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
}

use App\Services\ProductImageService;

function moruzzi_product_images(): ProductImageService
{
    return app(ProductImageService::class);
}

function productImageUrl(?string $image, string $size = 'full'): string
{
    return moruzzi_product_images()->url($image, $size);
}

function productImageDeleteR2(?string $dbRelativePath): void
{
    moruzzi_product_images()->delete($dbRelativePath);
}

function productImageUploadFromLocalDir(string $localDir, string $dbRelativePath): void
{
    moruzzi_product_images()->uploadFromLocalDir($localDir, $dbRelativePath);
}

function productImageDuplicateR2(string $sourcePath): ?string
{
    return moruzzi_product_images()->duplicate($sourcePath);
}

function productImageSyncAfterLocal(string $localRelativeDir, string $dbRelativePath): void
{
    productImageUploadFromLocalDir($localRelativeDir, $dbRelativePath);
}
