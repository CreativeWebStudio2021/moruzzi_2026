<?php

namespace App\Services;

use App\Models\Cart;

class CartMergeService
{
    public const COOKIE_NAME = 'moruzzi_cart_session';

    public function rememberGuestSessionId(): void
    {
        if (auth()->check()) {
            return;
        }

        $sessionId = session()->getId();

        $hasItems = Cart::where('session_id', $sessionId)
            ->activeNotExpired()
            ->whereHas('items')
            ->exists();

        if (!$hasItems) {
            return;
        }

        cookie()->queue(cookie(
            self::COOKIE_NAME,
            $sessionId,
            120,
            '/',
            null,
            request()->secure(),
            true,
            false,
            'lax'
        ));
    }

    public function mergeForUser(int $userId, ?string $guestSessionId = null): void
    {
        $guestSessionId = $guestSessionId ?? request()->cookie(self::COOKIE_NAME);

        if (!$guestSessionId) {
            return;
        }

        $sessionCart = Cart::where('session_id', $guestSessionId)
            ->activeNotExpired()
            ->whereNull('user_id')
            ->first();

        if (!$sessionCart || $sessionCart->items()->count() === 0) {
            return;
        }

        $userCart = Cart::activeNotExpired()
            ->where('user_id', $userId)
            ->first();

        if (! $userCart) {
            $userCart = Cart::create([
                'user_id' => $userId,
                'session_id' => session()->getId(),
                'status' => 'active',
                'expires_at' => now()->addHours(CartService::GUEST_TTL_HOURS),
            ]);
        }

        foreach ($sessionCart->items as $item) {
            $existing = $userCart->items()
                ->where('product_id', $item->product_id)
                ->first();

            if ($existing) {
                $existing->increment('quantity', $item->quantity);
            } else {
                $userCart->items()->create([
                    'product_id'     => $item->product_id,
                    'quantity'       => $item->quantity,
                    'price_snapshot' => $item->price_snapshot,
                ]);
            }
        }

        $sessionCart->items()->delete();
        $sessionCart->delete();

        cookie()->queue(cookie()->forget(self::COOKIE_NAME));
    }
}
