<?php

namespace App\Console\Commands;

use App\Services\ProductCertificateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportProductCertificates extends Command
{
    protected $signature = 'certificates:import-legacy
                            {--archive : Sposta gli HTML importati in public/h/_legacy/}';

    protected $description = 'Importa i certificati legacy da public/h/*.html nel database';

    public function handle(ProductCertificateService $service): int
    {
        $storagePath = config('product_certificates.storage_path');
        $files = glob($storagePath.'/*.html') ?: [];

        if ($files === []) {
            $this->warn('Nessun file HTML trovato in '.$storagePath);

            return self::SUCCESS;
        }

        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($files as $path) {
            $filename = basename($path);

            try {
                $certificate = $service->importFromLegacyHtml($path);

                if ($certificate === null) {
                    $skipped++;
                    $this->line("  saltato: {$filename}");
                    continue;
                }

                $imported++;
                $this->info("  importato: {$filename} → prodotto {$certificate->product_id} ({$certificate->access_code})");

                if ($this->option('archive')) {
                    $legacyDir = $storagePath.'/_legacy';
                    File::ensureDirectoryExists($legacyDir);
                    File::move($path, $legacyDir.'/'.$filename);
                }
            } catch (\Throwable $e) {
                $errors[] = "{$filename}: {$e->getMessage()}";
            }
        }

        $this->newLine();
        $this->line("Importati: {$imported}");
        $this->line("Saltati: {$skipped}");

        if ($errors !== []) {
            $this->warn('Errori: '.count($errors));
            foreach ($errors as $error) {
                $this->line("  - {$error}");
            }

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
