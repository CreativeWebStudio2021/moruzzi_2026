<?php

namespace App\Http\Middleware;

use App\Models\Product;
use App\Support\LegacyCategoryRedirectResolver;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reindirizza in 301 i vecchi URL di shop.moruzzi.it verso i nuovi URL canonici
 * di moruzzi.it, per preservare i posizionamenti SEO.
 *
 * Mappatura:
 *  - pagine statiche/ecommerce note  => route nuova (config localized_slugs)
 *  - categorie                       => stesso path, senza prefisso /it/
 *  - prodotti                        => lookup url_key -> entity_id -> URL nuovo
 *  - tutto il resto                  => home della lingua
 */
class RedirectLegacyShop
{
    private const LEGACY_HOSTS = ['shop.moruzzi.it', 'www.shop.moruzzi.it'];

    private const TARGET_BASE = 'https://www.moruzzi.it';

    private const LOCALES = ['it', 'en', 'de', 'fr', 'es'];

    /**
     * Vecchio slug (senza .html e senza prefisso lingua) => nome route nuovo sito.
     */
    private const STATIC_MAP = [
        // Catalogo
        'prodotti' => 'catalog.index',
        'products' => 'catalog.index',
        'produkte' => 'catalog.index',
        'produits' => 'catalog.index',
        'productos' => 'catalog.index',
        // Carrello
        'carrello' => 'cart.index',
        'cart' => 'cart.index',
        'warenkorb' => 'cart.index',
        'panier' => 'cart.index',
        'carrito' => 'cart.index',
        // Account
        'il_mio_account' => 'account.dashboard',
        'my_account' => 'account.dashboard',
        'mein_konto' => 'account.dashboard',
        'mon_compte' => 'account.dashboard',
        'mi_cuenta' => 'account.dashboard',
        // Ordini
        'i_miei_ordini' => 'account.orders',
        'my_orders' => 'account.orders',
        'meine_bestellungen' => 'account.orders',
        'mes_commandes' => 'account.orders',
        'mis_pedidos' => 'account.orders',
        // Dati di spedizione
        'i_miei_dati_di_spedizione' => 'account.shipping',
        'my_shipping_data' => 'account.shipping',
        'meine_versanddaten' => 'account.shipping',
        'mes_informations_de_livraison' => 'account.shipping',
        'mis_datos_de_envio' => 'account.shipping',
        // Registrazione
        'registrati' => 'account.register.page',
        'registration' => 'account.register.page',
        'registrierung' => 'account.register.page',
        'inscription' => 'account.register.page',
        'registro' => 'account.register.page',
        // Checkout
        'scelta-checkout' => 'checkout.options',
        'ospite' => 'checkout.guest',
        'checkout' => 'checkout.shipping',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->getHost(), self::LEGACY_HOSTS, true)) {
            return $next($request);
        }

        return redirect()->away($this->resolveTarget($request), 301);
    }

    private function resolveTarget(Request $request): string
    {
        $path = trim($request->path(), '/');

        if ($path === '' || $path === 'index.php') {
            return self::TARGET_BASE . '/';
        }

        $locale = 'it';
        $segments = explode('/', $path);
        if (in_array($segments[0], self::LOCALES, true)) {
            $locale = $segments[0];
            array_shift($segments);
        }

        $rest = implode('/', $segments);
        $prefix = $locale === 'it' ? '' : $locale . '/';

        if ($rest === '' || $rest === 'home.html') {
            return $this->url($prefix);
        }

        $bare = preg_replace('/\.html$/', '', $rest);

        if (isset(self::STATIC_MAP[$bare])) {
            $routeName = self::STATIC_MAP[$bare];
            // Nota: le chiavi di localized_slugs contengono un punto (es. "catalog.index"),
            // quindi non si possono leggere con la dot-notation di config().
            $slugs = config('localized_slugs', []);
            $target = $slugs[$routeName][$locale]
                ?? $slugs[$routeName]['it']
                ?? '';

            return $this->url($prefix . (string) $target);
        }

        if (str_ends_with($rest, '.html')) {
            if (resolve_category_by_link($rest, $locale)) {
                return $this->url($prefix.$rest);
            }

            $legacyTarget = LegacyCategoryRedirectResolver::resolve(basename($rest), $locale);
            if ($legacyTarget !== null) {
                return $this->url($prefix.$legacyTarget);
            }

            foreach (category_link_alternates($rest) as $alternate) {
                if (resolve_category_by_link($alternate, $locale)) {
                    $category = resolve_category_by_link($alternate, $locale);
                    $canonical = ltrim((string) ($category?->{'link_'.$locale} ?? $category?->link_it ?? $alternate), '/');

                    return $this->url($prefix.$canonical);
                }
            }

            $urlKey = preg_replace('/\.html$/', '', basename($rest));
            $product = Product::where('url_key', $urlKey)->first();
            if ($product) {
                $slug = product_seo_slug($product, $locale);

                return $this->url($prefix . $slug . '-' . $product->entity_id . '.html');
            }
        }

        return $this->url($prefix);
    }

    private function url(string $path): string
    {
        return self::TARGET_BASE . '/' . ltrim($path, '/');
    }
}
