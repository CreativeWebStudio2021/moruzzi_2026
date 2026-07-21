<?php

namespace App\Support;

class LegacyEditorialRedirectResolver
{
    /**
     * Redirect soft per pagine editoriali legacy non mappate altrove.
     *
     * @return list<array{pattern: string, path: string}>
     */
    private const IT_PATH_PATTERNS = [
        '/^monete[-_]/i' => 'monete.html',
        '/^(denari|aurei|antoniniani|sesterzi|solidi|silique|quinari|dupondi|argentei|assi|follis|cistofori|medaglie[-_])/i' => 'monete.html',
        '/^le_monete_dei_papi/i' => 'medaglie/medaglie-papali.html',
        '/^banconote[-_]/i' => 'banconote.html',
    ];

    /** @var list<string> */
    private const SKIP_BASENAMES = [
        'index',
        'home',
        'home1',
        'download',
        'credits',
        'links',
    ];

    public static function resolve(string $filename, string $locale): ?string
    {
        $key = strtolower($filename);
        $files = config('legacy_editorial_redirects.files', []);

        if (isset($files[$key])) {
            return self::pathFromRule($files[$key], $locale);
        }

        if ($locale !== 'it') {
            return null;
        }

        $base = strtolower(pathinfo($key, PATHINFO_FILENAME));

        if ($base === '' || in_array($base, self::SKIP_BASENAMES, true)) {
            return null;
        }

        foreach (self::IT_PATH_PATTERNS as $pattern => $path) {
            if (preg_match($pattern, $base)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $rule
     */
    private static function pathFromRule(array $rule, string $locale): ?string
    {
        if (isset($rule['paths'][$locale])) {
            return ltrim((string) $rule['paths'][$locale], '/');
        }

        if (isset($rule['path'])) {
            return ltrim((string) $rule['path'], '/');
        }

        if (isset($rule['route'])) {
            $slugs = config('localized_slugs', []);

            return ltrim((string) ($slugs[$rule['route']][$locale] ?? $slugs[$rule['route']]['it'] ?? ''), '/');
        }

        return null;
    }
}
