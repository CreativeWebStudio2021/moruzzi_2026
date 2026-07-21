<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitemapController;
use App\Support\GuideRegistry;
use Illuminate\Support\Facades\Route;

/**
 * Registra path alternativi tradotti (oltre ai path italiani già nominati in web.php).
 */
return function (): void {
    $handlers = [
        'home' => fn () => app(HomeController::class)->index(request()),
        'catalog.index' => [CatalogController::class, 'index'],
        'contact.form' => [ContactController::class, 'show'],
        'contact.thankyou' => [ContactController::class, 'thankyou'],
        'cart.index' => [CartController::class, 'index'],
        'account.register.page' => function () {
            if (! session()->has('url.intended')) {
                session(['url.intended' => locale_route('checkout.shipping')]);
            }

            return view('web.auth.register');
        },
        'sitemap' => [SitemapController::class, 'index'],
        'shop.terms' => fn () => view('web.negozio.condizioni-vendita'),
        'shop.abbreviations' => fn () => view('web.negozio.abbreviazioni-monete'),
        'shop.collecting' => fn () => view('web.negozio.collezionare-monete-antiche'),
        'legal.privacy' => fn () => view('web.legal.privacy'),
        'legal.cookie_policy' => fn () => view('web.legal.cookie-policy'),
        'about.presentation' => fn () => view('web.about.ci-presentiamo'),
        'about.staff' => fn () => view('web.about.lo-staff'),
        'about.loredana' => fn () => view('web.about.loredana-moruzzi'),
        'about.umberto' => fn () => view('web.about.umberto-moruzzi'),
        'about.nicola' => fn () => view('web.about.nicola-mecci'),
        'about.hiroko' => fn () => view('web.about.hiroko-blue-lynx'),
        'about.francesca' => fn () => view('web.about.francesca-barenghi'),
        'about.publications' => fn () => view('web.about.le-nostre-pubblicazioni'),
        'about.press' => fn () => view('web.about.dicono-di-noi'),
        'about.memberships' => fn () => view('web.about.memberships'),
        'certifications.online' => fn () => view('web.certificazioni.certificato-online'),
        'certifications.quality' => fn () => view('web.certificazioni.certificazione-di-qualita'),
        'certifications.guarantee' => fn () => view('web.certificazioni.garanzia-moruzzi-numismatica'),
        'certifications.attestati' => fn () => view('web.certificazioni.attestati-garanzia-provenienza'),
        'certifications.standard' => fn () => view('web.certificazioni.standard-qualitativo'),
        'certifications.upgrade' => fn () => view('web.certificazioni.upgrade-qualita'),
        'certifications.estimates_coins' => fn () => view('web.certificazioni.stime-perizie-monete'),
        'certifications.estimates_banknotes' => fn () => view('web.certificazioni.stime-perizie-banconote'),
        'certifications.expertise_coins' => fn () => view('web.certificazioni.perizie-monete'),
        'certifications.valuation' => fn () => view('web.certificazioni.valutazione-monete-banconote'),
        'certifications.expertise_banknotes' => fn () => view('web.certificazioni.perizie-banconote'),
        'certifications.cataloguing' => fn () => view('web.certificazioni.catalogazioni-monete-banconote'),
        'sell.how' => fn () => view('web.vendere.come-vendere'),
        'sell.to_moruzzi' => fn () => view('web.vendere.vendi-moruzzi'),
        'sell.today_buy' => fn () => view('web.vendere.oggi-compriamo'),
        'checkout.options' => [CheckoutController::class, 'options'],
        'checkout.guest' => [CheckoutController::class, 'guestForm'],
        'checkout.shipping' => [CheckoutController::class, 'shipping'],
        'checkout.review' => [CheckoutController::class, 'review'],
        'checkout.thankyou' => [CheckoutController::class, 'thankYou'],
        'account.dashboard' => [AccountController::class, 'dashboard'],
        'account.orders' => [AccountController::class, 'orders'],
        'account.orders.show' => [AccountController::class, 'orderDetail'],
        'account.shipping' => [AccountController::class, 'shipping'],
        'account.password' => [AccountController::class, 'password'],
    ];

    foreach (GuideRegistry::articles() as $article) {
        if (! empty($article['redirect_route'])) {
            $handlers[$article['route']] = fn () => redirect()->to(
                locale_route($article['redirect_route']),
                301
            );
        } else {
            $handlers[$article['route']] = [GuideController::class, 'show'];
        }
    }

    $middleware = [
        'checkout.shipping' => 'checkout.access',
        'checkout.review' => 'checkout.access',
        'checkout.thankyou' => 'checkout.access',
        'account.dashboard' => 'auth',
        'account.orders' => 'auth',
        'account.orders.show' => 'auth',
        'account.shipping' => 'auth',
        'account.password' => 'auth',
    ];

    $registered = [];

    $registerPath = function (string $path, callable|array $handler, ?string $routeMiddleware = null) use (&$registered): void {
        if ($path === '' || isset($registered[$path])) {
            return;
        }

        $registered[$path] = true;

        $register = function () use ($path, $handler): void {
            if (is_array($handler)) {
                Route::get('/'.$path, $handler);
            } else {
                Route::get('/'.$path, $handler);
            }
        };

        if ($routeMiddleware) {
            Route::middleware($routeMiddleware)->group($register);
        } else {
            $register();
        }
    };

    foreach (config('localized_slugs', []) as $routeName => $paths) {
        if (! isset($handlers[$routeName])) {
            continue;
        }

        $primaryPath = $paths['it'] ?? null;
        $handler = $handlers[$routeName];
        $routeMiddleware = $middleware[$routeName] ?? null;

        foreach ($paths as $path) {
            if ($path === $primaryPath) {
                continue;
            }

            $registerPath($path, $handler, $routeMiddleware);
        }
    }

    foreach (GuideRegistry::articles() as $article) {
        if (! isset($handlers[$article['route']])) {
            continue;
        }

        $handler = $handlers[$article['route']];
        $routeMiddleware = $middleware[$article['route']] ?? null;

        foreach (['en', 'fr', 'de', 'es'] as $locale) {
            $legacyPath = GuideRegistry::legacyItalianSlugPath($article, $locale);
            if ($legacyPath !== null) {
                $registerPath($legacyPath, $handler, $routeMiddleware);
            }
        }
    }
};
