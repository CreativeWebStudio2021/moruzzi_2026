<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 301 SEO: strip trailing slash e alias catalogo → slug canonico per lingua.
 */
class NormalizeSeoRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->method(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $path = $request->getPathInfo(); // inizia con /
        $hadTrailingSlash = ($path !== '/' && str_ends_with($path, '/'));
        $normalizedPath = $hadTrailingSlash ? (rtrim($path, '/') ?: '/') : $path;

        $locale = 'it';
        $rest = ltrim($normalizedPath, '/');
        if (preg_match('#^(en|fr|de|es)(/|$)#', $rest, $m)) {
            $locale = $m[1];
            $rest = substr($rest, strlen($m[1]));
            $rest = ltrim((string) $rest, '/');
        }

        // Chiavi letterali "catalog.index" in config/localized_slugs.php
        $catalogSlugs = (array) (config('localized_slugs')['catalog.index'] ?? []);
        $canonicalCatalog = (string) ($catalogSlugs[$locale] ?? 'catalogo');
        $catalogAliases = array_values(array_unique(array_filter(
            array_map('strval', array_values($catalogSlugs))
        )));

        $qs = $request->getQueryString();
        $qsSuffix = $qs ? '?'.$qs : '';

        // Alias catalogo → slug canonico (eventuale slash assorbito nello stesso 301)
        if (in_array($rest, $catalogAliases, true) && $rest !== $canonicalCatalog) {
            $prefix = $locale === 'it' ? '' : $locale.'/';
            $target = '/'.$prefix.$canonicalCatalog;
            $target = preg_replace('#/+#', '/', $target) ?: '/';

            return redirect()->to($target.$qsSuffix, 301);
        }

        // Solo strip slash (nessun alias da applicare)
        if ($hadTrailingSlash) {
            return redirect()->to($normalizedPath.$qsSuffix, 301);
        }

        return $next($request);
    }
}
