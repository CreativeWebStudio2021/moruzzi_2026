<?php

namespace App\Services\Seo;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

final class ProductJsonLdBuilder
{
    public function __construct(
        private readonly ProductAttributeExtractor $attributes,
        private readonly OrganizationJsonLdBuilder $organization,
        private readonly BreadcrumbJsonLdBuilder $breadcrumbs,
    ) {}

    /**
     * @param  Collection<int, Category>|null  $categories
     * @return list<array<string, mixed>>
     */
    public function graphs(Product $product, ?Collection $categories = null, ?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $graphs = [];

        $productSchema = $this->product($product, $categories, $locale);
        if ($productSchema !== null) {
            $graphs[] = $productSchema;
        }

        $breadcrumbItems = $this->breadcrumbItems($categories);
        $breadcrumb = $this->breadcrumbs->build($breadcrumbItems, product_url($product, $locale));
        if ($breadcrumb !== null) {
            $graphs[] = $breadcrumb;
        }

        return $graphs;
    }

    /**
     * @param  Collection<int, Category>|null  $categories
     * @return array<string, mixed>|null
     */
    public function product(Product $product, ?Collection $categories = null, ?string $locale = null): ?array
    {
        $locale = $locale ?? app()->getLocale();
        $name = trim((string) ($product->{'name_'.$locale} ?? $product->name ?? ''));
        if ($name === '') {
            return null;
        }

        $url = product_url($product, $locale);
        $price = $this->formatPriceAmount($product->final_price);
        if ($price === null) {
            return null;
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $name,
            'url' => $url,
            'offers' => [
                '@type' => 'Offer',
                'url' => $url,
                'price' => $price,
                'priceCurrency' => 'EUR',
                'availability' => 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/UsedCondition',
                'seller' => $this->organization->organization(),
                'hasMerchantReturnPolicy' => $this->returnPolicy($locale),
            ],
        ];

        $description = $this->cleanDescription($product);
        if ($description !== '') {
            $schema['description'] = $description;
        }

        $sku = trim((string) ($product->sku ?? ''));
        if ($sku !== '') {
            $schema['sku'] = $sku;
        }

        $images = $this->imageUrls($product);
        if ($images !== []) {
            $schema['image'] = count($images) === 1 ? $images[0] : $images;
        }

        $categoryName = $this->primaryCategoryName($categories);
        if ($categoryName !== '') {
            $schema['category'] = $categoryName;
        }

        $props = $this->attributes->additionalProperties(
            $name,
            (string) ($product->short_description ?? ''),
            (string) ($product->description ?? ''),
        );
        if ($props !== []) {
            $schema['additionalProperty'] = array_map(
                fn (array $p) => [
                    '@type' => 'PropertyValue',
                    'name' => $p['name'],
                    'value' => $p['value'],
                ],
                $props
            );
        }

        return $schema;
    }

    /**
     * @return array<string, string>
     */
    public function alternateUrls(Product $product): array
    {
        $urls = [];
        foreach (['it', 'en', 'es', 'fr', 'de'] as $locale) {
            $urls[$locale] = product_url($product, $locale);
        }

        return $urls;
    }

    /**
     * @param  Collection<int, Category>|null  $categories
     * @return list<array{name: string, url: ?string}>
     */
    private function breadcrumbItems(?Collection $categories): array
    {
        if (! $categories || $categories->isEmpty()) {
            return [];
        }

        $excludeIds = [969, 1435, 1436];
        $primary = $categories
            ->reject(fn (Category $c) => in_array((int) $c->entity_id, $excludeIds, true))
            ->sortByDesc(fn (Category $c) => (int) ($c->level ?? 0))
            ->first();

        if (! $primary) {
            return [];
        }

        $chain = [];
        $current = $primary;
        $visited = [];

        while ($current && ! in_array((int) $current->entity_id, $visited, true)) {
            $visited[] = (int) $current->entity_id;
            $rawName = (string) ($current->name ?? '');
            $translated = (string) ($current->translated_name ?? $rawName);

            if (! in_array($rawName, ['Root Catalog', 'Default Category'], true)
                && ! in_array($translated, ['Root Catalog', 'Default Category'], true)) {
                $chain[] = [
                    'name' => $translated,
                    'url' => category_url((int) $current->entity_id),
                ];
            }

            $parentId = (int) ($current->parent_id ?? 0);
            if ($parentId <= 0) {
                break;
            }

            $current = Category::query()->where('entity_id', $parentId)->first();
        }

        $chain = array_reverse($chain);
        if ($chain === []) {
            return [];
        }

        // Ultimo elemento = pagina corrente prodotto: senza URL categoria duplicata
        $last = count($chain) - 1;
        $chain[$last]['url'] = null;

        return $chain;
    }

    /**
     * @param  Collection<int, Category>|null  $categories
     */
    private function primaryCategoryName(?Collection $categories): string
    {
        if (! $categories || $categories->isEmpty()) {
            return '';
        }

        $excludeIds = [969, 1435, 1436];
        $primary = $categories
            ->reject(fn (Category $c) => in_array((int) $c->entity_id, $excludeIds, true))
            ->sortByDesc(fn (Category $c) => (int) ($c->level ?? 0))
            ->first();

        return $primary ? trim((string) ($primary->translated_name ?? '')) : '';
    }

    /**
     * @return list<string>
     */
    private function imageUrls(Product $product): array
    {
        $urls = [];

        if (! empty($product->image)) {
            $url = product_image_url((string) $product->image, 'full');
            if (is_string($url) && $url !== '') {
                $urls[] = $url;
            }
        }

        $gallery = $product->relationLoaded('gallery')
            ? $product->gallery
            : $product->gallery()->get();

        foreach ($gallery as $item) {
            $path = (string) ($item->image ?? '');
            if ($path === '') {
                continue;
            }
            $url = product_image_url($path, 'full');
            if (is_string($url) && $url !== '' && ! in_array($url, $urls, true)) {
                $urls[] = $url;
            }
        }

        return $urls;
    }

    private function cleanDescription(Product $product): string
    {
        $raw = (string) ($product->short_description ?: $product->description ?: '');
        $text = html_entity_decode(strip_tags($raw), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text) ?? '';
        $text = trim($text);

        if (mb_strlen($text) > 5000) {
            $text = mb_substr($text, 0, 5000);
        }

        return $text;
    }

    private function formatPriceAmount(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (! is_numeric($value)) {
            $normalized = str_replace(['€', ' ', '.'], ['', '', ''], (string) $value);
            $normalized = str_replace(',', '.', $normalized);
            if (! is_numeric($normalized)) {
                return null;
            }
            $value = $normalized;
        }

        $amount = round((float) $value, 2);
        if ($amount < 0) {
            return null;
        }

        return number_format($amount, 2, '.', '');
    }

    /**
     * @return array<string, mixed>
     */
    private function returnPolicy(string $locale): array
    {
        return [
            '@type' => 'MerchantReturnPolicy',
            'applicableCountry' => 'IT',
            'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
            'merchantReturnDays' => 10,
            'returnMethod' => 'https://schema.org/ReturnByMail',
            'returnFees' => 'https://schema.org/ReturnShippingFees',
            'merchantReturnLink' => locale_route('shop.terms'),
        ];
    }
}
