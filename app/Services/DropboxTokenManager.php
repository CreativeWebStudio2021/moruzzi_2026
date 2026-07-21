<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class DropboxTokenManager
{
    private const TOKEN_URL = 'https://api.dropbox.com/oauth2/token';

    public function __construct(
        private readonly ?string $appKey,
        private readonly ?string $appSecret,
        private readonly ?string $accessToken,
        private readonly ?string $refreshToken,
        private readonly string $tokenCacheFile,
    ) {}

    public function accessToken(): string
    {
        if ($this->accessToken !== null && $this->accessToken !== '') {
            return $this->accessToken;
        }

        if ($this->refreshToken === null || $this->refreshToken === '') {
            throw new RuntimeException(
                'Nessun token Dropbox configurato. Esegui: php artisan dropbox:authorize'
            );
        }

        return $this->refreshAccessToken();
    }

    /**
     * @return array{access_token: string, refresh_token: string, expires_in: int}
     */
    public function exchangeAuthorizationCode(string $code): array
    {
        $this->assertAppCredentials();

        $response = Http::asForm()
            ->post(self::TOKEN_URL, [
                'code' => $code,
                'grant_type' => 'authorization_code',
                'client_id' => $this->appKey,
                'client_secret' => $this->appSecret,
            ])
            ->throw()
            ->json();

        if (! is_array($response) || empty($response['access_token'])) {
            throw new RuntimeException('Risposta token Dropbox non valida.');
        }

        $this->cacheToken($response);

        return [
            'access_token' => $response['access_token'],
            'refresh_token' => $response['refresh_token'] ?? '',
            'expires_in' => (int) ($response['expires_in'] ?? 0),
        ];
    }

    public function authorizationUrl(): string
    {
        $this->assertAppCredentials();

        $query = http_build_query([
            'client_id' => $this->appKey,
            'response_type' => 'code',
            'token_access_type' => 'offline',
        ]);

        return 'https://www.dropbox.com/oauth2/authorize?'.$query;
    }

    private function refreshAccessToken(): string
    {
        $this->assertAppCredentials();

        $response = Http::asForm()
            ->post(self::TOKEN_URL, [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->refreshToken,
                'client_id' => $this->appKey,
                'client_secret' => $this->appSecret,
            ])
            ->throw()
            ->json();

        if (! is_array($response) || empty($response['access_token'])) {
            throw new RuntimeException('Impossibile rinnovare il token Dropbox.');
        }

        $this->cacheToken($response);

        return $response['access_token'];
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function cacheToken(array $payload): void
    {
        file_put_contents($this->tokenCacheFile, json_encode([
            'access_token' => $payload['access_token'],
            'expires_at' => now()->addSeconds((int) ($payload['expires_in'] ?? 14400))->timestamp,
        ], JSON_PRETTY_PRINT));
    }

    private function assertAppCredentials(): void
    {
        if ($this->appKey === null || $this->appKey === '' || $this->appSecret === null || $this->appSecret === '') {
            throw new RuntimeException('Configura DROPBOX_APP_KEY e DROPBOX_APP_SECRET nel .env.');
        }
    }
}
