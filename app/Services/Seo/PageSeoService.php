<?php

namespace App\Services\Seo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Canonical assoluto, meta robots e hreflang per la richiesta corrente.
 */
class PageSeoService
{
    /** Parametri che restano nel canonical (paginazione self-referential). */
    private const CANONICAL_QUERY_ALLOWLIST = ['page'];

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

        $hasNoindexQuery = $this->hasNoindexQuery($request);
        $isPrivateRoute = $this->isNoindexRoute($request);

        if ($hasNoindexQuery) {
            $canonical = $canonicalFromAlternates ?: $this->absoluteCleanUrl($request, includePage: false);
            $robots = 'noindex,follow';
        } elseif ($isPrivateRoute) {
            $canonical = $this->absoluteCleanUrl($request, includePage: false);
            $robots = 'noindex,follow';
            $alternates = [];
        } else {
            $canonical = $canonicalFromAlternates ?: $this->absoluteCleanUrl($request, includePage: true);
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

    private function hasNoindexQuery(Request $request): bool
    {
        foreach (self::NOINDEX_QUERY_PARAMS as $param) {
            if ($request->query->has($param) && $request->query($param) !== null && $request->query($param) !== '') {
                return true;
            }
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

    private function absoluteCleanUrl(Request $request, bool $includePage): string
    {
        $path = '/'.ltrim($request->path(), '/');
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        $query = [];
        if ($includePage) {
            $page = (int) $request->query('page', 0);
            if ($page > 1) {
                $query['page'] = $page;
            }
        }

        $url = url($path);
        if ($query !== []) {
            $url .= '?'.http_build_query($query);
        }

        return $url;
    }
}
