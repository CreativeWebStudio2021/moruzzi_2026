<?php

namespace App\Support;

class GuideRegistry
{
    private static ?array $articlesByRoute = null;

    private static ?array $articlesById = null;

    public static function config(): array
    {
        return config('guide', []);
    }

    public static function prefix(string $locale): string
    {
        return self::config()['prefix'][$locale] ?? self::config()['prefix']['it'] ?? 'guida';
    }

    public static function sectionSlug(string $sectionKey, string $locale): string
    {
        return self::config()['sections'][$sectionKey]['slug'][$locale]
            ?? self::config()['sections'][$sectionKey]['slug']['it']
            ?? '';
    }

    public static function articleSlug(array $article, string $locale): string
    {
        $id = $article['id'] ?? '';
        $localized = config("guide_article_slugs.{$id}");

        if (is_array($localized) && ($localized[$locale] ?? '') !== '') {
            return (string) $localized[$locale];
        }

        if (is_array($localized) && ($localized['it'] ?? '') !== '') {
            return (string) $localized['it'];
        }

        return (string) ($article['slug'] ?? '');
    }

    /**
     * Path con slug articolo italiano (URL errati pre-localizzazione slug).
     */
    public static function legacyItalianSlugPath(array $article, string $locale): ?string
    {
        if ($locale === 'it') {
            return null;
        }

        $italianSlug = self::articleSlug($article, 'it');
        $currentSlug = self::articleSlug($article, $locale);

        if ($italianSlug === '' || $italianSlug === $currentSlug) {
            return null;
        }

        $prefix = self::prefix($locale);
        $sectionSlug = self::sectionSlug($article['section'], $locale);
        $segments = array_filter([$prefix, $sectionSlug, $italianSlug], fn ($s) => $s !== '');

        return implode('/', $segments);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function articles(): array
    {
        return self::config()['articles'] ?? [];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function articlesByRoute(): array
    {
        if (self::$articlesByRoute !== null) {
            return self::$articlesByRoute;
        }

        self::$articlesByRoute = [];

        foreach (self::articles() as $article) {
            self::$articlesByRoute[$article['route']] = $article;
        }

        return self::$articlesByRoute;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function articlesById(): array
    {
        if (self::$articlesById !== null) {
            return self::$articlesById;
        }

        self::$articlesById = [];

        foreach (self::articles() as $article) {
            self::$articlesById[$article['id']] = $article;
        }

        return self::$articlesById;
    }

    public static function findByRoute(string $routeName): ?array
    {
        return self::articlesByRoute()[$routeName] ?? null;
    }

    public static function findByPath(string $path, ?string $locale = null): ?array
    {
        $path = trim($path, '/');

        if ($path === '') {
            return null;
        }

        $locales = $locale !== null
            ? [$locale]
            : array_keys(self::config()['prefix'] ?? ['it' => 'guida']);

        foreach (self::articles() as $article) {
            foreach ($locales as $loc) {
                if (self::pathForArticle($article, $loc) === $path) {
                    return $article;
                }

                $legacyPath = self::legacyItalianSlugPath($article, $loc);
                if ($legacyPath !== null && $legacyPath === $path) {
                    return $article;
                }
            }
        }

        return null;
    }

    public static function pathFor(string $routeName, string $locale): ?string
    {
        $article = self::findByRoute($routeName);
        if ($article === null) {
            return null;
        }

        return self::pathForArticle($article, $locale);
    }

    public static function pathForArticle(array $article, string $locale): string
    {
        $prefix = self::prefix($locale);
        $sectionSlug = self::sectionSlug($article['section'], $locale);
        $articleSlug = self::articleSlug($article, $locale);

        if ($article['route'] === 'guide.index') {
            return $prefix;
        }

        $segments = array_filter([$prefix, $sectionSlug, $articleSlug], fn ($s) => $s !== '');

        return implode('/', $segments);
    }

    /**
     * @return array<string, array<string, string>>
     */
    public static function localizedSlugs(): array
    {
        $map = [];
        $locales = array_keys(self::config()['prefix'] ?? ['it' => 'guida']);

        foreach (self::articles() as $article) {
            $paths = [];
            foreach ($locales as $locale) {
                $paths[$locale] = self::pathForArticle($article, $locale);
            }
            $map[$article['route']] = $paths;
        }

        return $map;
    }

    /**
     * @return array<string, array{route: string}>
     */
    public static function legacyRedirects(): array
    {
        $redirects = [];

        foreach (self::articles() as $article) {
            $targetRoute = $article['redirect_route'] ?? $article['route'];

            foreach ($article['legacy'] ?? [] as $legacyFile) {
                if (! isset($redirects[$legacyFile])) {
                    $redirects[$legacyFile] = ['route' => $targetRoute];
                }
            }
        }

        return $redirects;
    }

    /**
     * @return list<array{route: string, key: string, section: string}>
     */
    public static function navItems(): array
    {
        $items = [];

        foreach (self::articles() as $article) {
            if (($article['nav'] ?? true) === false) {
                continue;
            }

            if ($article['route'] === 'guide.index') {
                continue;
            }

            $items[] = [
                'route' => $article['redirect_route'] ?? $article['route'],
                'key' => $article['id'],
                'section' => $article['section'],
            ];
        }

        return $items;
    }

    /**
     * @return list<array{key: string, route: string}>
     */
    public static function menuHubItems(): array
    {
        $hubIds = [
            'intro_numismatica',
            'investment',
            'bibliography',
            'faq',
            'conservation',
            'rome_in_coins',
            'veii',
            'international_overview',
            'birth_of_medal',
        ];

        $items = [];
        $byId = self::articlesById();

        foreach ($hubIds as $id) {
            if (! isset($byId[$id])) {
                continue;
            }

            $article = $byId[$id];
            $items[] = [
                'key' => $id,
                'route' => $article['redirect_route'] ?? $article['route'],
            ];
        }

        return $items;
    }

    /**
     * @return list<string>
     */
    public static function sectionKeys(): array
    {
        return array_keys(self::config()['sections'] ?? []);
    }
}
