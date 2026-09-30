<?php

namespace App\Services;

use Aws\S3\S3Client;
use RuntimeException;

class CertificateImageR2Service
{
    private const KEY_PREFIX = 'h/';

    private ?S3Client $client = null;

    public function isConfigured(): bool
    {
        return (string) config('r2.account_id') !== ''
            && (string) config('r2.access_key_id') !== ''
            && (string) config('r2.secret_access_key') !== ''
            && (string) config('r2.bucket') !== '';
    }

    public function objectKey(string $filename): string
    {
        return self::KEY_PREFIX.basename($filename);
    }

    public function publicUrl(string $filename): string
    {
        return rtrim((string) config('r2.public_url'), '/').'/'.$this->objectKey($filename);
    }

    /**
     * @return array<string, int> basename lowercase => size in bytes
     */
    public function buildSizeIndex(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        $index = [];
        $bucket = (string) config('r2.bucket');
        $token = null;

        do {
            $params = [
                'Bucket' => $bucket,
                'Prefix' => self::KEY_PREFIX,
            ];

            if ($token !== null) {
                $params['ContinuationToken'] = $token;
            }

            $result = $this->client()->listObjectsV2($params);

            foreach ($result['Contents'] ?? [] as $object) {
                $key = (string) ($object['Key'] ?? '');
                if ($key === '' || str_ends_with($key, '/')) {
                    continue;
                }

                $index[strtolower(basename($key))] = (int) ($object['Size'] ?? 0);
            }

            $token = ($result['IsTruncated'] ?? false) ? ($result['NextContinuationToken'] ?? null) : null;
        } while ($token !== null);

        return $index;
    }

    public function upload(string $localPath, string $filename): void
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Credenziali R2 non configurate.');
        }

        if (! is_file($localPath)) {
            throw new RuntimeException("File locale mancante per upload R2: {$localPath}");
        }

        $this->client()->putObject([
            'Bucket' => config('r2.bucket'),
            'Key' => $this->objectKey($filename),
            'SourceFile' => $localPath,
            'ContentType' => $this->mimeType($localPath),
        ]);

        app(CloudflareCacheService::class)->purgeUrls([$this->publicUrl($filename)]);
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
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            default => 'image/jpeg',
        };
    }

    private function client(): S3Client
    {
        if ($this->client === null) {
            if (! $this->isConfigured()) {
                throw new RuntimeException('Credenziali R2 non configurate.');
            }

            $this->client = new S3Client([
                'version' => 'latest',
                'region' => 'auto',
                'endpoint' => 'https://'.config('r2.account_id').'.r2.cloudflarestorage.com',
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
