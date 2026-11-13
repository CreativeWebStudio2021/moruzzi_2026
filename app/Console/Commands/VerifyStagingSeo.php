<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ProductAvailabilityService;
use App\Services\SitemapService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class VerifyStagingSeo extends Command
{
    protected $signature = 'seo:verify-staging
                            {--host= : Host da verificare (default staging.moruzzi.it)}
                            {--base= : Base URL completa (override host)}
                            {--resolve-ip=127.0.0.1 : IP origin per bypass Cloudflare (CURLOPT_RESOLVE)}
                            {--insecure : Ignora verifica TLS}
                            {--sample=50 : URL indicizzabili da controllare}
                            {--sold=10 : URL venduti (410) da controllare}
                            {--report=seo-audit/verify-staging-report.md : Report markdown}';

    protected $description = 'Verifica canonical/hreflang/robots/sitemap su un campione di URL (staging)';

    public function handle(ProductAvailabilityService $availability, SitemapService $sitemap): int
    {
        $host = (string) ($this->option('host') ?: 'staging.moruzzi.it');
        $base = rtrim((string) ($this->option('base') ?: ('https://'.$host)), '/');
        $insecure = (bool) $this->option('insecure');
        $resolveIp = trim((string) $this->option('resolve-ip'));
        $sampleN = max(1, (int) $this->option('sample'));
        $soldN = max(1, (int) $this->option('sold'));
        $reportPath = base_path((string) $this->option('report'));

        $user = (string) env('STAGING_BASIC_AUTH_USER', '');
        $pass = (string) env('STAGING_BASIC_AUTH_PASSWORD', '');

        $hostForResolve = parse_url($base, PHP_URL_HOST) ?: $host;
        $curlOpts = [];
        if ($resolveIp !== '') {
            $curlOpts[CURLOPT_RESOLVE] = [$hostForResolve.':443:'.$resolveIp, $hostForResolve.':80:'.$resolveIp];
        }

        $client = Http::timeout(25)
            ->withOptions([
                'allow_redirects' => false,
                'verify' => ! $insecure,
                'curl' => $curlOpts,
            ]);
        if ($user !== '' && $pass !== '') {
            $client = $client->withBasicAuth($user, $pass);
        }

        $available = $availability->applyPublicAvailabilityConstraints(Product::query())
            ->orderByDesc('entity_id')
            ->limit($sampleN)
            ->get(['entity_id', 'name']);

        $sold = Product::query()
            ->where(function ($q) {
                $q->where('qty', '<=', 0)->orWhere('disponibili', '<=', 0);
            })
            ->whereIn('visibility', [1, 4])
            ->orderByDesc('entity_id')
            ->limit($soldN)
            ->get(['entity_id', 'name']);

        // Sitemap locs (IT) for membership check — first 8k entries cached in memory
        $this->info('Carico loc sitemap…');
        $sitemapLocs = [];
        foreach ($sitemap->xmlEntries() as $entry) {
            $sitemapLocs[$entry['loc']] = true;
            if (count($sitemapLocs) > 8000) {
                break;
            }
        }

        $rows = [];
        $issues = 0;

        foreach ($available as $product) {
            $canonicalProductUrl = product_url($product, 'it');
            $path = parse_url($canonicalProductUrl, PHP_URL_PATH) ?: '/';
            $url = $base.$path;
            $result = $this->checkUrl($client, $url, $base, expectStatus: 200, expectNoindex: false, followOnce: true);
            $finalUrl = $result['final_url'] ?: $url;
            $inSitemap = isset($sitemapLocs[$canonicalProductUrl]);
            if (! $inSitemap) {
                // Confronta anche il path finale (slug 301)
                $finalPath = parse_url($finalUrl, PHP_URL_PATH) ?: '';
                $inSitemap = false;
                foreach (array_keys($sitemapLocs) as $loc) {
                    if (parse_url($loc, PHP_URL_PATH) === $finalPath) {
                        $inSitemap = true;
                        break;
                    }
                }
            }
            if (! $inSitemap) {
                $result['issues'][] = 'assente_da_sitemap_generata';
            }
            if ($result['issues'] !== []) {
                $issues++;
            }
            $rows[] = array_merge(['kind' => 'available', 'url' => $finalUrl, 'in_sitemap' => $inSitemap ? 'yes' : 'no'], $result);
        }

        // Query noindex smoke
        $qUrl = $base.'/catalogo?q=test-seo';
        $qRes = $this->checkUrl($client, $qUrl, $base, expectStatus: 200, expectNoindex: true);
        if ($qRes['issues'] !== []) {
            $issues++;
        }
        $rows[] = array_merge(['kind' => 'query_noindex', 'url' => $qUrl, 'in_sitemap' => 'n/a'], $qRes);

        foreach ($sold as $product) {
            $path = parse_url(product_url($product, 'it'), PHP_URL_PATH) ?: '/';
            $url = $base.$path;
            $result = $this->checkUrl($client, $url, $base, expectStatus: 410, expectNoindex: true);
            $inSitemap = isset($sitemapLocs[product_url($product, 'it')]);
            if ($inSitemap) {
                $result['issues'][] = 'venduto_presente_in_sitemap';
            }
            if ($result['issues'] !== []) {
                $issues++;
            }
            $rows[] = array_merge(['kind' => 'sold', 'url' => $url, 'in_sitemap' => $inSitemap ? 'yes' : 'no'], $result);
        }

        $md = "# Verifica SEO staging\n\n";
        $md .= '- Base: `'.$base."`\n";
        $md .= '- Data: '.date('c')."\n";
        $md .= '- URL controllati: '.count($rows)."\n";
        $md .= '- Con problemi: '.$issues."\n\n";
        $md .= "| Kind | Status | Canonical | Hreflang | Robots | Sitemap | Issues | URL |\n";
        $md .= "|------|--------|-----------|----------|--------|---------|--------|-----|\n";
        foreach ($rows as $r) {
            $md .= '| '.$r['kind']
                .' | '.$r['status']
                .' | '.($r['canonical'] !== '' ? 'yes' : 'no')
                .' | '.$r['hreflang_count']
                .' | '.($r['robots'] ?: '-')
                .' | '.$r['in_sitemap']
                .' | '.(empty($r['issues']) ? 'ok' : implode(';', $r['issues']))
                .' | `'.$r['url']."` |\n";
        }

        $dir = dirname($reportPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($reportPath, $md);

        $this->info("Report: {$reportPath}");
        $this->info("Problemi: {$issues}");

        return $issues > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * @return array{status:int|string,canonical:string,hreflang_count:int,robots:string,final_url:string,issues:list<string>}
     */
    private function checkUrl($client, string $url, string $base, int $expectStatus, bool $expectNoindex, bool $followOnce = false): array
    {
        $issues = [];
        $finalUrl = $url;
        try {
            $response = $client->get($url);
            $status = $response->status();
            $body = $response->body();

            if ($followOnce && in_array($status, [301, 302, 303, 307, 308], true)) {
                $location = (string) $response->header('Location');
                if ($location !== '') {
                    if (str_starts_with($location, '/')) {
                        $location = $base.$location;
                    }
                    $finalUrl = $location;
                    $response = $client->get($location);
                    $status = $response->status();
                    $body = $response->body();
                }
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'err',
                'canonical' => '',
                'hreflang_count' => 0,
                'robots' => '',
                'final_url' => $url,
                'issues' => ['http_error:'.$e->getMessage()],
            ];
        }

        if ($status !== $expectStatus) {
            $issues[] = "status_{$status}_atteso_{$expectStatus}";
        }

        $canonical = '';
        if (preg_match('/rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']/i', $body, $m)
            || preg_match('/href=["\']([^"\']+)["\']\s+rel=["\']canonical["\']/i', $body, $m)) {
            $canonical = $m[1];
        }

        if ($expectStatus === 200 && $canonical === '') {
            $issues[] = 'canonical_assente';
        }
        if ($canonical !== '' && ! str_starts_with($canonical, 'https://')) {
            $issues[] = 'canonical_non_https';
        }
        if ($canonical !== '' && str_contains($canonical, '?') && ! preg_match('/[?&]page=\d+/', $canonical)) {
            // query non-page nel canonical tipicamente errata
            $issues[] = 'canonical_con_query';
        }

        preg_match_all('/rel=["\']alternate["\'][^>]*hreflang=["\']([^"\']+)["\']/i', $body, $hm);
        $hreflangCount = count($hm[1] ?? []);

        $robots = '';
        if (preg_match('/name=["\']robots["\']\s+content=["\']([^"\']+)["\']/i', $body, $rm)
            || preg_match('/content=["\']([^"\']+)["\']\s+name=["\']robots["\']/i', $body, $rm)) {
            $robots = strtolower($rm[1]);
        }

        if ($expectNoindex && ! str_contains($robots, 'noindex')) {
            $issues[] = 'manca_noindex';
        }

        return [
            'status' => $status,
            'canonical' => $canonical,
            'hreflang_count' => $hreflangCount,
            'robots' => $robots,
            'final_url' => $finalUrl,
            'issues' => $issues,
        ];
    }
}
