<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
		// Dietro Cloudflare: fidati dei proxy e leggi X-Forwarded-Proto (https)
		$middleware->trustProxies(at: '*', headers:
			\Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
			\Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
			\Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
			\Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO |
			\Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB
		);

		$middleware->prepend(\App\Http\Middleware\RedirectLegacyShop::class);
		$middleware->prepend(\App\Http\Middleware\RedirectLegacyPdf::class);
		$middleware->prepend(\App\Http\Middleware\RedirectLegacyWww::class);
		$middleware->prepend(\App\Http\Middleware\CanonicalHostAndFontCors::class);
		// Prepend per ultimo => eseguito per primo: la manutenzione ha priorita.
		$middleware->prepend(\App\Http\Middleware\MaintenanceMode::class);

		$middleware->alias([
			'setlocale' => \App\Http\Middleware\SetLocale::class,
			'checkout.access' => \App\Http\Middleware\EnsureCheckoutAccess::class,
		]);

		$middleware->web(append: [
			\App\Http\Middleware\RememberGuestCartSession::class,
		]);

		$middleware->validateCsrfTokens(except: [
			'ipn.php',
			'paypal/response',
		]);
	})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
