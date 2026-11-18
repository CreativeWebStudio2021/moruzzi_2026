<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCheckoutAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            return $next($request);
        }

        $guest = session('checkout_guest', []);

        if (! empty($guest['email'])) {
            return $next($request);
        }

        // Dopo conferma ordine ospite, checkout_guest viene rimosso e resta solo
        // checkout_order_id: serve per /checkout/paypal/{order} e /checkout/esito/{order}.
        if (session()->has('checkout_order_id')) {
            return $next($request);
        }

        return redirect()->to(locale_route('checkout.options'));
    }
}
