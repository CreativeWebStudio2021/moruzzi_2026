<?php

namespace App\Support;

use App\Models\Category;

class LegacyCategoryRedirectResolver
{
    /** @var array<string, array<string, string>>|null */
    private static ?array $categoryByLink = null;

    /** @var array<string, array<string, string>> */
    private const STATIC_IT_OVERRIDES = [
        'monete' => 'monete.html',
        'medaglie' => 'medaglie.html',
        'offerte_speciali' => 'offerte-speciali.html',
        'francobolli' => 'francobolli.html',
        'banconote_e_cartamoneta_italiana' => 'banconote.html',
        'le_medaglie' => 'medaglie.html',
        'le_medaglie_papali' => 'medaglie/medaglie-papali.html',
        'monete_romane' => 'monete.html',
        'monete_romane_imperiali' => 'monete/monete-dellimpero-romano.html',
        'monete_romane_repubblicane' => 'monete/monete-romane-repubblicane.html',
        'monete_romane_provinciali' => 'monete/monete-romane-provinciali.html',
        'monete_greche' => 'monete/monete-greche.html',
        'monete_bizantine' => 'monete/monete-bizantine.html',
        'monete_italiane' => 'monete/monete-italiane.html',
        'monete_moderne' => 'monete/monete-moderne.html',
        'monete_medievali' => 'monete/monete-medievali.html',
    ];

    private const SKIP_REGEX = '/^(italiano|english|deutsch|francais|espanol|errore_|grazie_|newsletter|facebook_|moruzzi_numismatica_|nouvelle_|premiere_|I[0-9]+|credits|links|google_maps|download|rss_feed_news|imcart|imform|imlist|impayment|imreport)$/i';

    /**
     * @return array<string, array<string, string>>
     */
    public static function categoryIndex(): array
    {
        if (self::$categoryByLink !== null) {
            return self::$categoryByLink;
        }

        self::$categoryByLink = [];

        foreach (Category::query()->get(['link_it', 'link_en', 'link_fr', 'link_de', 'link_es']) as $category) {
            foreach (['it', 'en', 'fr', 'de', 'es'] as $locale) {
                $column = 'link_'.$locale;
                $link = $category->{$column} ?? null;
                if ($link === null || $link === '') {
                    continue;
                }

                $lower = strtolower($link);
                self::$categoryByLink[$locale][$lower] = $link;
                self::$categoryByLink[$locale][strtolower(basename($link))] = $link;
            }
        }

        return self::$categoryByLink;
    }

    public static function resolve(string $filename, string $locale): ?string
    {
        $base = strtolower(pathinfo($filename, PATHINFO_FILENAME));
        if ($base === '' || preg_match(self::SKIP_REGEX, $base)) {
            return null;
        }

        if ($locale === 'it' && isset(self::STATIC_IT_OVERRIDES[$base])) {
            return self::STATIC_IT_OVERRIDES[$base];
        }

        $normalizedBase = str_replace('-', '_', $base);
        if ($locale === 'it' && isset(self::STATIC_IT_OVERRIDES[$normalizedBase])) {
            return self::STATIC_IT_OVERRIDES[$normalizedBase];
        }

        $static = self::resolveFromStaticMaps(strtolower($filename), $locale);
        if ($static !== null) {
            return $static;
        }

        $fromIndex = self::resolveFromCategoryIndex($base, $locale);
        if ($fromIndex !== null) {
            return $fromIndex;
        }

        return self::resolveMoneteDiEmperor($base, $locale);
    }

    private static function resolveFromStaticMaps(string $filename, string $locale): ?string
    {
        $langEditorial = config('legacy_lang_editorial_redirects.files', []);
        if (isset($langEditorial[$filename]['paths'][$locale])) {
            return self::normalizeCategoryPath((string) $langEditorial[$filename]['paths'][$locale], $locale);
        }

        $moneteDi = config('legacy_monete_di_redirects.files', []);
        if (isset($moneteDi[$filename])) {
            return self::translateItalianCategoryPath((string) $moneteDi[$filename], $locale);
        }

        return null;
    }

    public static function translateItalianCategoryPath(string $italianPath, string $locale): string
    {
        if ($locale === 'it') {
            return self::normalizeCategoryPath($italianPath, 'it');
        }

        if (! str_starts_with(strtolower($italianPath), 'monete/')) {
            return self::normalizeCategoryPath($italianPath, $locale);
        }

        $category = resolve_category_by_link($italianPath, 'it');
        if ($category === null) {
            return self::normalizeCategoryPath($italianPath, $locale);
        }

        $localized = $category->{'link_'.$locale} ?? null;
        if ($localized === null || $localized === '') {
            return self::normalizeCategoryPath($italianPath, 'it');
        }

        return self::normalizeCategoryPath($localized, $locale);
    }

    private static function normalizeCategoryPath(string $path, string $locale): string
    {
        $path = ltrim($path, '/');
        $categoryIndex = self::categoryIndex();
        $lower = strtolower($path);

        if (isset($categoryIndex[$locale][$lower])) {
            return $categoryIndex[$locale][$lower];
        }

        foreach (category_link_alternates($path) as $alternate) {
            $altLower = strtolower($alternate);
            if (isset($categoryIndex[$locale][$altLower])) {
                return $categoryIndex[$locale][$altLower];
            }
        }

        return $path;
    }

    /**
     * Pagine editoriali "monete-di-{imperatore}" → sottocategoria catalogo più specifica.
     */
    private static function resolveMoneteDiEmperor(string $base, string $locale): ?string
    {
        if (! preg_match('/^monete[-_]di[-_](.+)$/i', $base, $matches)) {
            return null;
        }

        $slug = strtolower($matches[1]);
        $categoryIndex = self::categoryIndex()[$locale] ?? [];
        $candidates = [];

        foreach ($categoryIndex as $link => $full) {
            if (preg_match('/(?:^|[\/_-])'.preg_quote($slug, '/').'(?:[\/_.-]|\.html)/i', $link)) {
                $candidates[$link] = $full;
            }
        }

        if ($candidates === []) {
            return null;
        }

        uksort($candidates, fn (string $a, string $b): int => strlen($b) <=> strlen($a));

        return array_values($candidates)[0];
    }

    public static function pathExists(string $path, string $locale): bool
    {
        return isset(self::categoryIndex()[$locale][strtolower($path)]);
    }

    public static function normalizePathForLocale(string $path, string $locale): string
    {
        $path = ltrim($path, '/');
        if (preg_match('#^(it|en|fr|de|es)/(.+)$#', $path, $matches) && $matches[1] === $locale) {
            return $matches[2];
        }

        return $path;
    }

    /**
     * @return array<string, array{paths: array<string, string>}>
     */
    public static function buildRedirectMap(): array
    {
        $map = [];
        $categoryIndex = self::categoryIndex();

        self::applyCsvMappings($map, $categoryIndex);
        self::applyLegacyHtmlScan($map, $categoryIndex);

        ksort($map);

        return $map;
    }

    /**
     * @param  array<string, array{paths: array<string, string>}>  $map
     * @param  array<string, array<string, string>>  $categoryIndex
     */
    private static function applyCsvMappings(array &$map, array $categoryIndex): void
    {
        $csvPath = storage_path('app/legacy-url-mapping.csv');
        if (! is_readable($csvPath)) {
            return;
        }

        $handle = fopen($csvPath, 'r');
        if ($handle === false) {
            return;
        }

        fgetcsv($handle, 0, ';');

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (count($row) < 6) {
                continue;
            }

            [$oldUrl, $oldLang, $newUrl, $status, $type] = $row;
            if ($status !== 'mapped' || ! str_ends_with((string) $newUrl, '.html')) {
                continue;
            }

            $locale = in_array($oldLang, ['it', 'en', 'fr', 'de', 'es'], true) ? $oldLang : 'it';
            $filename = strtolower(basename(str_replace('"', '', (string) $oldUrl)));
            $path = self::normalizePathForLocale((string) $newUrl, $locale);

            if (! isset($categoryIndex[$locale][strtolower($path)])) {
                continue;
            }

            $canonical = $categoryIndex[$locale][strtolower($path)];
            self::setPath($map, $filename, $locale, $canonical);
        }

        fclose($handle);
    }

    /**
     * @param  array<string, array{paths: array<string, string>}>  $map
     * @param  array<string, array<string, string>>  $categoryIndex
     */
    private static function applyLegacyHtmlScan(array &$map, array $categoryIndex): void
    {
        $oldRoot = public_path('old');
        $langFolders = [
            'it' => '',
            'fr' => 'lang1',
            'en' => 'lang2',
            'es' => 'lang3',
            'de' => 'lang5',
        ];

        foreach ($langFolders as $locale => $subdir) {
            $directory = $subdir === '' ? $oldRoot : $oldRoot.'/'.$subdir;
            if (! is_dir($directory)) {
                continue;
            }

            foreach (glob($directory.'/*.html') ?: [] as $file) {
                $filename = strtolower(basename($file));
                $path = self::resolve($filename, $locale);
                if ($path === null) {
                    continue;
                }

                self::setPath($map, $filename, $locale, $path);
            }
        }

        foreach (['lang4', 'lang6'] as $extraEnFolder) {
            $directory = $oldRoot.'/'.$extraEnFolder;
            if (! is_dir($directory)) {
                continue;
            }

            foreach (glob($directory.'/*.html') ?: [] as $file) {
                $filename = strtolower(basename($file));
                $path = self::resolve($filename, 'en');
                if ($path === null) {
                    continue;
                }

                self::setPath($map, $filename, 'en', $path);
            }
        }
    }

    /**
     * @param  array<string, array{paths: array<string, string>}>  $map
     */
    private static function setPath(array &$map, string $filename, string $locale, string $path): void
    {
        $map[$filename]['paths'][$locale] = $path;
    }

    private static function resolveFromCategoryIndex(string $base, string $locale): ?string
    {
        $categoryIndex = self::categoryIndex();

        foreach (self::normalizeKeys($base) as $key) {
            $candidate = strtolower($key.'.html');
            if (isset($categoryIndex[$locale][$candidate])) {
                return $categoryIndex[$locale][$candidate];
            }
        }

        foreach (self::normalizeKeys($base) as $key) {
            $kebab = str_replace('_', '-', $key);
            $suffix = '/'.strtolower($kebab.'.html');
            foreach ($categoryIndex[$locale] as $link => $full) {
                if (str_ends_with($link, $suffix) || $link === strtolower($kebab.'.html')) {
                    return $full;
                }
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private static function normalizeKeys(string $base): array
    {
        return array_values(array_unique([
            $base,
            str_replace('-', '_', $base),
            str_replace('_', '-', $base),
        ]));
    }
}
