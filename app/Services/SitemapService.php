<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Support\GuideRegistry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SitemapService
{
    public const LOCALES = ['it', 'en', 'fr', 'de', 'es'];

    public function staticSections(): array
    {
        $aboutRoutes = [
            'about.presentation',
            'about.staff',
            'about.loredana',
            'about.umberto',
            'about.nicola',
            'about.hiroko',
            'about.publications',
            'about.press',
            'about.memberships',
        ];

        $certKeys = [
            'online', 'quality', 'guarantee', 'attestati', 'standard', 'upgrade',
            'estimates_coins', 'estimates_banknotes', 'expertise_coins', 'valuation',
            'expertise_banknotes', 'cataloguing',
        ];

        $sellKeys = ['how', 'to_moruzzi', 'today_buy'];

        $shopInfoLinks = [
            ['route' => 'shop.terms', 'label' => __('shop_info.links.terms')],
            ['route' => 'certifications.attestati', 'label' => __('shop_info.links.attestati')],
            ['route' => 'shop.abbreviations', 'label' => __('shop_info.links.abbreviations')],
            ['route' => 'certifications.guarantee', 'label' => __('shop_info.links.guarantee')],
            ['route' => 'shop.collecting', 'label' => __('shop_info.links.collecting')],
            ['route' => 'legal.privacy', 'label' => __('seo.privacy_policy')],
            ['route' => 'legal.cookie_policy', 'label' => __('seo.cookie_policy')],
        ];

        return [
            [
                'id' => 'main',
                'title' => __('sitemap.sections.main'),
                'links' => $this->mapNamedRoutes([
                    'home' => __('catalog.home'),
                    'catalog.index' => __('menu.categorie'),
                    'contact.form' => __('menu.contatti'),
                    'cart.index' => __('seo.cart'),
                    'account.register.page' => __('seo.register'),
                ]),
            ],
            [
                'id' => 'about',
                'title' => __('menu.chi-siamo'),
                'links' => collect($aboutRoutes)->map(function (string $route) {
                    $key = str_replace('about.', '', $route);

                    return [
                        'url' => locale_route($route),
                        'label' => __("about.{$key}.title"),
                    ];
                })->all(),
            ],
            [
                'id' => 'certifications',
                'title' => __('menu.certificazione'),
                'links' => collect($certKeys)->map(function (string $key) {
                    return [
                        'url' => locale_route('certifications.'.$key),
                        'label' => __("certifications.{$key}.title"),
                    ];
                })->all(),
            ],
            [
                'id' => 'sell',
                'title' => __('menu.vendere'),
                'links' => collect($sellKeys)->map(function (string $key) {
                    return [
                        'url' => locale_route('sell.'.$key),
                        'label' => __("sell.{$key}.title"),
                    ];
                })->all(),
            ],
            [
                'id' => 'guide',
                'title' => __('guide.menu'),
                'links' => $this->guideLinks(),
            ],
            [
                'id' => 'shop-info',
                'title' => __('shop_info.sidebar_title'),
                'links' => collect($shopInfoLinks)->map(function (array $link) {
                    return [
                        'url' => locale_route($link['route']),
                        'label' => $link['label'],
                    ];
                })->all(),
            ],
        ];
    }

    public function offersLink(): ?array
    {
        $offers = Category::find(969);
        if (!$offers || empty($offers->translated_link)) {
            return null;
        }

        return [
            'url' => $this->categoryUrl($offers, app()->getLocale()),
            'label' => __('menu.offerte'),
        ];
    }

    public function categoryTree(): Collection
    {
        return Cache::remember('catalog_sidebar_categories', now()->addHours(12), function () {
            return Category::where('level', 2)
                ->where('parent_id', 2)
                ->whereNotIn('entity_id', [1436, 969, 1435])
                ->orderBy('position')
                ->with('childrenRecursive')
                ->get();
        });
    }

    public function localizedUrl(string $locale, string $path = ''): string
    {
        $path = ltrim($path, '/');

        return $locale === 'it'
            ? url($path === '' ? '/' : $path)
            : url($locale.($path === '' ? '' : '/'.$path));
    }

    public function routeUrl(string $locale, string $routeName, array $parameters = []): string
    {
        if ($locale === 'it') {
            return route($routeName, $parameters, true);
        }

        return route('locale.'.$routeName, array_merge(['locale' => $locale], $parameters), true);
    }

    public function categoryUrl(Category $category, string $locale): string
    {
        $linkColumn = $locale === 'it' ? 'link_it' : 'link_'.$locale;
        $link = $category->{$linkColumn} ?? $category->link_it;

        return $this->localizedUrl($locale, (string) $link);
    }

    public function productUrl(Product $product, string $locale): string
    {
        $prefix = $locale === 'it' ? '' : $locale.'/';
        $slug = product_seo_slug($product, $locale);

        return url($prefix.$slug.'-'.$product->entity_id.'.html');
    }

    public function alternateUrls(callable $urlBuilder): array
    {
        $alternates = [];

        foreach (self::LOCALES as $locale) {
            $alternates[$locale] = $urlBuilder($locale);
        }

        return $alternates;
    }

    /**
     * @return list<array{loc: string, lastmod: string}>
     */
    public function xmlIndexEntries(): array
    {
        $lastmod = date('Y-m-d');

        return [
            ['loc' => route('sitemap.xml.pages', [], true), 'lastmod' => $lastmod],
            ['loc' => route('sitemap.xml.images', [], true), 'lastmod' => $lastmod],
            ['loc' => route('sitemap.xml.videos', [], true), 'lastmod' => $lastmod],
        ];
    }

    /**
     * @return \Generator<int, array{loc: string, lastmod: ?string, alternates: array<string, string>}>
     */
    public function xmlEntries(): \Generator
    {
        foreach ($this->staticXmlRoutes() as $routeName) {
            yield $this->xmlEntryFromAlternates(
                fn (string $locale) => $this->routeUrl($locale, $routeName)
            );
        }

        foreach ($this->guideRoutesForXml() as $routeName) {
            yield $this->xmlEntryFromAlternates(
                fn (string $locale) => route_url_for_locale($routeName, $locale)
            );
        }

        foreach ($this->allPublicCategories() as $category) {
            yield $this->xmlEntryFromAlternates(
                fn (string $locale) => $this->categoryUrl($category, $locale)
            );
        }

        foreach ($this->visibleProductsQuery(['entity_id', 'name', 'data_inserimento'])->lazy(200) as $product) {
            $lastmod = $product->data_inserimento
                ? date('Y-m-d', strtotime((string) $product->data_inserimento))
                : null;

            yield $this->xmlEntryFromAlternates(
                fn (string $locale) => $this->productUrl($product, $locale),
                $lastmod
            );
        }
    }

    /**
     * @return \Generator<int, array{loc: string, images: list<array{loc: string, title: string}>}>
     */
    public function xmlImageEntries(): \Generator
    {
        foreach ($this->visibleProductsQuery(['entity_id', 'name', 'image'])->with(['gallery:id_product,image'])->lazy(200) as $product) {
            $images = $this->productImages($product);
            if ($images === []) {
                continue;
            }

            yield [
                'loc' => $this->productUrl($product, 'it'),
                'images' => $images,
            ];
        }
    }

    /**
     * @return \Generator<int, array{loc: string, video: array{title: string, description: string, thumbnail_loc: string, player_loc: ?string, content_loc: ?string}>}>
     */
    public function xmlVideoEntries(): \Generator
    {
        foreach ($this->visibleProductsQuery(['entity_id', 'name', 'image', 'video', 'short_description'])->lazy(50) as $product) {
            $video = $this->productVideoEntry($product);
            if ($video === null) {
                continue;
            }

            yield [
                'loc' => $this->productUrl($product, 'it'),
                'video' => $video,
            ];
        }
    }

    /**
     * @return list<array{loc: string, title: string}>
     */
    public function productImages(Product $product): array
    {
        $title = $this->productDisplayName($product);
        $images = [];
        $seen = [];

        foreach ($this->productImagePaths($product) as $path) {
            $loc = product_image_url($path, 'full');
            if ($loc === '' || isset($seen[$loc])) {
                continue;
            }

            $seen[$loc] = true;
            $images[] = [
                'loc' => $loc,
                'title' => $title,
            ];
        }

        return $images;
    }

    /**
     * @return array{title: string, description: string, thumbnail_loc: string, player_loc: ?string, content_loc: ?string}|null
     */
    public function productVideoEntry(Product $product): ?array
    {
        $media = product_video_media($product->video);
        if ($media === null) {
            return null;
        }

        $thumbnail = $media['thumb'] ?? null;
        if ($thumbnail === null && ! empty($product->image)) {
            $thumbnail = product_image_url($product->image, 'full');
        }
        if ($thumbnail === null || $thumbnail === '') {
            return null;
        }

        $description = $this->productVideoDescription($product);
        $isDirectFile = ($media['fancybox_type'] ?? '') === 'html5video';

        return [
            'title' => $this->productDisplayName($product),
            'description' => $description,
            'thumbnail_loc' => $thumbnail,
            'player_loc' => $isDirectFile ? null : $media['src'],
            'content_loc' => $isDirectFile ? $media['src'] : null,
        ];
    }

    protected function mapNamedRoutes(array $routes): array
    {
        return collect($routes)->map(function (string $label, string $route) {
            return [
                'url' => locale_route($route),
                'label' => $label,
            ];
        })->values()->all();
    }

    /**
     * @return list<array{url: string, label: string}>
     */
    protected function guideLinks(): array
    {
        return collect(GuideRegistry::articles())
            ->filter(fn (array $article) => empty($article['redirect_route']))
            ->map(function (array $article) {
                return [
                    'url' => locale_route($article['route']),
                    'label' => __("guide.articles.{$article['id']}.title"),
                ];
            })
            ->values()
            ->all();
    }

    /**
     * Route guida da includere in sitemap-pages.xml (escluse quelle con redirect a pagine già mappate).
     *
     * @return list<string>
     */
    protected function guideRoutesForXml(): array
    {
        return collect(GuideRegistry::articles())
            ->filter(fn (array $article) => empty($article['redirect_route']))
            ->pluck('route')
            ->values()
            ->all();
    }

    protected function staticXmlRoutes(): array
    {
        return [
            'home',
            'catalog.index',
            'contact.form',
            'cart.index',
            'account.register.page',
            'about.presentation',
            'about.staff',
            'about.loredana',
            'about.umberto',
            'about.nicola',
            'about.hiroko',
            'about.publications',
            'about.press',
            'about.memberships',
            'certifications.online',
            'certifications.quality',
            'certifications.guarantee',
            'certifications.attestati',
            'certifications.standard',
            'certifications.upgrade',
            'certifications.estimates_coins',
            'certifications.estimates_banknotes',
            'certifications.expertise_coins',
            'certifications.valuation',
            'certifications.expertise_banknotes',
            'certifications.cataloguing',
            'sell.how',
            'sell.to_moruzzi',
            'sell.today_buy',
            'shop.terms',
            'shop.abbreviations',
            'shop.collecting',
            'sitemap',
        ];
    }

    protected function allPublicCategories(): Collection
    {
        return Cache::remember('sitemap_categories_all', now()->addHours(12), function () {
            return Category::query()
                ->whereNotNull('link_it')
                ->where('link_it', '!=', '')
                ->orderBy('level')
                ->orderBy('position')
                ->get();
        });
    }

    protected function xmlEntryFromAlternates(callable $urlBuilder, ?string $lastmod = null): array
    {
        $alternates = $this->alternateUrls($urlBuilder);
        $locale = 'it';

        return [
            'loc' => $alternates[$locale],
            'lastmod' => $lastmod,
            'alternates' => $alternates,
        ];
    }

    protected function visibleProductsQuery(array $columns): Builder
    {
        return Product::query()
            ->whereIn('visibility', [1, 4])
            ->where('qty', '>', 0)
            ->select($columns)
            ->orderBy('entity_id');
    }

    protected function productDisplayName(Product $product): string
    {
        return trim((string) ($product->name ?? ''));
    }

    protected function productVideoDescription(Product $product): string
    {
        $description = trim(strip_tags((string) ($product->short_description ?? '')));
        if ($description === '') {
            $description = $this->productDisplayName($product);
        }

        return Str::limit($description, 2048, '');
    }

    /**
     * @return list<string>
     */
    protected function productImagePaths(Product $product): array
    {
        $paths = [];

        if (! empty($product->image)) {
            $paths[] = (string) $product->image;
        }

        if ($product->relationLoaded('gallery')) {
            foreach ($product->gallery as $item) {
                if (! empty($item->image)) {
                    $paths[] = (string) $item->image;
                }
            }
        }

        return $paths;
    }
}
