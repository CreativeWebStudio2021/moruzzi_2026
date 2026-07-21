<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Support\GuideRegistry;
use Illuminate\Support\Collection;

class GuideCommerceService
{
    public function productLimit(): int
    {
        return (int) config('guide_commerce.product_limit', 8);
    }

    public function guideLinkLimit(): int
    {
        return (int) config('guide_commerce.guide_link_limit', 3);
    }

    /**
     * @return list<string>
     */
    public function excludedArticles(): array
    {
        return config('guide_commerce.excluded_articles', []);
    }

    public function isExcludedArticle(string $articleId): bool
    {
        return in_array($articleId, $this->excludedArticles(), true);
    }

    /**
     * @return list<int>
     */
    public function categoryIdsForArticle(string $articleId): array
    {
        if ($this->isExcludedArticle($articleId)) {
            return [];
        }

        $ids = config("guide_commerce.article_categories.{$articleId}", []);

        return array_values(array_unique(array_map('intval', $ids)));
    }

    /**
     * @return Collection<int, Product>
     */
    public function productsForArticle(string $articleId): Collection
    {
        $categoryIds = $this->categoryIdsForArticle($articleId);

        if ($categoryIds === []) {
            return collect();
        }

        $products = $this->queryProductsByCategories($categoryIds, $this->productLimit());

        app(ProductAvailabilityService::class)->hydrateCollection($products);

        return $products;
    }

    public function catalogUrlForArticle(string $articleId): ?string
    {
        if ($this->isExcludedArticle($articleId)) {
            return null;
        }

        $categoryId = config("guide_commerce.article_catalog_category.{$articleId}");

        if ($categoryId === null) {
            $categoryId = $this->categoryIdsForArticle($articleId)[0] ?? null;
        }

        if ($categoryId === null) {
            return null;
        }

        return category_url((int) $categoryId);
    }

    /**
     * @return list<array{id: string, route: string, title: string, url: string}>
     */
    public function guideLinksForCategory(Category $category): array
    {
        $articleIds = $this->resolveGuideArticleIdsForCategory((int) $category->entity_id);

        return $this->buildGuideLinks($articleIds);
    }

    /**
     * @return list<array{id: string, route: string, title: string, url: string}>
     */
    public function guideLinksForProduct(Product $product): array
    {
        $categoryIds = $this->productCategoryIds($product);
        $articleIds = [];

        foreach ($categoryIds as $categoryId) {
            foreach ($this->resolveGuideArticleIdsForCategory($categoryId) as $articleId) {
                $articleIds[] = $articleId;
            }
        }

        $articleIds = array_values(array_unique($articleIds));

        return $this->buildGuideLinks($articleIds);
    }

    /**
     * @param  list<int>  $categoryIds
     * @return Collection<int, Product>
     */
    private function queryProductsByCategories(array $categoryIds, int $limit): Collection
    {
        $expandedIds = [];

        foreach ($categoryIds as $categoryId) {
            $expandedIds = array_merge(
                $expandedIds,
                Category::getCategoryAndDescendantIds($categoryId)
            );
        }

        $expandedIds = array_values(array_unique(array_map('intval', $expandedIds)));

        if ($expandedIds === []) {
            return collect();
        }

        $query = Product::query()
            ->whereIn('visibility', [1, 4])
            ->where('qty', '>', 0)
            ->where(function ($builder) use ($expandedIds) {
                foreach ($expandedIds as $categoryId) {
                    $builder->orWhere('categorie', 'LIKE', '%@'.$categoryId.'@%');
                }
            })
            ->orderByDesc('entity_id')
            ->limit($limit * 3);

        $products = $query->get();

        if ($products->count() <= $limit) {
            return $products->values();
        }

        return $products->shuffle()->take($limit)->values();
    }

    /**
     * @return list<int>
     */
    private function productCategoryIds(Product $product): array
    {
        $raw = trim((string) ($product->categorie ?? ''), '@');

        if ($raw === '') {
            return [];
        }

        return collect(preg_split('/@+/', $raw, -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn ($value) => (int) $value)
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function resolveGuideArticleIdsForCategory(int $categoryId): array
    {
        $visited = [];
        $currentId = $categoryId;

        while ($currentId > 0 && ! in_array($currentId, $visited, true)) {
            $visited[] = $currentId;

            $guides = config("guide_commerce.category_guides.{$currentId}");

            if (is_array($guides) && $guides !== []) {
                return $this->filterArticleIds($guides);
            }

            $parent = Category::query()
                ->select(['entity_id', 'parent_id'])
                ->where('entity_id', $currentId)
                ->value('parent_id');

            $currentId = (int) ($parent ?? 0);
        }

        return [];
    }

    /**
     * @param  list<string>  $articleIds
     * @return list<string>
     */
    private function filterArticleIds(array $articleIds): array
    {
        $filtered = [];

        foreach ($articleIds as $articleId) {
            if ($this->isExcludedArticle($articleId)) {
                continue;
            }

            if (GuideRegistry::articlesById()[$articleId] ?? null) {
                $filtered[] = $articleId;
            }
        }

        return array_slice(array_values(array_unique($filtered)), 0, $this->guideLinkLimit());
    }

    /**
     * @param  list<string>  $articleIds
     * @return list<array{id: string, route: string, title: string, url: string}>
     */
    private function buildGuideLinks(array $articleIds): array
    {
        $links = [];

        foreach ($this->filterArticleIds($articleIds) as $articleId) {
            $article = GuideRegistry::articlesById()[$articleId] ?? null;

            if ($article === null || ! empty($article['redirect_route'])) {
                continue;
            }

            $route = $article['route'];

            try {
                $url = locale_route($route);
            } catch (\Throwable) {
                continue;
            }

            $links[] = [
                'id' => $articleId,
                'route' => $route,
                'title' => __("guide.articles.{$articleId}.title"),
                'url' => $url,
            ];
        }

        return $links;
    }
}
