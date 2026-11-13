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

        // Trailing slash (eccetto root)
        if ($path !== '/' && str_ends_with($path, '/')) {
            $target = rtrim($path, '/') ?: '/';
            $qs = $request->getQueryString();

            return redirect()->to($target.($qs ? '?'.$qs : ''), 301);
        }

        $locale = 'it';
        $rest = ltrim($path, '/');
        if (preg_match('#^(en|fr|de|es)(/|$)#', $rest, $m)) {
            $locale = $m[1];
            $rest = substr($rest, strlen($m[1]));
            $rest = ltrim((string) $rest, '/');
        }

        // Le chiavi in config/localized_slugs.php sono letterali tipo "catalog.index"
        // (il punto NON è nesting Laravel).
        $catalogSlugs = (array) (config('localized_slugs')['catalog.index'] ?? []);
        $canonicalCatalog = (string) ($catalogSlugs[$locale] ?? 'catalogo');
        $catalogAliases = array_values(array_unique(array_filter(
            array_map('strval', array_values($catalogSlugs))
        )));

        // Solo index catalogo esatto (non /catalogo/search)
        if (in_array($rest, $catalogAliases, true) && $rest !== $canonicalCatalog) {
            $prefix = $locale === 'it' ? '' : $locale.'/';
            $qs = $request->getQueryString();
            $target = '/'.$prefix.$canonicalCatalog;
            $target = preg_replace('#/+#', '/', $target) ?: '/';

            return redirect()->to($target.($qs ? '?'.$qs : ''), 301);
        }

        return $next($request);
    }
}
