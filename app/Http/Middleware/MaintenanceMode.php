<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Mostra la pagina "sito in manutenzione" a tutti tranne agli IP autorizzati.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('maintenance.enabled')) {
            return $next($request);
        }

        if ($this->isAllowed($request)) {
            return $next($request);
        }

        // Lascia passare health check e callback PayPal (IPN / ritorno utente).
        if ($request->is('up', 'ipn.php', 'paypal/response')) {
            return $next($request);
        }

        $page = public_path('manutenzione.php');
        $html = is_file($page)
            ? (string) file_get_contents($page)
            : '<h1>Sito in manutenzione</h1>';

        return response($html, 503, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Retry-After' => '3600',
            'Cache-Control' => 'no-cache, private',
        ]);
    }

    /**
     * Verifica se l'IP del client e tra quelli autorizzati.
     */
    protected function isAllowed(Request $request): bool
    {
        $allowed = (array) config('maintenance.allowed_ips', []);

        if ($allowed === []) {
            return false;
        }

        foreach ($this->clientIps($request) as $ip) {
            if (in_array($ip, $allowed, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Raccoglie i possibili IP reali del client (gestendo proxy/Cloudflare).
     *
     * @return array<int, string>
     */
    protected function clientIps(Request $request): array
    {
        $ips = [];

        $cf = $request->header('CF-Connecting-IP');
        if ($cf) {
            $ips[] = trim($cf);
        }

        $xff = $request->header('X-Forwarded-For');
        if ($xff) {
            foreach (explode(',', $xff) as $part) {
                $ips[] = trim($part);
            }
        }

        foreach ($request->getClientIps() as $ip) {
            $ips[] = $ip;
        }

        $ips[] = $request->ip();

        return array_values(array_filter(array_unique($ips)));
    }
}
