<?php

namespace App\Services\Seo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Canonical assoluto, meta robots e hreflang per la richiesta corrente.
 */
class PageSeoService
{
    /** Parametri che rendono la pagina noindex,follow (canonical pulito senza di essi). */
    private const NOINDEX_QUERY_PARAMS = [
        'q', 'order', 'direction', 'per_page', 'category', 'offerte',
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
        'gclid', 'fbclid', 'msclkid', 'ref', 'sort',
    ];

    private const NOINDEX_ROUTE_NAMES = [
        'cart.index',
        'cart.add',
        'cart.update',
        'cart.remove',
        'checkout.options',
        'checkout.guest',
        'checkout.shipping',
        'checkout.review',
        'checkout.thankyou',
        'account.register.page',
        'account.dashboard',
        'account.orders',
        'account.orders.show',
        'account.shipping',
        'account.password',
        'login',
        'register',
        'password.request',
        'password.reset',
        'contact.thankyou',
    ];

    /**
     * @param  array<string, mixed>  $viewData
     * @return array{canonical: string, robots: ?string, alternates: array<string, string>}
     */
    public function forRequest(Request $request, array $viewData = []): array
    {
        $alternates = $this->resolveAlternates($viewData, $request);
        $locale = app()->getLocale();

        $canonicalFromAlternates = is_string($alternates[$locale] ?? null)
            ? $alternates[$locale]
            : (is_string($alternates['it'] ?? null) ? $alternates['it'] : null);

        $rawQuery = $this->rawQueryParams($request);
        $hasNoindexQuery = $this->hasNoindexQuery($rawQuery);
        $isPrivateRoute = $this->isNoindexRoute($request);
        $page = (int) ($rawQuery['page'] ?? 0);

        if ($hasNoindexQuery) {
            // Canonical pulito (senza tracking/filtri); page esclusa
            $canonical = $canonicalFromAlternates ?: $this->absoluteCleanUrl($request, page: 0);
            $robots = 'noindex,follow';
        } elseif ($isPrivateRoute) {
            $canonical = $this->absoluteCleanUrl($request, page: 0);
            $robots = 'noindex,follow';
            $alternates = [];
        } else {
            // Paginazione: canonical autoreferenziale (?page=N per N>1, mai forzato a page 1)
            $base = $canonicalFromAlternates ?: $this->absoluteCleanUrl($request, page: 0);
            $canonical = ($page > 1) ? $base.'?page='.$page : $base;
            $robots = null;
        }

        return [
            'canonical' => $canonical,
            'robots' => $robots,
            'alternates' => $alternates,
        ];
    }

    /**
     * @param  array<string, mixed>  $viewData
     * @return array<string, string>
     */
    private function resolveAlternates(array $viewData, Request $request): array
    {
        $raw = $viewData['seoAlternates']
            ?? $viewData['productAlternateUrls']
            ?? $viewData['catalogAlternateUrls']
            ?? $viewData['alternateUrls']
            ?? null;

        if (is_array($raw) && $raw !== []) {
            $out = [];
            foreach ($raw as $locale => $href) {
                if (! is_string($locale) || ! is_string($href) || $href === '') {
                    continue;
                }
                $out[$locale] = $href;
            }

            return $out;
        }

        return $this->alternatesFromLocalizedRoute($request);
    }

    /**
     * Hreflang da config localized_slugs per la route corrente (solo path localizzati reali).
     *
     * @return array<string, string>
     */
    private function alternatesFromLocalizedRoute(Request $request): array
    {
        $route = Route::current();
        if (! $route) {
            return [];
        }

        $name = $route->getName();
        if (! is_string($name) || $name === '') {
            return [];
        }

        $bare = preg_replace('#^locale\.#', '', $name) ?? $name;
        $slugs = config('localized_slugs')[$bare] ?? null;
        if (! is_array($slugs) || $slugs === []) {
            return [];
        }

        $urls = [];
        foreach (['it', 'en', 'es', 'fr', 'de'] as $locale) {
            if (! array_key_exists($locale, $slugs)) {
                continue;
            }
            $path = (string) $slugs[$locale];
            // home: path vuoto è valido
            if ($bare !== 'home' && $path === '') {
                continue;
            }
            $prefix = $locale === 'it' ? '' : $locale.'/';
            $urls[$locale] = url($prefix.ltrim($path, '/'));
        }

        return $urls;
    }

    /**
     * Query string originale del client (ignora valori injectati con Request::merge).
     *
     * @return array<string, mixed>
     */
    private function rawQueryParams(Request $request): array
    {
        $qs = (string) $request->server->get('QUERY_STRING', '');
        if ($qs === '') {
            return [];
        }

        $parsed = [];
        parse_str($qs, $parsed);

        return is_array($parsed) ? $parsed : [];
    }

    /**
     * @param  array<string, mixed>  $rawQuery
     */
    private function hasNoindexQuery(array $rawQuery): bool
    {
        foreach (self::NOINDEX_QUERY_PARAMS as $param) {
            if (! array_key_exists($param, $rawQuery)) {
                continue;
            }
            $value = $rawQuery[$param];
            if ($value === null || $value === '') {
                continue;
            }

            return true;
        }

        return false;
    }

    private function isNoindexRoute(Request $request): bool
    {
        $route = Route::current();
        if (! $route) {
            return false;
        }

        $name = $route->getName();
        if (! is_string($name) || $name === '') {
            return false;
        }

        $bare = preg_replace('#^locale\.#', '', $name) ?? $name;

        return in_array($bare, self::NOINDEX_ROUTE_NAMES, true);
    }

    private function absoluteCleanUrl(Request $request, int $page = 0): string
    {
        $path = '/'.ltrim($request->path(), '/');
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        $url = url($path);
        if ($page > 1) {
            $url .= '?page='.$page;
        }

        return $url;
    }
}
