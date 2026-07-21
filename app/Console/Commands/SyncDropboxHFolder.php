<?php

namespace App\Console\Commands;

use App\Services\DropboxHSyncRunner;
use Illuminate\Console\Command;

class SyncDropboxHFolder extends Command
{
    protected $signature = 'dropbox:sync-h
                            {--dry-run : Elenca i file mancanti senza scaricarli}';

    protected $description = 'Scarica da Dropbox i file .html/.jpg mancanti in public/h';

    public function handle(DropboxHSyncRunner $runner): int
    {
        $dryRun = (bool) $this->option('dry-run');

        try {
            $this->info($dryRun
                ? 'Analisi file mancanti su Dropbox…'
                : 'Sincronizzazione Dropbox → public/h…');

            $stats = $runner->run($dryRun);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->line("File elencati su Dropbox: {$stats['listed']}");
        $this->line('Già presenti / filtrati: '.$stats['skipped']);
        $this->line('Mancanti: '.$stats['missing']);

        if ($dryRun) {
            $this->comment('Dry-run: nessun file scaricato.');
        } else {
            $this->info("Scaricati: {$stats['downloaded']}");
        }

        if ($stats['errors'] !== []) {
            $this->warn('Errori: '.count($stats['errors']));
            foreach ($stats['errors'] as $error) {
                $this->line("  - {$error}");
            }

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
