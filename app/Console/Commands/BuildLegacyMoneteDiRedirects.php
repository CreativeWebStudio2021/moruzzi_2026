<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BuildLegacyMoneteDiRedirects extends Command
{
    protected $signature = 'legacy:build-monete-di-redirects';

    protected $description = 'Genera config redirect monete-di-*.html e pagine editoriali multilingua da link shop nel legacy';

    public function handle(): int
    {
        $moneteDi = $this->extractMoneteDiMap();
        $langEditorial = $this->extractLangEditorialMap();

        $this->writeConfig('legacy_monete_di_redirects.php', $moneteDi, 'Redirect monete-di-*.html estratti dai link shop nel sito legacy.');
        $this->writeConfig('legacy_lang_editorial_redirects.php', $langEditorial, 'Redirect pagine editoriali multilingua (cartelle lang*) da link shop nel legacy.');

        $this->info('monete-di: '.count($moneteDi).' file');
        $this->info('lang editoriali: '.count($langEditorial).' file');

        return self::SUCCESS;
    }

    /**
     * @return array<string, string>
     */
    private function extractMoneteDiMap(): array
    {
        $map = [];

        foreach (glob(public_path('old/monete-di-*.html')) ?: [] as $file) {
            $target = $this->bestShopCategoryLink($file, deepest: true);
            if ($target !== null) {
                $map[strtolower(basename($file))] = $target;
            }
        }

        ksort($map);

        return $map;
    }

    /**
     * @return array<string, array{paths: array<string, string>}>
     */
    private function extractLangEditorialMap(): array
    {
        $map = [];
        $folders = [
            'lang1' => 'fr',
            'lang2' => 'en',
            'lang3' => 'es',
            'lang5' => 'de',
            'lang4' => 'en',
            'lang6' => 'en',
        ];

        foreach ($folders as $subdir => $locale) {
            $directory = public_path('old/'.$subdir);
            if (! is_dir($directory)) {
                continue;
            }

            foreach (glob($directory.'/*.html') ?: [] as $file) {
                $target = $this->bestShopCategoryLink($file, deepest: false);
                if ($target === null) {
                    continue;
                }

                $key = strtolower(basename($file));
                $map[$key]['paths'][$locale] = $target;
            }
        }

        ksort($map);

        return $map;
    }

    private function bestShopCategoryLink(string $file, bool $deepest = true): ?string
    {
        $html = file_get_contents($file);
        if ($html === false || ! preg_match_all(
            '#https?://shop\.moruzzi\.it/(?:it|en|fr|de|es)/([^"\']+\.html)#i',
            $html,
            $matches
        )) {
            return null;
        }

        $candidates = [];

        foreach (array_unique($matches[1]) as $link) {
            if (! preg_match('#^(monete|coins|monedas|monnaies|munzen)/#i', $link)) {
                continue;
            }

            if (preg_match('/-\d+\.html$/', $link)) {
                continue;
            }

            $candidates[] = $link;
        }

        if ($candidates === []) {
            return null;
        }

        if ($deepest) {
            usort($candidates, fn (string $a, string $b): int => strlen($b) <=> strlen($a));
            $longest = $candidates[0];
            $parent = dirname(str_replace('\\', '/', $longest)).'.html';
            if (in_array($parent, $candidates, true)) {
                return $parent;
            }

            return $longest;
        }

        usort($candidates, function (string $a, string $b): int {
            $depthCompare = substr_count($a, '/') <=> substr_count($b, '/');
            if ($depthCompare !== 0) {
                return $depthCompare;
            }

            return strlen($a) <=> strlen($b);
        });

        return $candidates[0];
    }

    /**
     * @param  array<string, string>|array<string, array{paths: array<string, string>}>  $data
     */
    private function writeConfig(string $filename, array $data, string $comment): void
    {
        $export = var_export($data, true);
        $contents = <<<PHP
<?php

/**
 * {$comment}
 * Rigenerare con: php artisan legacy:build-monete-di-redirects
 */
return [
    'files' => {$export},
];

PHP;

        file_put_contents(config_path($filename), $contents);
    }
}
