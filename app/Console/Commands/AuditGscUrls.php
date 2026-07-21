<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AuditGscUrls extends Command
{
    protected $signature = 'legacy:audit-gsc
                            {--csv=public/csv/Pagine.csv : Percorso CSV Search Console (Pagine)}
                            {--output=storage/app/gsc-url-audit.csv : File report in uscita}
                            {--limit=0 : Limita URL da testare (0 = tutti)}
                            {--min-impressions=0 : Salta URL sotto soglia impressioni}';

    protected $description = 'Analizza export GSC: verifica HTTP live e gap redirect rispetto alla mappa legacy';

    public function handle(): int
    {
        $csvPath = base_path($this->option('csv'));

        if (! is_file($csvPath)) {
            $this->error("File non trovato: {$csvPath}");

            return self::FAILURE;
        }

        $legacyMap = $this->loadLegacyMap();
        $rows = $this->parseGscCsv($csvPath);

        if ($rows === []) {
            $this->error('Nessuna URL trovata nel CSV.');

            return self::FAILURE;
        }

        $minImpressions = (int) $this->option('min-impressions');
        if ($minImpressions > 0) {
            $rows = array_values(array_filter($rows, fn (array $r) => $r['impressions'] >= $minImpressions));
        }

        $limit = (int) $this->option('limit');
        if ($limit > 0) {
            $rows = array_slice($rows, 0, $limit);
        }

        $this->info('URL da verificare: '.count($rows));

        $bar = $this->output->createProgressBar(count($rows));
        $bar->start();

        $results = [];
        $chunks = array_chunk($rows, 20);

        foreach ($chunks as $chunk) {
            $responses = Http::pool(function ($pool) use ($chunk) {
                foreach ($chunk as $row) {
                    $pool->as($row['url'])
                        ->withOptions(['allow_redirects' => false])
                        ->timeout(15)
                        ->head($row['url']);
                }
            });

            foreach ($chunk as $row) {
                $url = $row['url'];
                $response = $responses[$url] ?? null;
                $status = $this->responseStatus($response);
                $location = $this->responseLocation($response);

                if ($status === 405 || $status === 0) {
                    $getResponse = Http::withOptions(['allow_redirects' => false])
                        ->timeout(15)
                        ->get($url);
                    $status = $getResponse->status();
                    $location = $getResponse->header('Location') ?? '';
                }

                $path = parse_url($url, PHP_URL_PATH) ?: '/';
                $legacy = $legacyMap[$path] ?? $legacyMap[strtolower($path)] ?? null;

                $results[] = [
                    'url' => $url,
                    'path' => $path,
                    'clicks' => $row['clicks'],
                    'impressions' => $row['impressions'],
                    'ctr' => $row['ctr'],
                    'position' => $row['position'],
                    'http_status' => $status,
                    'location' => $location,
                    'legacy_status' => $legacy['status'] ?? '',
                    'legacy_target' => $legacy['new_url'] ?? '',
                    'legacy_note' => $legacy['note'] ?? '',
                    'action' => $this->suggestAction($status, $location, $legacy),
                ];

                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);

        usort($results, function (array $a, array $b) {
            return [$b['clicks'], $b['impressions']] <=> [$a['clicks'], $a['impressions']];
        });

        $outputPath = base_path($this->option('output'));
        $this->writeReport($outputPath, $results);

        $this->printSummary($results);
        $this->info("Report scritto in: {$outputPath}");

        return self::SUCCESS;
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function loadLegacyMap(): array
    {
        $jsonPath = storage_path('app/legacy-url-mapping.json');

        if (! is_file($jsonPath)) {
            $this->warn('legacy-url-mapping.json non trovato — esegui php storage/app/legacy-url-analysis.php');

            return [];
        }

        $data = json_decode((string) file_get_contents($jsonPath), true);
        $map = [];

        foreach ($data['rows'] ?? [] as $row) {
            $path = $row['old_url'] ?? '';
            if ($path !== '') {
                $map[$path] = $row;
                $map[strtolower($path)] = $row;
            }
        }

        return $map;
    }

    /**
     * @return list<array{url: string, clicks: int, impressions: int, ctr: string, position: float}>
     */
    private function parseGscCsv(string $csvPath): array
    {
        $handle = fopen($csvPath, 'r');
        if ($handle === false) {
            return [];
        }

        $header = fgetcsv($handle);
        $rows = [];

        while (($line = fgetcsv($handle)) !== false) {
            if (count($line) < 2 || empty($line[0])) {
                continue;
            }

            $url = trim($line[0]);
            if (! str_starts_with($url, 'http')) {
                continue;
            }

            $rows[] = [
                'url' => $url,
                'clicks' => (int) ($line[1] ?? 0),
                'impressions' => (int) ($line[2] ?? 0),
                'ctr' => (string) ($line[3] ?? ''),
                'position' => (float) str_replace(',', '.', (string) ($line[4] ?? 0)),
            ];
        }

        fclose($handle);

        return $rows;
    }

    private function responseStatus(mixed $response): int
    {
        if ($response instanceof \Throwable) {
            return 0;
        }

        return $response->status();
    }

    private function responseLocation(mixed $response): string
    {
        if ($response instanceof \Throwable) {
            return '';
        }

        return (string) ($response->header('Location') ?? '');
    }

    /**
     * @param  array<string, string>|null  $legacy
     */
    private function suggestAction(int $status, string $location, ?array $legacy): string
    {
        if ($status >= 300 && $status < 400 && $location !== '') {
            return 'ok_redirect';
        }

        if ($status >= 200 && $status < 300) {
            return 'review_200';
        }

        if ($status === 404 && $legacy && ($legacy['new_url'] ?? '') !== '') {
            return 'add_301';
        }

        if ($status === 404) {
            return 'needs_redirect';
        }

        return 'review';
    }

    /**
     * @param  list<array<string, mixed>>  $results
     */
    private function writeReport(string $path, array $results): void
    {
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $fp = fopen($path, 'w');
        fputcsv($fp, [
            'url', 'path', 'clicks', 'impressions', 'ctr', 'position',
            'http_status', 'location', 'legacy_status', 'legacy_target', 'legacy_note', 'action',
        ], ';');

        foreach ($results as $row) {
            fputcsv($fp, [
                $row['url'],
                $row['path'],
                $row['clicks'],
                $row['impressions'],
                $row['ctr'],
                $row['position'],
                $row['http_status'],
                $row['location'],
                $row['legacy_status'],
                $row['legacy_target'],
                $row['legacy_note'],
                $row['action'],
            ], ';');
        }

        fclose($fp);
    }

    /**
     * @param  list<array<string, mixed>>  $results
     */
    private function printSummary(array $results): void
    {
        $counts = [];
        foreach ($results as $row) {
            $counts[$row['action']] = ($counts[$row['action']] ?? 0) + 1;
        }

        $this->table(['Azione', 'URL'], collect($counts)->map(fn ($n, $k) => [$k, $n])->values()->all());

        $priority = array_values(array_filter(
            $results,
            fn (array $r) => in_array($r['action'], ['needs_redirect', 'add_301', 'review_200'], true)
                && ($r['clicks'] > 0 || $r['impressions'] >= 10)
        ));

        if ($priority !== []) {
            $this->newLine();
            $this->info('Top priorità (traffico + problema):');
            $this->table(
                ['Clic', 'Impr.', 'Status', 'Azione', 'URL'],
                array_map(fn (array $r) => [
                    $r['clicks'],
                    $r['impressions'],
                    $r['http_status'],
                    $r['action'],
                    $r['path'],
                ], array_slice($priority, 0, 25))
            );
        }
    }
}
