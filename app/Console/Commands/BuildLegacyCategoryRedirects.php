<?php

namespace App\Console\Commands;

use App\Support\LegacyCategoryRedirectResolver;
use Illuminate\Console\Command;

class BuildLegacyCategoryRedirects extends Command
{
    protected $signature = 'legacy:build-category-redirects';

    protected $description = 'Genera config/legacy_category_redirects.php dalla mappa CSV e dal catalogo categorie';

    public function handle(): int
    {
        $map = LegacyCategoryRedirectResolver::buildRedirectMap();
        $pathCount = 0;

        foreach ($map as $entry) {
            $pathCount += count($entry['paths'] ?? []);
        }

        $export = "<?php\n\n/**\n * Redirect 301 categorie legacy (.html) generati automaticamente.\n * Rigenerare con: php artisan legacy:build-category-redirects\n */\nreturn [\n    'files' => ".var_export($map, true).",\n];\n";

        file_put_contents(config_path('legacy_category_redirects.php'), $export);

        $this->info('Scritti '.count($map).' file legacy ('.$pathCount.' path per lingua) in config/legacy_category_redirects.php');

        return self::SUCCESS;
    }
}
