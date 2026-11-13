<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ProductAvailabilityService;
use App\Services\Seo\ProductDescriptionBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Genera file SQL di UPDATE description per lingua (NON esegue le query).
 */
class GenerateProductDescriptionSql extends Command
{
    /** @deprecated Disabilitato: non usare. I SQL generati sono stati rimossi. */
    protected $hidden = true;

    protected $signature = 'seo:generate-product-descriptions
                            {--limit=0 : Limita i prodotti (0 = tutti i disponibili)}
                            {--outdir=seo-audit/sql : Directory di output}';

    protected $description = 'Genera SQL UPDATE description_* da attributi DB (solo file, non esegue)';

    public function handle(ProductDescriptionBuilder $builder, ProductAvailabilityService $availability): int
    {
        $this->error('Generatore disabilitato per decisione editoriale. Non esegue nulla.');
        return self::FAILURE;
        // --- codice sotto lasciato come riferimento, non raggiungibile ---
        $outdir = base_path((string) $this->option('outdir'));
        if (! is_dir($outdir) && ! mkdir($outdir, 0755, true) && ! is_dir($outdir)) {
            $this->error("Impossibile creare {$outdir}");

            return self::FAILURE;
        }

        $limit = (int) $this->option('limit');
        $query = $availability->applyPublicAvailabilityConstraints(Product::query())
            ->orderBy('entity_id');
        if ($limit > 0) {
            $query->limit($limit);
        }

        $handles = [];
        foreach (['it', 'en', 'fr', 'de', 'es'] as $locale) {
            $path = $outdir.'/product-descriptions-'.$locale.'.sql';
            $fh = fopen($path, 'w');
            if ($fh === false) {
                $this->error("Impossibile scrivere {$path}");

                return self::FAILURE;
            }
            fwrite($fh, "-- Generated ".date('c')." by seo:generate-product-descriptions\n");
            fwrite($fh, "-- DO NOT RUN blindly: review first. Updates description only.\n");
            fwrite($fh, "-- Locale: {$locale}\n\n");
            $handles[$locale] = $fh;
        }

        $table = (new Product)->getTable();
        $prefix = (string) DB::getTablePrefix();
        $qualified = $prefix.$table;

        $processed = 0;
        $written = 0;
        $skipped = 0;

        $query->select(['entity_id', 'name', 'short_description', 'description'])
            ->chunkById(200, function ($products) use ($builder, $handles, $qualified, &$processed, &$written, &$skipped) {
                foreach ($products as $product) {
                    $processed++;
                    $texts = $builder->buildAllLocales($product);
                    if ($texts === []) {
                        $skipped++;
                        continue;
                    }

                    foreach ($texts as $locale => $html) {
                        $sqlHtml = DB::getPdo()->quote($html);
                        $column = $locale === 'it' ? 'description' : 'description';
                        // Una sola colonna description in DB: file per lingua con lo stesso campo,
                        // da applicare scegliendo il locale desiderato (revisione manuale).
                        fwrite(
                            $handles[$locale],
                            'UPDATE `'.$qualified.'` SET `'.$column.'` = '.$sqlHtml
                            .' WHERE `entity_id` = '.(int) $product->entity_id.";\n"
                        );
                    }
                    $written++;
                }
            }, 'entity_id');

        foreach ($handles as $fh) {
            fclose($fh);
        }

        $this->info("Prodotti analizzati: {$processed}");
        $this->info("Con testo generato: {$written}");
        $this->info("Saltati (dati insufficienti): {$skipped}");
        $this->info("Output: {$outdir}/product-descriptions-{it,en,fr,de,es}.sql");
        $this->warn('I file SQL non sono stati eseguiti.');

        return self::SUCCESS;
    }
}
