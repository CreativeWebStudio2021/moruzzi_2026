<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TurnstileService
{
    public function isEnabled(): bool
    {
        return filled(config('cloudflare.turnstile.site_key'))
            && filled(config('cloudflare.turnstile.secret_key'));
    }

    public function siteKey(): ?string
    {
        $key = config('cloudflare.turnstile.site_key');

        return filled($key) ? (string) $key : null;
    }

    /**
     * Verifica il token lato server (Siteverify). Se Turnstile non è configurato, passa.
     */
    public function verify(?string $token, ?string $remoteIp = null): bool
    {
        if (! $this->isEnabled()) {
            return true;
        }

        $token = is_string($token) ? trim($token) : '';
        if ($token === '') {
            return false;
        }

        try {
            $payload = [
                'secret' => config('cloudflare.turnstile.secret_key'),
                'response' => $token,
            ];

            if (filled($remoteIp)) {
                $payload['remoteip'] = $remoteIp;
            }

            $response = Http::asForm()
                ->timeout(8)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', $payload);

            if (! $response->successful()) {
                Log::warning('Turnstile siteverify HTTP error', [
                    'status' => $response->status(),
                ]);

                return false;
            }

            $body = $response->json();

            return (bool) ($body['success'] ?? false);
        } catch (\Throwable $e) {
            Log::warning('Turnstile siteverify exception', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
