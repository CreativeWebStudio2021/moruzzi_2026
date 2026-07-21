<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareCacheService
{
    public function isConfigured(): bool
    {
        return filled(config('cloudflare.zone_id'))
            && filled(config('cloudflare.api_token'));
    }

    /**
     * Invalida la cache CDN Cloudflare per URL pubbliche (es. img.moruzzi.it).
     *
     * @param  list<string>  $urls
     */
    public function purgeUrls(array $urls): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $urls = array_values(array_unique(array_filter(array_map(
            fn ($url) => is_string($url) ? trim($url) : '',
            $urls
        ))));

        if ($urls === []) {
            return false;
        }

        $chunks = array_chunk($urls, 30);

        foreach ($chunks as $chunk) {
            $response = Http::withToken((string) config('cloudflare.api_token'))
                ->acceptJson()
                ->post(
                    'https://api.cloudflare.com/client/v4/zones/' . config('cloudflare.zone_id') . '/purge_cache',
                    ['files' => $chunk],
                );

            if (! $response->successful() || ! ($response->json('success') ?? false)) {
                Log::warning('Cloudflare cache purge failed', [
                    'urls' => $chunk,
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return false;
            }
        }

        return true;
    }
}
