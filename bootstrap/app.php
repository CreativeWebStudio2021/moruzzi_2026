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
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            $script = $_SERVER['SCRIPT_NAME'] ?? '';
            $uri = $_SERVER['REQUEST_URI'] ?? $request->getRequestUri();

            if (str_contains($script, '/admin/') || str_contains($uri, '/admin/')) {
                return response(
                    '<div style="font-family:Arial,sans-serif;padding:20px;max-width:900px;margin:20px auto;border:1px solid #c00;background:#fff5f5;">'
                    .'<h2 style="margin:0 0 12px;color:#900;">Errore backoffice</h2>'
                    .'<p style="margin:0;">'.htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8').'</p>'
                    .'</div>',
                    500,
                    ['Content-Type' => 'text/html; charset=UTF-8']
                );
            }

            return null;
        });
    })->create();
