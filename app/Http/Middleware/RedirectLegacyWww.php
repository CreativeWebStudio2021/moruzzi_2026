<?php

namespace App\Http\Middleware;

use App\Support\LegacyCategoryRedirectResolver;
use App\Support\LegacyEditorialRedirectResolver;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reindirizza in 301 gli URL legacy .html di www.moruzzi.it verso i nuovi path canonici.
 */
class RedirectLegacyWww
{
    private const WWW_HOSTS = ['moruzzi.it', 'www.moruzzi.it', 'staging.moruzzi.it'];

    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->getHost(), self::WWW_HOSTS, true)) {
            return $next($request);
        }

        if ($this->isGoneLegacyAsset($request)) {
            return response('Gone', 410);
        }

        $target = $this->resolveTarget($request);
        if ($target === null) {
            return $next($request);
        }

        return redirect()->to($target, 301);
    }

    /**
     * Immagini e feed del sito precedente sotto /lang* → 410.
     */
    private function isGoneLegacyAsset(Request $request): bool
    {
        $path = strtolower(trim($request->path(), '/'));
        if ($path === '') {
            return false;
        }

        if (preg_match('#^lang[1-6]/x5feed\.php$#', $path)) {
            return true;
        }

        if (preg_match('#^lang[1-6]/images/#', $path)) {
            return true;
        }

        // Favicon/asset sparsi nelle cartelle lang legacy
        if (preg_match('#^lang[1-6]/.*\.(png|jpe?g|gif|webp|ico|svg|css|js)$#', $path)) {
            return true;
        }

        return false;
    }

    private function resolveTarget(Request $request): ?string
    {
        $path = trim($request->path(), '/');

        $folderRoots = config('legacy_redirects.folder_roots', []);
        if (isset($folderRoots[$path])) {
            $target = (string) $folderRoots[$path];
            $url = $target === '/'
                ? url('/')
                : url(rtrim($target, '/').'/');

            if ($this->isSameRequestPath($request, $url)) {
                return null;
            }

            return $url;
        }

        if ($path === '' || ! str_contains($path, '.html')) {
            return null;
        }

        $locale = 'it';
        $langMap = config('legacy_redirects.lang_folder_map', []);
        $segments = explode('/', $path);
        $pathForLookup = $path;

        if (count($segments) > 1 && isset($langMap[$segments[0]])) {
            $locale = $langMap[$segments[0]];
            $pathForLookup = implode('/', array_slice($segments, 1));
        }

        // Categoria: cerca su tutte le link_* (es. /billets.html = FR di Banconote)
        $categoryHit = $this->resolveCategoryAcrossLocales($pathForLookup);
        if ($categoryHit !== null) {
            [$category, $ownerLocale] = $categoryHit;
            $useLocale = $locale !== 'it' ? $locale : $ownerLocale;
            $canonical = ltrim((string) ($category->{'link_'.$useLocale} ?? $category->link_it ?? ''), '/');
            if ($canonical === '') {
                return null;
            }
            $prefix = $useLocale === 'it' ? '' : $useLocale.'/';
            $url = url('/'.$prefix.$canonical);
            if ($this->isSameRequestPath($request, $url)) {
                return null;
            }

            return $url;
        }

        $key = strtolower(basename($pathForLookup));
        $files = config('legacy_redirects.files', []);
        $relative = null;
        $anchor = null;

        $targetLocale = $locale;

        if (isset($files[$key])) {
            $rule = $files[$key];
            $anchor = $rule['anchor'] ?? null;
            [$relative, $targetLocale] = $this->relativePathFromRule($rule, $locale);
        }

        if ($relative === null) {
            $relative = LegacyCategoryRedirectResolver::resolve($key, $locale);
            $targetLocale = $locale;
        }

        if ($relative === null && ! str_contains($pathForLookup, '/')) {
            $relative = LegacyEditorialRedirectResolver::resolve($key, $locale);
            $targetLocale = $locale;
        }

        if ($relative === null) {
            return null;
        }

        $url = $relative === ''
            ? url('/')
            : ($targetLocale === 'it'
                ? url('/'.$relative)
                : url('/'.$targetLocale.'/'.$relative));

        if ($anchor) {
            $url .= '#'.$anchor;
        }

        $query = $request->getQueryString();
        if ($query) {
            $url .= '?'.$query;
        }

        if ($this->isSameRequestPath($request, $url)) {
            return null;
        }

        return $url;
    }

    /**
     * @return array{0: \App\Models\Category, 1: string}|null
     */
    private function resolveCategoryAcrossLocales(string $path): ?array
    {
        foreach (['it', 'en', 'fr', 'de', 'es'] as $locale) {
            $category = resolve_category_by_link($path, $locale);
            if ($category) {
                $col = 'link_'.$locale;
                $link = strtolower((string) ($category->{$col} ?? ''));
                $needle = strtolower($path);
                if ($link === $needle || str_ends_with($link, '/'.$needle) || basename($link) === basename($needle)) {
                    return [$category, $locale];
                }
                // match su un'altra colonna ma trovato via fallback link_it
                foreach (['it', 'en', 'fr', 'de', 'es'] as $owner) {
                    $ownerLink = strtolower((string) ($category->{'link_'.$owner} ?? ''));
                    if ($ownerLink === $needle) {
                        return [$category, $owner];
                    }
                }

                return [$category, $locale];
            }
        }

        // Match esatto su qualsiasi colonna (path completo)
        $category = \App\Models\Category::query()
            ->where('link_it', $path)
            ->orWhere('link_en', $path)
            ->orWhere('link_fr', $path)
            ->orWhere('link_de', $path)
            ->orWhere('link_es', $path)
            ->first();

        if (! $category) {
            return null;
        }

        foreach (['it', 'en', 'fr', 'de', 'es'] as $owner) {
            if (strtolower((string) ($category->{'link_'.$owner} ?? '')) === strtolower($path)) {
                return [$category, $owner];
            }
        }

        return [$category, 'it'];
    }

    /**
     * @param  array<string, mixed>  $rule
     * @return array{0: ?string, 1: string} [path relativo, locale da usare nel prefisso]
     */
    private function relativePathFromRule(array $rule, string $locale): array
    {
        if (! empty($rule['paths'][$locale])) {
            return [ltrim((string) $rule['paths'][$locale], '/'), $locale];
        }

        if (! empty($rule['path'])) {
            return [ltrim((string) $rule['path'], '/'), $locale];
        }

        if (isset($rule['route'])) {
            $slugs = config('localized_slugs', []);
            $path = ltrim((string) ($slugs[$rule['route']][$locale] ?? $slugs[$rule['route']]['it'] ?? ''), '/');

            return [$path !== '' ? $path : null, $locale];
        }

        // Fallback: usa la prima lingua disponibile nella regola (evita 404 su mappe mono-lingua)
        if (! empty($rule['paths']) && is_array($rule['paths'])) {
            foreach (['it', 'en', 'es', 'fr', 'de'] as $fallbackLocale) {
                if (! empty($rule['paths'][$fallbackLocale])) {
                    return [ltrim((string) $rule['paths'][$fallbackLocale], '/'), $fallbackLocale];
                }
            }
        }

        return [null, $locale];
    }

    private function isSameRequestPath(Request $request, string $targetUrl): bool
    {
        $currentPath = '/'.strtolower(trim($request->path(), '/'));
        $targetPath = strtolower((string) parse_url($targetUrl, PHP_URL_PATH));

        return rtrim($currentPath, '/') === rtrim($targetPath, '/');
    }
}
