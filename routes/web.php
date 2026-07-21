<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\PayPalController;
use App\Support\GuideRegistry;

/*
|--------------------------------------------------------------------------
| PATTERN GLOBALE LOCALE (fondamentale)
|--------------------------------------------------------------------------
*/

Route::pattern('locale', 'en|es|fr|de');

Route::withoutMiddleware(['web'])->group(function () {
    Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');
    Route::get('/sitemap-pages.xml', [SitemapController::class, 'xmlPages'])->name('sitemap.xml.pages');
    Route::get('/sitemap-images.xml', [SitemapController::class, 'xmlImages'])->name('sitemap.xml.images');
    Route::get('/sitemap-videos.xml', [SitemapController::class, 'xmlVideos'])->name('sitemap.xml.videos');
});

/*
|--------------------------------------------------------------------------
| PayPal (Website Payments Standard — fuori dal prefisso lingua)
|--------------------------------------------------------------------------
*/

Route::post('/ipn.php', [PayPalController::class, 'ipn'])->name('paypal.ipn');
Route::match(['get', 'post'], '/paypal/response', [PayPalController::class, 'return'])->name('paypal.return');

Route::get('/internal/dropbox-sync', \App\Http\Controllers\DropboxSyncController::class)
    ->name('dropbox.sync.webhook');

/*
|--------------------------------------------------------------------------
| ROTTE CON PREFISSO LINGUA
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => '{locale}',
    'middleware' => 'setlocale',
    'as' => 'locale.'
], function () {

    /*
    |--------------------------------------------------------------------------
    | ROTTE SPECIFICHE PRIMA (IMPORTANTE)
    |--------------------------------------------------------------------------
    */

    // Prodotto
    Route::get('/{productPath}', [ProductController::class, 'show'])
        ->where('productPath', '.*-[0-9]+\.html');

    // Categoria
    Route::get('/{categoryPath}.html', [CatalogController::class, 'category'])
        ->where('categoryPath', '^(?!.*-\d+$).+');

    /*
    |--------------------------------------------------------------------------
    | STATICHE E STANDARD
    |--------------------------------------------------------------------------
    */

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('/chi-siamo')->group(function () {
        Route::get('/', function () {
            return view('web.about.ci-presentiamo');
        })->name('about.presentation');

        Route::get('/lo-staff', function () {
            return view('web.about.lo-staff');
        })->name('about.staff');

        Route::get('/loredana-moruzzi', function () {
            return view('web.about.loredana-moruzzi');
        })->name('about.loredana');

        Route::get('/umberto-moruzzi', function () {
            return view('web.about.umberto-moruzzi');
        })->name('about.umberto');

        Route::get('/nicola-mecci', function () {
            return view('web.about.nicola-mecci');
        })->name('about.nicola');

        Route::get('/hiroko-blue-lynx', function () {
            return view('web.about.hiroko-blue-lynx');
        })->name('about.hiroko');

        Route::get('/francesca-barenghi', function () {
            return view('web.about.francesca-barenghi');
        })->name('about.francesca');

        Route::get('/le-nostre-pubblicazioni', function () {
            return view('web.about.le-nostre-pubblicazioni');
        })->name('about.publications');

        Route::get('/dicono-di-noi', function () {
            return view('web.about.dicono-di-noi');
        })->name('about.press');

        Route::get('/memberships', function () {
            return view('web.about.memberships');
        })->name('about.memberships');
    });

    Route::prefix('/certificazioni')->group(function () {
        Route::get('/certificato-online', function () {
            return view('web.certificazioni.certificato-online');
        })->name('certifications.online');

        Route::get('/certificazione-di-qualita-moruzzi', function () {
            return view('web.certificazioni.certificazione-di-qualita');
        })->name('certifications.quality');

        Route::get('/garanzia-moruzzi-numismatica', function () {
            return view('web.certificazioni.garanzia-moruzzi-numismatica');
        })->name('certifications.guarantee');

        Route::get('/attestati-garanzia-provenienza', function () {
            return view('web.certificazioni.attestati-garanzia-provenienza');
        })->name('certifications.attestati');

        Route::get('/standard-qualitativo', function () {
            return view('web.certificazioni.standard-qualitativo');
        })->name('certifications.standard');

        Route::get('/upgrade-qualita', function () {
            return view('web.certificazioni.upgrade-qualita');
        })->name('certifications.upgrade');

        Route::get('/stime-perizie-monete', function () {
            return view('web.certificazioni.stime-perizie-monete');
        })->name('certifications.estimates_coins');

        Route::get('/stime-perizie-banconote', function () {
            return view('web.certificazioni.stime-perizie-banconote');
        })->name('certifications.estimates_banknotes');

        Route::get('/perizie-monete', function () {
            return view('web.certificazioni.perizie-monete');
        })->name('certifications.expertise_coins');

        Route::get('/valutazione-monete-banconote', function () {
            return view('web.certificazioni.valutazione-monete-banconote');
        })->name('certifications.valuation');

        Route::get('/perizie-banconote', function () {
            return view('web.certificazioni.perizie-banconote');
        })->name('certifications.expertise_banknotes');

        Route::get('/catalogazioni-monete-banconote', function () {
            return view('web.certificazioni.catalogazioni-monete-banconote');
        })->name('certifications.cataloguing');
    });

    Route::prefix('/vendere')->group(function () {
        Route::get('/come-vendere', function () {
            return view('web.vendere.come-vendere');
        })->name('sell.how');

        Route::get('/vendi-alla-moruzzi-numismatica', function () {
            return view('web.vendere.vendi-moruzzi');
        })->name('sell.to_moruzzi');

        Route::get('/oggi-compriamo', function () {
            return view('web.vendere.oggi-compriamo');
        })->name('sell.today_buy');
    });

    Route::get('/condizioni-di-vendita', function () {
        return view('web.negozio.condizioni-vendita');
    })->name('shop.terms');

    Route::get('/abbreviazioni-monete', function () {
        return view('web.negozio.abbreviazioni-monete');
    })->name('shop.abbreviations');

    Route::get('/collezionare-monete-antiche', function () {
        return view('web.negozio.collezionare-monete-antiche');
    })->name('shop.collecting');

    Route::get('/privacy', function () {
        return view('web.legal.privacy');
    })->name('legal.privacy');

    Route::get('/cookie-policy', function () {
        return view('web.legal.cookie-policy');
    })->name('legal.cookie_policy');

    Route::get('/contatti', [ContactController::class, 'show'])->name('contact.form');
    Route::post('/contatti', [ContactController::class, 'submit'])->name('contact.submit');
    Route::get('/contatti/thankyou', [ContactController::class, 'thankyou'])->name('contact.thankyou');

    Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');

    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::get('/newsletter/dismiss', [NewsletterController::class, 'dismiss'])->name('newsletter.dismiss');

    Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
    Route::post('/catalogo/load-products', [CatalogController::class, 'loadProducts'])->name('catalog.load');
    Route::get('/catalogo/session', [CatalogController::class, 'updateSession'])->name('catalog.session');
    Route::get('/catalogo/search', [CatalogController::class, 'liveSearch'])->name('catalog.search');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear',  [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/mini', [CartController::class, 'mini'])->name('cart.mini');

    Route::get('/crea-account', function () {
        if (!session()->has('url.intended')) {
            session(['url.intended' => locale_route('checkout.shipping')]);
        }

        return view('web.auth.register');
    })->name('account.register.page');

    Route::get('/checkout/scelta', [CheckoutController::class, 'options'])->name('checkout.options');
    Route::get('/checkout/ospite', [CheckoutController::class, 'guestForm'])->name('checkout.guest');
    Route::post('/checkout/ospite', [CheckoutController::class, 'storeGuest'])->name('checkout.guest.store');

    Route::middleware('checkout.access')->group(function () {

        Route::get('/checkout', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
        Route::post('/checkout', [CheckoutController::class, 'storeShipping'])->name('checkout.shipping.store');
        Route::get('/checkout/riepilogo', [CheckoutController::class, 'review'])->name('checkout.review');
        Route::post('/checkout/conferma', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
        Route::get('/checkout/paypal/{order}', [CheckoutController::class, 'paypalRedirect'])->name('checkout.paypal');
        Route::get('/checkout/esito/{order}', [CheckoutController::class, 'thankYou'])->name('checkout.thankyou');
    });

    Route::middleware('auth')->group(function () {

        Route::get('/account', [AccountController::class, 'dashboard'])->name('account.dashboard');
        Route::post('/account', [AccountController::class, 'updateProfile'])->name('account.update');
        Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
        Route::get('/account/orders/{order}', [AccountController::class, 'orderDetail'])->name('account.orders.show');
        Route::get('/account/shipping', [AccountController::class, 'shipping'])->name('account.shipping');
        Route::post('/account/shipping', [AccountController::class, 'updateShipping'])->name('account.shipping.update');
        Route::get('/account/password', [AccountController::class, 'password'])->name('account.password');
        Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    });

    (require __DIR__.'/localized_aliases.php')();
});


/*
|--------------------------------------------------------------------------
| ROTTE ITALIANO (SENZA PREFISSO)
|--------------------------------------------------------------------------
*/

Route::middleware('setlocale')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('/chi-siamo')->group(function () {
        Route::get('/', function () {
            return view('web.about.ci-presentiamo');
        })->name('about.presentation');

        Route::get('/lo-staff', function () {
            return view('web.about.lo-staff');
        })->name('about.staff');

        Route::get('/loredana-moruzzi', function () {
            return view('web.about.loredana-moruzzi');
        })->name('about.loredana');

        Route::get('/umberto-moruzzi', function () {
            return view('web.about.umberto-moruzzi');
        })->name('about.umberto');

        Route::get('/nicola-mecci', function () {
            return view('web.about.nicola-mecci');
        })->name('about.nicola');

        Route::get('/hiroko-blue-lynx', function () {
            return view('web.about.hiroko-blue-lynx');
        })->name('about.hiroko');

        Route::get('/francesca-barenghi', function () {
            return view('web.about.francesca-barenghi');
        })->name('about.francesca');

        Route::get('/le-nostre-pubblicazioni', function () {
            return view('web.about.le-nostre-pubblicazioni');
        })->name('about.publications');

        Route::get('/dicono-di-noi', function () {
            return view('web.about.dicono-di-noi');
        })->name('about.press');

        Route::get('/memberships', function () {
            return view('web.about.memberships');
        })->name('about.memberships');
    });

    Route::prefix('/certificazioni')->group(function () {
        Route::get('/certificato-online', function () {
            return view('web.certificazioni.certificato-online');
        })->name('certifications.online');

        Route::get('/certificazione-di-qualita-moruzzi', function () {
            return view('web.certificazioni.certificazione-di-qualita');
        })->name('certifications.quality');

        Route::get('/garanzia-moruzzi-numismatica', function () {
            return view('web.certificazioni.garanzia-moruzzi-numismatica');
        })->name('certifications.guarantee');

        Route::get('/attestati-garanzia-provenienza', function () {
            return view('web.certificazioni.attestati-garanzia-provenienza');
        })->name('certifications.attestati');

        Route::get('/standard-qualitativo', function () {
            return view('web.certificazioni.standard-qualitativo');
        })->name('certifications.standard');

        Route::get('/upgrade-qualita', function () {
            return view('web.certificazioni.upgrade-qualita');
        })->name('certifications.upgrade');

        Route::get('/stime-perizie-monete', function () {
            return view('web.certificazioni.stime-perizie-monete');
        })->name('certifications.estimates_coins');

        Route::get('/stime-perizie-banconote', function () {
            return view('web.certificazioni.stime-perizie-banconote');
        })->name('certifications.estimates_banknotes');

        Route::get('/perizie-monete', function () {
            return view('web.certificazioni.perizie-monete');
        })->name('certifications.expertise_coins');

        Route::get('/valutazione-monete-banconote', function () {
            return view('web.certificazioni.valutazione-monete-banconote');
        })->name('certifications.valuation');

        Route::get('/perizie-banconote', function () {
            return view('web.certificazioni.perizie-banconote');
        })->name('certifications.expertise_banknotes');

        Route::get('/catalogazioni-monete-banconote', function () {
            return view('web.certificazioni.catalogazioni-monete-banconote');
        })->name('certifications.cataloguing');
    });

    Route::prefix('/vendere')->group(function () {
        Route::get('/come-vendere', function () {
            return view('web.vendere.come-vendere');
        })->name('sell.how');

        Route::get('/vendi-alla-moruzzi-numismatica', function () {
            return view('web.vendere.vendi-moruzzi');
        })->name('sell.to_moruzzi');

        Route::get('/oggi-compriamo', function () {
            return view('web.vendere.oggi-compriamo');
        })->name('sell.today_buy');
    });

    Route::get('/condizioni-di-vendita', function () {
        return view('web.negozio.condizioni-vendita');
    })->name('shop.terms');

    Route::get('/abbreviazioni-monete', function () {
        return view('web.negozio.abbreviazioni-monete');
    })->name('shop.abbreviations');

    Route::get('/collezionare-monete-antiche', function () {
        return view('web.negozio.collezionare-monete-antiche');
    })->name('shop.collecting');

    (require __DIR__.'/guide.php')();

    Route::get('/privacy', function () {
        return view('web.legal.privacy');
    })->name('legal.privacy');

    Route::get('/cookie-policy', function () {
        return view('web.legal.cookie-policy');
    })->name('legal.cookie_policy');

    Route::get('/contatti', [ContactController::class, 'show'])->name('contact.form');
    Route::post('/contatti', [ContactController::class, 'submit'])->name('contact.submit');
    Route::get('/contatti/thankyou', [ContactController::class, 'thankyou'])->name('contact.thankyou');

    Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');

    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::get('/newsletter/dismiss', [NewsletterController::class, 'dismiss'])->name('newsletter.dismiss');

    Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
    Route::post('/catalogo/load-products', [CatalogController::class, 'loadProducts'])->name('catalog.load');
    Route::get('/catalogo/session', [CatalogController::class, 'updateSession'])->name('catalog.session');
    Route::get('/catalogo/search', [CatalogController::class, 'liveSearch'])->name('catalog.search');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear',  [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/mini', [CartController::class, 'mini'])->name('cart.mini');

    Route::get('/crea-account', function () {
        if (!session()->has('url.intended')) {
            session(['url.intended' => locale_route('checkout.shipping')]);
        }

        return view('web.auth.register');
    })->name('account.register.page');

    Route::get('/checkout/scelta', [CheckoutController::class, 'options'])->name('checkout.options');
    Route::get('/checkout/ospite', [CheckoutController::class, 'guestForm'])->name('checkout.guest');
    Route::post('/checkout/ospite', [CheckoutController::class, 'storeGuest'])->name('checkout.guest.store');

    Route::middleware('checkout.access')->group(function () {

        Route::get('/checkout', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
        Route::post('/checkout', [CheckoutController::class, 'storeShipping'])->name('checkout.shipping.store');
        Route::get('/checkout/riepilogo', [CheckoutController::class, 'review'])->name('checkout.review');
        Route::post('/checkout/conferma', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
        Route::get('/checkout/paypal/{order}', [CheckoutController::class, 'paypalRedirect'])->name('checkout.paypal');
        Route::get('/checkout/esito/{order}', [CheckoutController::class, 'thankYou'])->name('checkout.thankyou');
    });

    Route::middleware('auth')->group(function () {

        Route::get('/account', [AccountController::class, 'dashboard'])->name('account.dashboard');
        Route::post('/account', [AccountController::class, 'updateProfile'])->name('account.update');
        Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
        Route::get('/account/orders/{order}', [AccountController::class, 'orderDetail'])->name('account.orders.show');
        Route::get('/account/shipping', [AccountController::class, 'shipping'])->name('account.shipping');
        Route::post('/account/shipping', [AccountController::class, 'updateShipping'])->name('account.shipping.update');
        Route::get('/account/password', [AccountController::class, 'password'])->name('account.password');
        Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    });

    (require __DIR__.'/localized_aliases.php')();

    /*
    |--------------------------------------------------------------------------
    | PRODOTTO E CATEGORIA SEMPRE PER ULTIMI
    |--------------------------------------------------------------------------
    */

    Route::get('/{productPath}', [ProductController::class, 'show'])
        ->where('productPath', '.*-[0-9]+\.html');

    Route::get('/{categoryPath}.html', [CatalogController::class, 'category'])
        ->where('categoryPath', '^(?!.*-\d+$).+');
});