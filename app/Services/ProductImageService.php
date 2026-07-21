<?php

namespace App\Services;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use RuntimeException;

class ProductImageService
{
    private ?S3Client $client = null;

    public function isConfigured(): bool
    {
        return (string) config('r2.account_id') !== ''
            && (string) config('r2.access_key_id') !== ''
            && (string) config('r2.secret_access_key') !== ''
            && (string) config('r2.bucket') !== '';
    }

    public function url(?string $image, string $size = 'full'): string
    {
        if (empty($image)) {
            return '';
        }

        $image = ltrim(str_replace('\\', '/', $image), '/');
        $parts = explode('/', $image);
        $filename = array_pop($parts);
        $dir = count($parts) ? implode('/', $parts) . '/' : '';

        if ($size === 'thumb') {
            $filename = 's_' . $filename;
        } elseif ($size === 'xs') {
            $filename = 'xs_' . $filename;
        }

        return config('r2.public_url') . '/'
            . trim(config('r2.product_folder'), '/') . '/'
            . $dir . $filename;
    }

    public function r2Key(string $dbRelativePath): string
    {
        return trim(config('r2.product_folder'), '/') . '/'
            . ltrim(str_replace('\\', '/', $dbRelativePath), '/');
    }

    public function delete(?string $dbRelativePath): void
    {
        if (empty($dbRelativePath) || !$this->isConfigured()) {
            return;
        }

        $parts = explode('/', str_replace('\\', '/', $dbRelativePath));
        $filename = array_pop($parts);
        $dir = count($parts) ? implode('/', $parts) . '/' : '';

        foreach (['', 's_', 'xs_', 'RED_'] as $prefix) {
            $this->deleteObject($this->r2Key($dir . $prefix . $filename));
        }

        $this->purgeCdnCache($this->publicUrlsForVariants($dbRelativePath));
    }

    public function uploadFromLocalDir(string $localDir, string $dbRelativePath): void
    {
        if (empty($dbRelativePath) || !$this->isConfigured()) {
            return;
        }

        $localDir = rtrim(str_replace('\\', '/', $localDir), '/');
        $parts = explode('/', str_replace('\\', '/', $dbRelativePath));
        $filename = array_pop($parts);
        $dir = count($parts) ? implode('/', $parts) . '/' : '';

        $uploadedPaths = [];

        foreach (['', 's_', 'xs_', 'RED_'] as $prefix) {
            $localFile = $localDir . '/' . $prefix . $filename;
            if (is_file($localFile)) {
                $variantPath = $dir . $prefix . $filename;
                $this->putFile($this->r2Key($variantPath), $localFile);
                $uploadedPaths[] = $variantPath;
                @unlink($localFile);
            }
        }

        $this->purgeCdnCache($this->publicUrlsForR2Paths($uploadedPaths));
    }

    public function duplicate(string $sourcePath): ?string
    {
        if (empty($sourcePath) || !$this->isConfigured()) {
            return null;
        }

        $sourcePath = ltrim(str_replace('\\', '/', $sourcePath), '/');
        $parts = explode('/', $sourcePath);
        $filename = array_pop($parts);
        $dir = count($parts) ? implode('/', $parts) . '/' : '';

        $pathInfo = pathinfo($filename);
        $newFilename = ($pathInfo['filename'] ?? 'image') . '_' . time() . '.' . ($pathInfo['extension'] ?? 'jpg');
        $newDbPath = $dir . $newFilename;
        $bucket = config('r2.bucket');

        foreach (['', 's_', 'xs_', 'RED_'] as $prefix) {
            $srcKey = $this->r2Key($dir . $prefix . $filename);
            $dstKey = $this->r2Key($dir . $prefix . $newFilename);

            try {
                $this->client()->copyObject([
                    'Bucket' => $bucket,
                    'CopySource' => $bucket . '/' . $srcKey,
                    'Key' => $dstKey,
                ]);
            } catch (AwsException) {
                // Variante assente: ignora
            }
        }

        return $newDbPath;
    }

    private function putFile(string $key, string $localPath): void
    {
        $this->client()->putObject([
            'Bucket' => config('r2.bucket'),
            'Key' => $key,
            'SourceFile' => $localPath,
            'ContentType' => $this->mimeType($localPath),
        ]);
    }

    private function deleteObject(string $key): void
    {
        try {
            $this->client()->deleteObject([
                'Bucket' => config('r2.bucket'),
                'Key' => $key,
            ]);
        } catch (AwsException) {
            // Ignora se l'oggetto non esiste
        }
    }

    private function mimeType(string $filePath): string
    {
        $type = @mime_content_type($filePath);
        if ($type) {
            return $type;
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($ext) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            default => 'image/jpeg',
        };
    }

    /**
     * @return list<string>
     */
    private function publicUrlsForVariants(string $dbRelativePath): array
    {
        $dbRelativePath = ltrim(str_replace('\\', '/', $dbRelativePath), '/');
        $parts = explode('/', $dbRelativePath);
        $filename = array_pop($parts);
        $dir = count($parts) ? implode('/', $parts) . '/' : '';

        $paths = [];
        foreach (['', 's_', 'xs_', 'RED_'] as $prefix) {
            $paths[] = $dir . $prefix . $filename;
        }

        return $this->publicUrlsForR2Paths($paths);
    }

    /**
     * @param  list<string>  $r2RelativePaths  es. 2026/07/s_160847.jpg
     * @return list<string>
     */
    private function publicUrlsForR2Paths(array $r2RelativePaths): array
    {
        $base = rtrim((string) config('cloudflare.public_image_host', config('r2.public_url')), '/');
        $folder = trim((string) config('r2.product_folder'), '/');

        return array_values(array_map(
            fn (string $path) => $base . '/' . $folder . '/' . ltrim($path, '/'),
            $r2RelativePaths,
        ));
    }

    /**
     * @param  list<string>  $urls
     */
    private function purgeCdnCache(array $urls): void
    {
        if ($urls === []) {
            return;
        }

        app(CloudflareCacheService::class)->purgeUrls($urls);
    }

    private function client(): S3Client
    {
        if ($this->client === null) {
            if (!$this->isConfigured()) {
                throw new RuntimeException('Credenziali R2 non configurate.');
            }

            $this->client = new S3Client([
                'version' => 'latest',
                'region' => 'auto',
                'endpoint' => 'https://' . config('r2.account_id') . '.r2.cloudflarestorage.com',
                'credentials' => [
                    'key' => config('r2.access_key_id'),
                    'secret' => config('r2.secret_access_key'),
                ],
                'use_path_style_endpoint' => true,
            ]);
        }

        return $this->client;
    }
}
