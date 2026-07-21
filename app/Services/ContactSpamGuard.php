<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactSpamGuard
{
    /** Domini email usati ripetutamente dallo spam attuale. */
    private const BLOCKED_EMAIL_DOMAINS = [
        'gungen.com',
    ];

    public function shouldReject(Request $request, array $data): bool
    {
        if ($request->filled('website')) {
            return true;
        }

        $startedAt = (int) $request->input('_started', 0);
        if ($startedAt > 0) {
            $elapsed = time() - $startedAt;
            if ($elapsed < 3 || $elapsed > 7200) {
                return true;
            }
        }

        $rateLimitKey = 'contact-form:'.$request->ip();
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            return true;
        }

        RateLimiter::hit($rateLimitKey, 3600);

        return $this->matchesSpamPatterns($data);
    }

    /**
     * @param  array{nome?: string, cognome?: string, email?: string, telefono?: string|null, messaggio?: string}  $data
     */
    public function matchesSpamPatterns(array $data): bool
    {
        $nome = strtolower(trim((string) ($data['nome'] ?? '')));
        $cognome = trim((string) ($data['cognome'] ?? ''));
        $email = strtolower(trim((string) ($data['email'] ?? '')));
        $telefono = preg_replace('/\D+/', '', (string) ($data['telefono'] ?? ''));

        if ($nome !== '' && preg_match('/rof$/i', $nome)) {
            return true;
        }

        if ($cognome !== '' && preg_match('/rofgm$/i', $cognome)) {
            return true;
        }

        if ($email !== '') {
            $domain = substr(strrchr($email, '@') ?: '', 1);
            if ($domain !== '' && in_array($domain, self::BLOCKED_EMAIL_DOMAINS, true)) {
                return true;
            }
        }

        // Telefoni fittizi a 11 cifre che iniziano per 8 (pattern campagna attuale).
        if ($telefono !== '' && preg_match('/^8\d{10}$/', $telefono)) {
            return true;
        }

        return false;
    }
}
