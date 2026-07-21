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

        if (!empty($guest['email'])) {
            return $next($request);
        }

        return redirect()->to(locale_route('checkout.options'));
    }
}
