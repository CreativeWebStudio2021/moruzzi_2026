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
    private const WWW_HOSTS = ['moruzzi.it', 'www.moruzzi.it'];

    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->getHost(), self::WWW_HOSTS, true)) {
            return $next($request);
        }

        $target = $this->resolveTarget($request);
        if ($target === null) {
            return $next($request);
        }

        return redirect()->to($target, 301);
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

        if (count($segments) > 1 && isset($langMap[$segments[0]])) {
            $locale = $langMap[$segments[0]];
        }

        $category = resolve_category_by_link($path, $locale);
        if ($category) {
            $canonical = ltrim((string) ($category->{'link_'.$locale} ?? $category->link_it), '/');
            if (strtolower($canonical) !== strtolower($path)) {
                foreach (category_link_alternates($path) as $alternate) {
                    if (strtolower($alternate) === strtolower($canonical)) {
                        $prefix = $locale === 'it' ? '' : $locale.'/';

                        return url('/'.$prefix.$canonical);
                    }
                }
            }

            return null;
        }

        $key = strtolower(basename($path));
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

        if ($relative === null && ! str_contains($path, '/')) {
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
