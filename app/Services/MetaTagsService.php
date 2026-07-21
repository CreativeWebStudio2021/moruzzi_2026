<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MetaTagsService
{
    protected string $siteName;

    public function __construct()
    {
        $this->siteName = config('app.name');
    }

    /**
     * Restituisce ['title' => string, 'description' => string] per la pagina corrente.
     */
    public function getMeta(Request $request): array
    {
        $route = Route::current();
        if (!$route) {
            return [
                'title' => $this->siteName,
                'description' => $this->siteName,
                'image' => '',
            ];
        }

        $controllerAction = $route->getAction('controller');
        $actionName = is_array($controllerAction)
            ? ($controllerAction[0] ?? '') . '@' . ($controllerAction[1] ?? '')
            : (string) $controllerAction;
        $routeName = $route->getName();
        $routeNameForMatch = $routeName ? preg_replace('#^locale\.#', '', $routeName) : null;

        // Prodotto (ProductController@show)
        if (str_contains($actionName, 'ProductController') && str_contains($actionName, 'show')) {
            return $this->metaProduct($request);
        }

        // Categoria (CatalogController@category)
        if (str_contains($actionName, 'CatalogController') && str_contains($actionName, 'category')) {
            return $this->metaCategory($request);
        }

        // Pagine identificate per path (route senza nome, es. chi-siamo)
        $path = trim($request->path(), '/');
        $pathWithoutLocale = preg_replace('#^(en|de|fr|es)/#', '', $path);
        if ($pathWithoutLocale === 'chi-siamo') {
            return $this->metaGeneric(__('seo.chi_siamo'));
        }

        if ($routeNameForMatch && str_starts_with($routeNameForMatch, 'guide.')) {
            return $this->metaGuide($routeNameForMatch);
        }

        return match ($routeNameForMatch) {
            'home' => $this->metaHome(),
            'catalog.index' => $this->metaCatalogIndex($request),
            'cart.index' => $this->metaCart(),
            'checkout.shipping' => $this->metaCheckoutStep(__('seo.checkout_shipping')),
            'checkout.review' => $this->metaCheckoutStep(__('seo.checkout_review')),
            'checkout.thankyou' => $this->metaCheckoutStep(__('seo.checkout_thankyou')),
            'account.register.page' => $this->metaGeneric(__('seo.register')),
            'account.dashboard' => $this->metaGeneric(__('seo.my_account')),
            'account.orders' => $this->metaGeneric(__('seo.my_orders')),
            'account.orders.show' => $this->metaGeneric(__('seo.order_detail')),
            'account.shipping' => $this->metaGeneric(__('seo.shipping_data')),
            'account.password' => $this->metaGeneric(__('seo.change_password')),
            'login' => $this->metaGeneric(__('auth.login')),
            'register' => $this->metaGeneric(__('seo.register')),
            'password.request' => $this->metaGeneric(__('seo.password_recovery')),
            'password.reset' => $this->metaGeneric(__('seo.password_recovery')),
            'sitemap' => $this->metaSitemap(),
            default => $this->metaFallback($routeNameForMatch),
        };
    }

    protected function metaHome(): array
    {
        return [
            'title' => __('seo.home_meta_title'),
            'description' => __('seo.home_meta_description'),
        ];
    }

    protected function metaCatalogIndex(Request $request): array
    {
        $categoryId = $request->query('category');
        $page = (int) $request->query('page', 1);

        if (!$categoryId) {
            return [
                'title' => __('seo.products') . ' - ' . $this->siteName,
                'description' => __('seo.products_discover') . ' - ' . $this->siteName,
            ];
        }

        $category = Category::find($categoryId);
        if (!$category) {
            return [
                'title' => __('seo.products') . ' - ' . $this->siteName,
                'description' => __('seo.products_discover') . ' - ' . $this->siteName,
            ];
        }

        $name = $category->translated_name;
        $title = $name;
        if ($page > 1) {
            $title .= ' - ' . __('seo.page') . ' ' . $page;
        }
        $title .= ' | ' . $this->siteName;

        $desc = __('seo.products_discover_in') . ' ' . $name;
        if ($page > 1) {
            $desc .= ' - ' . __('seo.page') . ' ' . $page;
        }
        $desc .= ' - ' . $this->siteName;

        return [
            'title' => $title,
            'description' => $desc,
        ];
    }

    protected function metaCategory(Request $request): array
    {
        $categoryPath = $request->route('categoryPath');
        $locale = app()->getLocale();
        $linkColumn = 'link_' . $locale;
        $fullLink = $categoryPath . '.html';

        $category = resolve_category_by_link($fullLink, $locale);

        if (!$category) {
            return [
                'title' => __('seo.products') . ' - ' . $this->siteName,
                'description' => __('seo.products_discover') . ' - ' . $this->siteName,
            ];
        }

        $page = (int) $request->query('page', 1);
        $name = $category->translated_name;

        $title = $name;
        if ($page > 1) {
            $title .= ' - ' . __('seo.page') . ' ' . $page;
        }
        $title .= ' | ' . $this->siteName;

        $descCol = 'description_' . $locale;
        $descContent = $category->{$descCol} ?? $category->description ?? '';
        $desc = $descContent !== ''
            ? strip_tags($descContent)
            : (__('seo.products_discover_in') . ' ' . $name);
        if ($page > 1) {
            $desc .= ' - ' . __('seo.page') . ' ' . $page;
        }
        $desc .= ' - ' . $this->siteName;

        return [
            'title' => $title,
            'description' => \Illuminate\Support\Str::limit($desc, 160),
        ];
    }

    protected function metaProduct(Request $request): array
    {
        $productPath = $request->route('productPath');
        if (!preg_match('/^(.+)-([0-9]+)\.html$/i', $productPath, $m)) {
            return ['title' => $this->siteName, 'description' => $this->siteName];
        }

        $id = (int) $m[2];
        $product = Product::find($id);
        if (!$product) {
            return ['title' => $this->siteName, 'description' => $this->siteName];
        }

        $locale = app()->getLocale();
        $name = $product->{'name_' . $locale} ?? $product->name;

        $title = $product->meta_title ?? null;
        if (empty($title)) {
            $title = $name . ' | ' . $this->siteName;
        }

        $description = $product->meta_description ?? null;
        if (empty($description)) {
            $short = $product->short_description ?? '';
            $description = $short !== '' ? strip_tags($short) : $title;
        }
        $description = \Illuminate\Support\Str::limit($description, 160);

        $image = '';
        if (!empty($product->image)) {
            $image = product_image_url($product->image, 'full');
        }

        return [
            'title' => $title,
            'description' => $description,
            'image' => $image,
        ];
    }

    protected function metaCart(): array
    {
        $title = __('seo.cart') . ' | ' . $this->siteName;
        return [
            'title' => $title,
            'description' => $title,
        ];
    }

    protected function metaCheckoutStep(string $stepLabel): array
    {
        $title = $stepLabel . ' - ' . __('seo.checkout') . ' | ' . $this->siteName;
        return [
            'title' => $title,
            'description' => $title,
        ];
    }

    protected function metaGeneric(string $label): array
    {
        $title = $label . ' | ' . $this->siteName;
        return [
            'title' => $title,
            'description' => $title,
        ];
    }

    protected function metaSitemap(): array
    {
        return [
            'title' => __('sitemap.title') . ' | ' . $this->siteName,
            'description' => \Illuminate\Support\Str::limit(__('sitemap.meta_description'), 160),
        ];
    }

    protected function metaGuide(string $routeName): array
    {
        $articleKey = $routeName === 'guide.index' ? 'index' : substr($routeName, strlen('guide.'));
        $article = __('guide.articles.'.$articleKey);

        if (! is_array($article)) {
            return $this->metaGeneric(__('guide.menu'));
        }

        $title = ($article['title'] ?? __('guide.menu')).' | '.$this->siteName;
        $description = \Illuminate\Support\Str::limit($article['lead'] ?? $article['title'] ?? __('guide.menu'), 160);

        return [
            'title' => $title,
            'description' => $description,
        ];
    }

    protected function metaFallback(?string $routeName): array
    {
        $title = $this->siteName;
        if ($routeName) {
            $label = str_replace(['.', '-', '_'], ' ', $routeName);
            $title = ucwords($label) . ' | ' . $this->siteName;
        }
        return [
            'title' => $title,
            'description' => $this->siteName,
        ];
    }
}
