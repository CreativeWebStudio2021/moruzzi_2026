<?php

namespace App\Http\Middleware;

use App\Services\CartMergeService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RememberGuestCartSession
{
    public function handle(Request $request, Closure $next): Response
    {
        app(CartMergeService::class)->rememberGuestSessionId();

        return $next($request);
    }
}
