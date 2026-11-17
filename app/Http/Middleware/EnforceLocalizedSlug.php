<?php

namespace App\Http\Middleware;

use App\Support\GuideRegistry;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Se lo slug appartiene a un'altra lingua rispetto al prefisso URL,
 * 301 verso lo slug corretto per la lingua corrente.
 */
class EnforceLocalizedSlug
{
    /** @var array<string, list<array{route: string, locale: string}>>|null */
    private static ?array $pathIndex = null;

    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->method(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $path = $request->getPathInfo();
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/') ?: '/';
        }

        $locale = 'it';
        $rest = ltrim($path, '/');
        if (preg_match('#^(en|fr|de|es)(/|$)#', $rest, $m)) {
            $locale = $m[1];
            $rest = ltrim(substr($rest, strlen($m[1])), '/');
        }

        // Home, asset, prodotti/categorie .html: non intervenire qui
        if ($rest === '' || str_contains($rest, '.')) {
            return $next($request);
        }

        // Già gestito da NormalizeSeoRequest / controller
        if (preg_match('/-\d+\.html$/i', $rest) || str_ends_with(strtolower($rest), '.html')) {
            return $next($request);
        }

        $owners = $this->ownersForPath($rest);
        if ($owners === []) {
            return $next($request);
        }

        foreach ($owners as $owner) {
            if ($owner['locale'] === $locale) {
                return $next($request);
            }
        }

        // Slug di un'altra lingua: 301 allo slug della lingua del prefisso
        $routeName = $owners[0]['route'];
        $target = route_url_for_locale($routeName, $locale);
        $qs = $request->getQueryString();
        if ($qs) {
            $target .= (str_contains($target, '?') ? '&' : '?').$qs;
        }

        $current = $request->url().($qs ? '?'.$qs : '');
        if (rtrim($target, '/') === rtrim($current, '/')) {
            return $next($request);
        }

        return redirect()->to($target, 301);
    }

    /**
     * @return list<array{route: string, locale: string}>
     */
    private function ownersForPath(string $path): array
    {
        $path = trim($path, '/');
        if ($path === '') {
            return [];
        }

        $index = $this->pathIndex();

        return $index[$path] ?? [];
    }

    /**
     * @return array<string, list<array{route: string, locale: string}>>
     */
    private function pathIndex(): array
    {
        if (self::$pathIndex !== null) {
            return self::$pathIndex;
        }

        $index = [];
        foreach (config('localized_slugs', []) as $routeName => $paths) {
            if (! is_array($paths)) {
                continue;
            }
            foreach ($paths as $locale => $slug) {
                if (! is_string($locale) || ! is_string($slug)) {
                    continue;
                }
                $slug = trim($slug, '/');
                if ($slug === '') {
                    continue;
                }
                $index[$slug][] = ['route' => (string) $routeName, 'locale' => $locale];
            }
        }

        foreach (GuideRegistry::articles() as $article) {
            $routeName = (string) ($article['redirect_route'] ?? $article['route'] ?? '');
            if ($routeName === '') {
                continue;
            }
            foreach (['it', 'en', 'fr', 'de', 'es'] as $locale) {
                $slug = GuideRegistry::pathForArticle($article, $locale);
                if (! is_string($slug) || ($slug = trim($slug, '/')) === '') {
                    continue;
                }
                $index[$slug][] = ['route' => $routeName, 'locale' => $locale];
            }
        }

        return self::$pathIndex = $index;
    }
}
