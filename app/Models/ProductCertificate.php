<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Http;

class ProductCertificate extends Model
{
    protected $fillable = [
        'product_id',
        'product_sku',
        'product_name',
        'access_code',
        'registry_number',
        'body_text',
        'image_filename',
        'pdf_filename',
        'pdf_sha256',
        'issued_on',
        'score_conservazione',
        'score_rarita',
        'score_battuta',
        'score_metallo',
        'score_stile',
        'score_provenienza',
        'notarization_hash',
        'notarization_tx_hash',
        'notarized_at',
        'notarization_notes',
        'notarization_status',
        'notarization_started_at',
        'notarization_error',
        'published',
    ];

    protected $casts = [
        'registry_number' => 'integer',
        'published' => 'boolean',
        'issued_on' => 'date',
        'notarized_at' => 'datetime',
        'notarization_started_at' => 'datetime',
        'score_conservazione' => 'integer',
        'score_rarita' => 'integer',
        'score_battuta' => 'integer',
        'score_metallo' => 'integer',
        'score_stile' => 'integer',
        'score_provenienza' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'entity_id');
    }

    public function publicUrl(): string
    {
        return url('/h/'.$this->access_code.'.html');
    }

    public function pdfUrl(): ?string
    {
        if (! $this->pdf_filename) {
            return null;
        }

        return asset('h/pdf/'.$this->pdf_filename);
    }

    public function pdfAbsolutePath(): ?string
    {
        if (! $this->pdf_filename) {
            return null;
        }

        return rtrim(config('product_certificates.pdf_path'), '/').'/'.$this->pdf_filename;
    }

    public function imageUrl(): ?string
    {
        return $this->resolvedImageUrl();
    }

    /**
     * URL immagine certificato: locale, poi produzione (/h/), poi foto prodotto su CDN.
     */
    public function resolvedImageUrl(): ?string
    {
        foreach ($this->localImageCandidatePaths() as $path) {
            if (is_file($path)) {
                return $this->publicUrlForLocalImagePath($path);
            }
        }

        return $this->resolvedImageRemoteUrl();
    }

    /**
     * Percorso locale per il PDF: file su disco oppure download temporaneo da www/CDN.
     */
    public function resolvedImagePathForPdf(): ?string
    {
        foreach ($this->localImageCandidatePaths() as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        $remoteUrl = $this->resolvedImageRemoteUrl();
        if ($remoteUrl === null) {
            return null;
        }

        return $this->downloadRemoteImageToTemp($remoteUrl);
    }

    /**
     * @return list<string>
     */
    public function localImageCandidatePaths(): array
    {
        $storage = rtrim((string) config('product_certificates.storage_path'), '/');
        $sku = $this->displaySku();
        $paths = [];

        if ($this->image_filename) {
            $paths[] = $storage.'/'.ltrim(str_replace('\\', '/', (string) $this->image_filename), '/');
        }

        if ($sku !== '') {
            foreach (['jpg', 'jpeg', 'png'] as $extension) {
                $paths[] = $storage.'/'.$sku.'.'.$extension;
                $paths[] = public_path('h/'.$sku.'.'.$extension);
                $paths[] = public_path('h/img/'.$sku.'.'.$extension);
            }
        }

        return array_values(array_unique($paths));
    }

    public function resolvedImageRemoteUrl(): ?string
    {
        $product = $this->relationLoaded('product') ? $this->product : $this->product()->first();

        if ($this->image_filename) {
            $relative = ltrim(str_replace('\\', '/', (string) $this->image_filename), '/');
            $fallbackBase = (string) config('product_certificates.image_fallback_base', 'https://www.moruzzi.it');
            if ($fallbackBase !== '') {
                $remote = $fallbackBase.'/h/'.$relative;
                if ($this->remoteAssetExists($remote)) {
                    return $remote;
                }
            }
        }

        if ($product && ! empty($product->image)) {
            $cdnUrl = product_image_url($product->image, 'full');
            if ($cdnUrl !== '' && $this->remoteAssetExists($cdnUrl)) {
                return $cdnUrl;
            }
        }

        return null;
    }

    private function publicUrlForLocalImagePath(string $absolutePath): string
    {
        $storage = rtrim((string) config('product_certificates.storage_path'), '/');
        $publicH = rtrim(public_path('h'), '/');

        if (str_starts_with($absolutePath, $storage.'/')) {
            return asset('h/'.ltrim(substr($absolutePath, strlen($storage)), '/'));
        }

        if (str_starts_with($absolutePath, $publicH.'/')) {
            return asset('h/'.ltrim(substr($absolutePath, strlen($publicH)), '/'));
        }

        return asset('h/'.basename($absolutePath));
    }

    private function downloadRemoteImageToTemp(string $url): ?string
    {
        try {
            $response = Http::timeout(12)
                ->withOptions(['allow_redirects' => true])
                ->get($url);

            if (! $response->successful()) {
                return null;
            }

            $contentType = strtolower((string) $response->header('Content-Type'));
            $extension = match (true) {
                str_contains($contentType, 'png') => 'png',
                str_contains($contentType, 'webp') => 'webp',
                default => 'jpg',
            };

            $path = tempnam(sys_get_temp_dir(), 'certcoin_').'.'.$extension;
            file_put_contents($path, $response->body());

            return is_file($path) ? $path : null;
        } catch (\Throwable) {
            return null;
        }
    }

    public function hasVerifyAction(): bool
    {
        return $this->isNotarized();
    }

    public function verifyUrl(): ?string
    {
        if (! $this->isNotarized()) {
            return null;
        }

        return url('/h/verifica.html').'?hash='.urlencode((string) $this->notarizationHashPrefixed());
    }

    private function remoteAssetExists(string $url): bool
    {
        static $cache = [];

        if (array_key_exists($url, $cache)) {
            return $cache[$url];
        }

        try {
            $response = Http::timeout(4)
                ->withOptions(['allow_redirects' => true])
                ->head($url);

            return $cache[$url] = $response->successful();
        } catch (\Throwable) {
            return $cache[$url] = false;
        }
    }

    public function displaySku(): string
    {
        if ($this->product_sku) {
            return (string) $this->product_sku;
        }

        return (string) ($this->product?->sku ?? '');
    }

    public function displayName(): string
    {
        if ($this->product_name) {
            return (string) $this->product_name;
        }

        return (string) ($this->product?->name ?? '');
    }

    public function productStillAvailable(): bool
    {
        return $this->product !== null;
    }

    public function isNotarized(): bool
    {
        return filled($this->notarization_hash) && filled($this->notarization_tx_hash);
    }

    public function notarizationHashPrefixed(): ?string
    {
        if (! $this->notarization_hash && ! $this->pdf_sha256) {
            return null;
        }

        $hash = $this->notarization_hash ?: $this->pdf_sha256;
        $hash = strtolower(ltrim((string) $hash, '0x'));

        return '0x'.$hash;
    }

    public function polygonscanUrl(): ?string
    {
        if (! $this->notarization_tx_hash) {
            return null;
        }

        $tx = strtolower(ltrim($this->notarization_tx_hash, '0x'));

        return rtrim((string) config('product_certificates.polygonscan_tx_url'), '/').'/0x'.$tx;
    }
}
