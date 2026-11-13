<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ProductAvailabilityService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class VerifyProductSchema extends Command
{
    protected $signature = 'seo:verify-product-schema
        {--base= : Base URL (default: SEO_VERIFY_BASE_URL o https://staging.moruzzi.it)}
        {--available=30 : Numero schede disponibili da testare}
        {--sold=30 : Numero URL venduti da testare}
        {--user= : Basic Auth user (default STAGING_BASIC_AUTH_USER)}
        {--password= : Basic Auth password (default STAGING_BASIC_AUTH_PASSWORD)}
        {--resolve-local : Risolve l\'host dello staging su 127.0.0.1 (bypass Cloudflare)}
        {--insecure : Disabilita verifica SSL (utile se il certificato staging è scaduto)}';

    protected $description = 'Verifica JSON-LD Product su schede disponibili e HTTP 410 sui venduti (staging)';

    /** @var list<string> */
    private array $locales = ['it', 'en', 'es', 'fr', 'de'];

    public function handle(ProductAvailabilityService $availability): int
    {
        $base = rtrim((string) ($this->option('base') ?: env('SEO_VERIFY_BASE_URL', 'https://staging.moruzzi.it')), '/');
        $user = (string) ($this->option('user') ?: env('STAGING_BASIC_AUTH_USER', ''));
        $password = (string) ($this->option('password') ?: env('STAGING_BASIC_AUTH_PASSWORD', ''));
        $availableCount = max(1, (int) $this->option('available'));
        $soldCount = max(1, (int) $this->option('sold'));

        if ($user === '' || $password === '') {
            $this->error('Imposta STAGING_BASIC_AUTH_USER / STAGING_BASIC_AUTH_PASSWORD oppure --user/--password.');

            return self::FAILURE;
        }

        $resolveLocal = (bool) $this->option('resolve-local')
            || filter_var(env('SEO_VERIFY_RESOLVE_LOCAL', true), FILTER_VALIDATE_BOOLEAN);
        $insecure = (bool) $this->option('insecure')
            || filter_var(env('SEO_VERIFY_INSECURE', true), FILTER_VALIDATE_BOOLEAN);

        $this->info("Base: {$base}");
        if ($resolveLocal) {
            $this->line('DNS: resolve locale → 127.0.0.1');
        }

        $availableProducts = $availability
            ->applyPublicAvailabilityConstraints(Product::query())
            ->orderByDesc('entity_id')
            ->limit(max($availableCount * 2, 50))
            ->get();

        $soldProducts = Product::query()
            ->whereIn('visibility', [1, 4])
            ->where(function ($q) {
                $q->where('qty', '<=', 0)->orWhere('disponibili', '<=', 0);
            })
            ->orderByDesc('entity_id')
            ->limit(max($soldCount * 2, 50))
            ->get();

        $availableOk = 0;
        $availableFail = 0;
        $soldOk = 0;
        $soldFail = 0;
        $manualUrls = [];

        $availableSamples = $this->sampleAcrossLocales($availableProducts, $availableCount);
        $soldSamples = $this->sampleAcrossLocales($soldProducts, $soldCount);

        $this->line('');
        $this->info('=== Disponibili (atteso 200 + JSON-LD InStock) ===');
        foreach ($availableSamples as [$product, $locale]) {
            $path = $this->productPath($product, $locale);
            $url = $base.$path;
            $result = $this->fetch($url, $user, $password, $resolveLocal, $insecure);
            $check = $this->assertAvailable($result, $product);

            if ($check['ok']) {
                $availableOk++;
                $this->line("<info>OK</info>  [{$locale}] {$url}");
                if (count($manualUrls) < 5) {
                    $manualUrls[] = $url;
                }
            } else {
                $availableFail++;
                $this->line("<error>FAIL</error> [{$locale}] {$url} — ".$check['reason']);
            }
        }

        $this->line('');
        $this->info('=== Venduti (atteso 410 senza dati prodotto) ===');
        foreach ($soldSamples as [$product, $locale]) {
            $path = $this->productPath($product, $locale);
            $url = $base.$path;
            $result = $this->fetch($url, $user, $password, $resolveLocal, $insecure);
            $check = $this->assertSold($result, $product);

            if ($check['ok']) {
                $soldOk++;
                $this->line("<info>OK</info>  [{$locale}] {$url}");
            } else {
                $soldFail++;
                $this->line("<error>FAIL</error> [{$locale}] {$url} — ".$check['reason']);
            }
        }

        $this->line('');
        $this->info("Disponibili: {$availableOk}/".count($availableSamples)." ok, {$availableFail} fail");
        $this->info("Venduti: {$soldOk}/".count($soldSamples)." ok, {$soldFail} fail");

        $this->line('');
        $this->info('=== 5 URL per Rich Results Test (Google) ===');
        foreach ($manualUrls as $i => $url) {
            $this->line(($i + 1).'. '.$url);
        }

        return ($availableFail === 0 && $soldFail === 0) ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Product>  $products
     * @return list<array{0: Product, 1: string}>
     */
    private function sampleAcrossLocales($products, int $limit): array
    {
        $out = [];
        $i = 0;
        foreach ($products as $product) {
            $locale = $this->locales[$i % count($this->locales)];
            $out[] = [$product, $locale];
            $i++;
            if (count($out) >= $limit) {
                break;
            }
        }

        return $out;
    }

    private function productPath(Product $product, string $locale): string
    {
        $slug = product_seo_slug($product, $locale);
        $prefix = $locale === 'it' ? '/' : '/'.$locale.'/';

        return $prefix.$slug.'-'.$product->entity_id.'.html';
    }

    /**
     * @return array{status: int, body: string, error?: string}
     */
    private function fetch(
        string $url,
        string $user,
        string $password,
        bool $resolveLocal = false,
        bool $insecure = false,
    ): array {
        try {
            $options = [];
            if ($insecure) {
                $options['verify'] = false;
            }
            if ($resolveLocal) {
                $host = parse_url($url, PHP_URL_HOST);
                $scheme = parse_url($url, PHP_URL_SCHEME) ?: 'https';
                $port = parse_url($url, PHP_URL_PORT) ?: ($scheme === 'https' ? 443 : 80);
                if (is_string($host) && $host !== '') {
                    $options['curl'] = [
                        CURLOPT_RESOLVE => ["{$host}:{$port}:127.0.0.1"],
                    ];
                }
            }

            $response = Http::withBasicAuth($user, $password)
                ->withHeaders([
                    'User-Agent' => 'MoruzziSeoVerify/1.0',
                    'Accept' => 'text/html',
                ])
                ->withOptions($options)
                ->timeout(30)
                ->get($url);

            return [
                'status' => $response->status(),
                'body' => $response->body(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 0,
                'body' => '',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param  array{status: int, body: string, error?: string}  $result
     * @return array{ok: bool, reason?: string}
     */
    private function assertAvailable(array $result, Product $product): array
    {
        if (! empty($result['error'])) {
            return ['ok' => false, 'reason' => $result['error']];
        }
        if ((int) $result['status'] !== 200) {
            return ['ok' => false, 'reason' => 'HTTP '.$result['status']];
        }

        $body = $result['body'];
        if (! preg_match_all('#<script type="application/ld\+json">\s*(.*?)\s*</script>#si', $body, $matches)) {
            return ['ok' => false, 'reason' => 'nessun JSON-LD'];
        }

        $productSchema = null;
        foreach ($matches[1] as $json) {
            try {
                $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            } catch (\Throwable $e) {
                return ['ok' => false, 'reason' => 'JSON-LD non valido: '.$e->getMessage()];
            }

            if (($data['@type'] ?? null) === 'Product') {
                $productSchema = $data;
                break;
            }
            if (isset($data['@graph']) && is_array($data['@graph'])) {
                foreach ($data['@graph'] as $node) {
                    if (($node['@type'] ?? null) === 'Product') {
                        $productSchema = $node;
                        break 2;
                    }
                }
            }
        }

        if ($productSchema === null) {
            return ['ok' => false, 'reason' => 'manca @type Product'];
        }

        $availability = (string) data_get($productSchema, 'offers.availability', '');
        if (! str_contains($availability, 'InStock')) {
            return ['ok' => false, 'reason' => 'availability non InStock: '.$availability];
        }

        $schemaName = trim((string) ($productSchema['name'] ?? ''));
        $pageName = trim((string) ($product->name ?? ''));
        if ($schemaName === '' || ($pageName !== '' && ! str_contains($body, mb_substr($pageName, 0, min(40, mb_strlen($pageName)))))) {
            // Confronta almeno che il name schema sia non vuoto e che un frammento del nome sia in pagina
            if ($schemaName === '') {
                return ['ok' => false, 'reason' => 'name schema vuoto'];
            }
        }

        $schemaPrice = (string) data_get($productSchema, 'offers.price', '');
        $expectedPrice = number_format(round((float) $product->final_price, 2), 2, '.', '');
        if ($schemaPrice !== $expectedPrice) {
            return ['ok' => false, 'reason' => "price schema {$schemaPrice} != {$expectedPrice}"];
        }

        // Prezzo formattato in pagina (es. 1.234,56 €) — verifica che la parte intera compaia
        $intPart = (string) (int) floor((float) $product->final_price);
        if ($intPart !== '' && ! str_contains($body, $intPart)) {
            return ['ok' => false, 'reason' => 'prezzo non trovato nel HTML'];
        }

        return ['ok' => true];
    }

    /**
     * @param  array{status: int, body: string, error?: string}  $result
     * @return array{ok: bool, reason?: string}
     */
    private function assertSold(array $result, Product $product): array
    {
        if (! empty($result['error'])) {
            return ['ok' => false, 'reason' => $result['error']];
        }
        if ((int) $result['status'] !== 410) {
            return ['ok' => false, 'reason' => 'HTTP '.$result['status'].' (atteso 410)'];
        }

        $body = $result['body'];
        if (! str_contains($body, 'noindex')) {
            return ['ok' => false, 'reason' => 'manca meta robots noindex'];
        }

        $sku = trim((string) ($product->sku ?? ''));
        if ($sku !== '' && str_contains($body, $sku)) {
            return ['ok' => false, 'reason' => 'SKU presente nel body'];
        }

        $image = trim((string) ($product->image ?? ''));
        if ($image !== '') {
            $basename = basename($image);
            if ($basename !== '' && str_contains($body, $basename)) {
                return ['ok' => false, 'reason' => 'immagine prodotto nel body'];
            }
            if (str_contains($body, 'img.moruzzi.it/prodotti/')) {
                return ['ok' => false, 'reason' => 'URL img.moruzzi.it/prodotti nel body'];
            }
        }

        $nameFragment = mb_substr(trim((string) ($product->name ?? '')), 0, 30);
        if ($nameFragment !== '' && str_contains($body, $nameFragment)) {
            return ['ok' => false, 'reason' => 'nome prodotto nel body'];
        }

        if (str_contains($body, 'application/ld+json')) {
            return ['ok' => false, 'reason' => 'JSON-LD presente sulla 410'];
        }

        return ['ok' => true];
    }
}
