<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;

class CartService
{
    public const GUEST_TTL_HOURS = 2;

    /**
     * Marca come abbandonati i carrelli attivi scaduti e invalida la cache disponibilità.
     */
    public function abandonExpiredCarts(): int
    {
        $cartIds = Cart::query()
            ->where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->pluck('id');

        if ($cartIds->isEmpty()) {
            return 0;
        }

        $productIds = CartItem::query()
            ->whereIn('cart_id', $cartIds)
            ->pluck('product_id')
            ->unique()
            ->values();

        $updated = Cart::query()
            ->whereIn('id', $cartIds)
            ->update(['status' => 'abandoned']);

        if ($productIds->isNotEmpty()) {
            app(ProductAvailabilityService::class)->forgetMany($productIds);
        }

        return $updated;
    }

    /**
     * Carrello attivo del visitatore corrente; se scaduto viene abbandonato e ignorato.
     */
    public function findForCurrentVisitor(): ?Cart
    {
        $cart = $this->queryForCurrentVisitor()
            ->with('items.product')
            ->first();

        if (! $cart) {
            return null;
        }

        if ($cart->isExpired()) {
            $this->abandon($cart);

            return null;
        }

        return $cart;
    }

    /**
     * Recupera o crea il carrello attivo del visitatore corrente.
     */
    public function getOrCreate(): Cart
    {
        $cart = $this->findForCurrentVisitor();

        if ($cart) {
            return $cart;
        }

        if (auth()->check()) {
            return Cart::create([
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'status' => 'active',
                'expires_at' => now()->addHours(self::GUEST_TTL_HOURS),
            ]);
        }

        return Cart::create([
            'session_id' => session()->getId(),
            'status' => 'active',
            'expires_at' => now()->addHours(self::GUEST_TTL_HOURS),
        ]);
    }

    /**
     * Prolunga la scadenza del carrello ad ogni interazione.
     */
    public function touchExpiry(Cart $cart): void
    {
        $cart->update([
            'expires_at' => now()->addHours(self::GUEST_TTL_HOURS),
        ]);
    }

    public function abandon(Cart $cart): void
    {
        if ($cart->status !== 'active') {
            return;
        }

        $productIds = $cart->items()->pluck('product_id')->all();

        $cart->update(['status' => 'abandoned']);

        if ($productIds !== []) {
            app(ProductAvailabilityService::class)->forgetMany($productIds);
        }
    }

    /**
     * ID prodotti nel carrello attivo del visitatore (ignora carrelli scaduti).
     */
    public function currentProductIds(): array
    {
        $cart = $this->findForCurrentVisitor();

        if (! $cart) {
            return [];
        }

        return $cart->items()->pluck('product_id')->all();
    }

    /**
     * Quantità di un prodotto nel carrello attivo del visitatore.
     */
    public function quantityForProduct(int $productId): int
    {
        $cart = $this->findForCurrentVisitor();

        if (! $cart) {
            return 0;
        }

        $item = $cart->items()->where('product_id', $productId)->first();

        return $item ? (int) $item->quantity : 0;
    }

    private function queryForCurrentVisitor()
    {
        return Cart::query()
            ->where('status', 'active')
            ->where(function ($q) {
                $q->where('session_id', session()->getId());

                if (auth()->check()) {
                    $q->orWhere('user_id', auth()->id());
                }
            });
    }
}
