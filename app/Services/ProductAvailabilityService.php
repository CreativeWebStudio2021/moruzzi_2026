<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductAvailabilityService
{
    public const OPEN_ORDER_STATUSES = [
        'nuovo',
        'pagato',
        'pending',
        'processing',
        'holded',
        'payment_review',
    ];

    private const CACHE_TTL_SECONDS = 90;

    /**
     * Calcola la disponibilità per molti prodotti con 2 query aggregate.
     *
     * @param  iterable<int, Product>  $products
     */
    public function hydrateCollection(iterable $products, ?int $excludeCartId = null): void
    {
        $products = collect($products)->filter(fn ($product) => $product instanceof Product)->values();

        if ($products->isEmpty()) {
            return;
        }

        $productIds = $products->pluck('entity_id')->unique()->values()->all();
        $reservedByOrders = $this->reservedByOrders($productIds);
        $reservedByCarts = $this->reservedByCarts($productIds, $excludeCartId);

        foreach ($products as $product) {
            $productId = (int) $product->entity_id;
            $product->setResolvedAvailableQuantity(
                $this->compute(
                    (int) ($product->qty ?? 0),
                    (int) ($reservedByOrders[$productId] ?? 0),
                    (int) ($reservedByCarts[$productId] ?? 0),
                )
            );
        }
    }

    /**
     * Disponibilità singola (con cache breve se non già idratata).
     */
    public function availableQuantity(Product $product, bool $useCache = true): int
    {
        if ($product->hasResolvedAvailableQuantity()) {
            return $product->getResolvedAvailableQuantity();
        }

        if (! $useCache) {
            return $this->computeForProduct($product);
        }

        return (int) Cache::remember(
            $this->cacheKey((int) $product->entity_id),
            self::CACHE_TTL_SECONDS,
            fn () => $this->computeForProduct($product)
        );
    }

    /**
     * Calcolo sempre fresco (carrello, checkout).
     */
    public function computeForProduct(Product $product, ?int $excludeCartId = null): int
    {
        $productId = (int) $product->entity_id;
        $reservedByOrders = $this->reservedByOrders([$productId]);
        $reservedByCarts = $this->reservedByCarts([$productId], $excludeCartId);

        return $this->compute(
            (int) ($product->qty ?? 0),
            (int) ($reservedByOrders[$productId] ?? 0),
            (int) ($reservedByCarts[$productId] ?? 0),
        );
    }

    public function forget(int|Product $product): void
    {
        $productId = $product instanceof Product ? (int) $product->entity_id : $product;
        Cache::forget($this->cacheKey($productId));
    }

    /**
     * @param  list<int>|Collection<int, int>  $productIds
     */
    public function forgetMany(array|Collection $productIds): void
    {
        foreach (Collection::wrap($productIds) as $productId) {
            $this->forget((int) $productId);
        }
    }

    private function compute(int $stock, int $reservedByOrders, int $reservedByCarts): int
    {
        return max(0, $stock - $reservedByOrders - $reservedByCarts);
    }

    /**
     * @param  list<int>  $productIds
     * @return array<int, int>
     */
    private function reservedByOrders(array $productIds): array
    {
        if ($productIds === []) {
            return [];
        }

        return OrderItem::query()
            ->whereIn('id_prod', $productIds)
            ->whereHas('order', function ($query) {
                $query->whereIn('status', self::OPEN_ORDER_STATUSES);
            })
            ->groupBy('id_prod')
            ->selectRaw('id_prod, SUM(quantita) as reserved')
            ->pluck('reserved', 'id_prod')
            ->map(fn ($value) => (int) $value)
            ->all();
    }

    /**
     * @param  list<int>  $productIds
     * @return array<int, int>
     */
    private function reservedByCarts(array $productIds, ?int $excludeCartId = null): array
    {
        if ($productIds === []) {
            return [];
        }

        return CartItem::query()
            ->whereIn('product_id', $productIds)
            ->whereHas('cart', function ($query) use ($excludeCartId) {
                $query->activeNotExpired();
                if ($excludeCartId) {
                    $query->where('id', '!=', $excludeCartId);
                }
            })
            ->groupBy('product_id')
            ->selectRaw('product_id, SUM(quantity) as reserved')
            ->pluck('reserved', 'product_id')
            ->map(fn ($value) => (int) $value)
            ->all();
    }

    private function cacheKey(int $productId): string
    {
        return 'product_avail:'.$productId;
    }
}
