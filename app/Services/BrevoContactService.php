<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoContactService
{
    protected string $baseUrl = 'https://api.brevo.com/v3';

    public function isConfigured(): bool
    {
        return filled(config('services.brevo.api_key'));
    }

    /**
     * Crea o aggiorna un contatto e lo iscrive alla lista newsletter configurata.
     *
     * @param  array<string, string>  $attributes
     */
    public function subscribe(string $email, array $attributes = []): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $payload = [
            'email' => $email,
            'updateEnabled' => true,
            'emailBlacklisted' => false,
        ];

        if ($listId = $this->listId()) {
            $payload['listIds'] = [$listId];
        }

        if ($attributes !== []) {
            $payload['attributes'] = $attributes;
        }

        $response = $this->client()
            ->post("{$this->baseUrl}/contacts", $payload);

        if ($response->successful()) {
            return true;
        }

        Log::warning('Brevo: iscrizione contatto non riuscita', [
            'email' => $email,
            'status' => $response->status(),
            'body' => $response->json() ?? $response->body(),
        ]);

        return false;
    }

    /**
     * Rimuove il contatto dalla lista newsletter (e opzionalmente dalla blocklist email).
     */
    public function unsubscribe(string $email): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $payload = [
            'emailBlacklisted' => true,
        ];

        if ($listId = $this->listId()) {
            $payload['unlinkListIds'] = [$listId];
            $payload['emailBlacklisted'] = false;
        }

        $response = $this->client()
            ->put("{$this->baseUrl}/contacts/".rawurlencode($email), $payload);

        if ($response->successful() || $response->status() === 204) {
            return true;
        }

        if ($response->status() === 404) {
            return true;
        }

        Log::warning('Brevo: disiscrizione contatto non riuscita', [
            'email' => $email,
            'status' => $response->status(),
            'body' => $response->json() ?? $response->body(),
        ]);

        return false;
    }

    /**
     * @return array<string, string>
     */
    public function attributesFromNames(?string $firstName, ?string $lastName): array
    {
        $attributes = [];
        $firstKey = (string) config('services.brevo.attr_first_name', 'FNAME');
        $lastKey = (string) config('services.brevo.attr_last_name', 'LNAME');

        if ($firstName !== null && $firstName !== '') {
            $attributes[$firstKey] = $firstName;
        }

        if ($lastName !== null && $lastName !== '') {
            $attributes[$lastKey] = $lastName;
        }

        return $attributes;
    }

    /**
     * Client HTTP per Brevo: header api-key, JSON e IPv4 forzato.
     *
     * Brevo applica una whitelist sugli "Authorised IPs": forziamo IPv4 così
     * le chiamate escono sempre dall'IP pubblico stabile del server (e non da
     * un eventuale indirizzo IPv6 temporaneo che cambierebbe nel tempo).
     */
    protected function client(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders($this->headers())
            ->acceptJson()
            ->withOptions(['curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4]]);
    }

    protected function listId(): ?int
    {
        $listId = config('services.brevo.list_id');

        return $listId !== null && $listId !== '' ? (int) $listId : null;
    }

    /**
     * @return array<string, string>
     */
    protected function headers(): array
    {
        return [
            'api-key' => (string) config('services.brevo.api_key'),
        ];
    }
}
