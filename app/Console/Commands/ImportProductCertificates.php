<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductCertificate;
use App\Services\ProductCertificateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportProductCertificates extends Command
{
    protected $signature = 'certificates:import-legacy
                            {--archive : Sposta gli HTML migrati in public/h/_legacy/}
                            {--regenerate : Rigenera il PDF con il nuovo metodo}
                            {--dry-run : Solo conteggi, nessuna scrittura}
                            {--limit= : Limita il numero di certificati da elaborare}
                            {--skip-existing : Salta prodotti che hanno già un PDF generato}';

    protected $description = 'Importa i certificati legacy da public/h/*.html, opzionalmente archivia e rigenera i PDF';

    public function handle(ProductCertificateService $service): int
    {
        $storagePath = config('product_certificates.storage_path');
        $files = glob($storagePath.'/*.html') ?: [];
        $files = array_values(array_filter($files, static fn (string $path): bool => is_file($path)));

        if ($files === []) {
            $this->warn('Nessun file HTML trovato in '.$storagePath);

            return self::SUCCESS;
        }

        $dryRun = (bool) $this->option('dry-run');
        $archive = (bool) $this->option('archive');
        $regenerate = (bool) $this->option('regenerate');
        $skipExisting = (bool) $this->option('skip-existing');
        $limit = $this->option('limit') !== null && $this->option('limit') !== ''
            ? max(0, (int) $this->option('limit'))
            : null;

        $this->info(sprintf(
            'Trovati %d HTML in %s%s%s%s%s',
            count($files),
            $storagePath,
            $dryRun ? ' [dry-run]' : '',
            $archive ? ' [archive]' : '',
            $regenerate ? ' [regenerate]' : '',
            $skipExisting ? ' [skip-existing]' : '',
        ));

        $parsed = [];
        $skippedNoBody = 0;
        $skippedNoSku = 0;

        foreach ($files as $path) {
            $filename = basename($path);
            $html = file_get_contents($path);
            if ($html === false) {
                continue;
            }

            if (! preg_match('/imTextObject_22.*?<p[^>]*>(.*?)<\/p>/s', $html, $bodyMatch)) {
                $skippedNoBody++;
                continue;
            }

            $plain = html_entity_decode(strip_tags($bodyMatch[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $plain = preg_replace('/\s+/u', ' ', trim($plain)) ?? '';

            if (! preg_match('/codice (\d+)/', $plain, $skuMatch)) {
                $skippedNoSku++;
                continue;
            }

            $sku = $skuMatch[1];
            preg_match("/src='([^']+\\.jpg)'/i", $html, $imgMatch);
            preg_match('/iscritta al n\. (\d+) del Registro/i', $plain, $regMatch);

            $parsed[] = [
                'path' => $path,
                'filename' => $filename,
                'access_code' => strtoupper(pathinfo($filename, PATHINFO_FILENAME)),
                'sku' => $sku,
                'plain' => $plain,
                'image_filename' => isset($imgMatch[1]) ? basename($imgMatch[1]) : $sku.'.jpg',
                'registry_number' => isset($regMatch[1]) ? (int) $regMatch[1] : 0,
            ];
        }

        $skus = array_values(array_unique(array_column($parsed, 'sku')));
        $productsBySku = Product::query()
            ->whereIn('sku', $skus)
            ->get(['entity_id', 'sku', 'name'])
            ->keyBy(static fn (Product $p): string => (string) $p->sku);

        $existingByProductId = ProductCertificate::query()
            ->whereIn('product_id', $productsBySku->pluck('entity_id')->all())
            ->get()
            ->keyBy('product_id');

        // Raggruppa per SKU: in caso di duplicati preferisci codice tipo A12345.
        $bySku = [];
        foreach ($parsed as $item) {
            $bySku[$item['sku']][] = $item;
        }

        $candidates = [];
        $duplicates = 0;
        foreach ($bySku as $sku => $items) {
            usort($items, static function (array $a, array $b): int {
                $score = static fn (array $x): int => preg_match('/^[A-Z][0-9]{4,8}$/', $x['access_code']) ? 0 : 1;

                return $score($a) <=> $score($b) ?: strcmp($a['filename'], $b['filename']);
            });

            $winner = $items[0];
            $winner['losers'] = array_slice($items, 1);
            $duplicates += count($winner['losers']);
            $candidates[] = $winner;
        }

        $imported = 0;
        $regenerated = 0;
        $archived = 0;
        $skippedNoProduct = 0;
        $skippedExisting = 0;
        $errors = [];
        $processed = 0;

        foreach ($candidates as $item) {
            if ($limit !== null && $processed >= $limit) {
                break;
            }

            $product = $productsBySku->get($item['sku']);
            if (! $product) {
                $skippedNoProduct++;
                continue;
            }

            $existing = $existingByProductId->get($product->entity_id);
            if ($skipExisting && $existing && $existing->pdf_filename) {
                $skippedExisting++;
                continue;
            }

            $processed++;

            if ($dryRun) {
                $imported++;
                if ($regenerate) {
                    $regenerated++;
                }
                if ($archive) {
                    $archived++;
                }
                continue;
            }

            try {
                $certificate = $service->importFromLegacyHtml($item['path']);
                if ($certificate === null) {
                    $skippedNoProduct++;
                    continue;
                }

                $imported++;
                $existingByProductId->put($product->entity_id, $certificate);

                if ($regenerate) {
                    $certificate = $service->regeneratePdf($certificate);
                    $regenerated++;
                }

                if ($archive) {
                    $legacyDir = $storagePath.'/_legacy';
                    File::ensureDirectoryExists($legacyDir);
                    $dest = $legacyDir.'/'.$item['filename'];
                    if (is_file($dest)) {
                        @unlink($dest);
                    }
                    File::move($item['path'], $dest);
                    $archived++;

                    foreach ($item['losers'] as $loser) {
                        $loserDest = $legacyDir.'/'.$loser['filename'];
                        if (is_file($loser['path'])) {
                            if (is_file($loserDest)) {
                                @unlink($loserDest);
                            }
                            File::move($loser['path'], $loserDest);
                            $this->writeRedirectStub(
                                $storagePath.'/'.$loser['filename'],
                                $certificate->access_code
                            );
                        }
                    }
                }

                if ($processed % 100 === 0) {
                    $this->line(sprintf(
                        '  … %d elaborati (importati=%d, pdf=%d, errori=%d)',
                        $processed,
                        $imported,
                        $regenerated,
                        count($errors)
                    ));
                }
            } catch (\Throwable $e) {
                $errors[] = $item['filename'].': '.$e->getMessage();
                $this->error('  errore: '.$item['filename'].' — '.$e->getMessage());
            }
        }

        $this->newLine();
        $this->table(
            ['Voce', 'Valore'],
            [
                ['HTML totali', count($files)],
                ['Pattern certificato', count($parsed)],
                ['SKU unici con pattern', count($bySku)],
                ['Duplicati (file extra)', $duplicates],
                ['Senza corpo testo', $skippedNoBody],
                ['Senza codice SKU', $skippedNoSku],
                ['Prodotto assente in DB', $skippedNoProduct],
                ['Già con PDF (skip)', $skippedExisting],
                ['Elaborati', $processed],
                ['Importati', $imported],
                ['PDF rigenerati', $regenerated],
                ['HTML archiviati', $archived],
                ['Errori', count($errors)],
            ]
        );

        if ($errors !== []) {
            $this->warn('Primi errori:');
            foreach (array_slice($errors, 0, 20) as $error) {
                $this->line('  - '.$error);
            }

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function writeRedirectStub(string $path, string $accessCode): void
    {
        $url = '/h/'.rawurlencode($accessCode).'.html';
        $html = '<!DOCTYPE html><html lang="it"><head><meta charset="utf-8">'
            .'<meta http-equiv="refresh" content="0;url='.$url.'">'
            .'<link rel="canonical" href="'.$url.'">'
            .'<title>Certificato</title></head><body>'
            .'<p><a href="'.$url.'">Vai al certificato</a></p>'
            .'</body></html>';
        file_put_contents($path, $html);
    }
}
