<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use App\Services\GuideCommerceService;
use App\Services\ProductAvailabilityService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly GuideCommerceService $guideCommerce,
        private readonly CartService $cartService,
    ) {}

    public function getSlugAttribute()
	{
		return product_seo_slug($this);
	}

	
	public function show(Request $request, $productPath)
	{
		$path = $request->path();
		$locale = app()->getLocale();

		// Se il path inizia con la lingua, la rimuoviamo
		if (str_starts_with($path, $locale . '/')) {
			$path = substr($path, strlen($locale) + 1);
		}

		// Ora $path è solo:
		// prodotto-123-27831.html

		if (!preg_match('/^(.*)-([0-9]+)\.html$/', $path, $matches)) {
			abort(404);
		}

		$slug = $matches[1];
		$id   = (int) $matches[2];

		$product = Product::where('entity_id', $id)->first();

		if (! $product) {
			$category = resolve_category_by_link($path, $locale);
			if ($category) {
				return app(CatalogController::class)->category(
					$request,
					preg_replace('/\.html$/', '', $path)
				);
			}

			abort(404);
		}

		if (product_is_delisted($product)) {
			return redirect()->to(
				product_delisted_redirect_url($product, $locale),
				301
			);
		}

		/*
		|--------------------------------------------------------------------------
		| SLUG SEO CHECK
		|--------------------------------------------------------------------------
		*/

		$correctSlug = product_seo_slug($product, $locale);
		
		// Redirect 301 se diverso (preserva la lingua dalla route, es. /en/ o nessun prefisso)
		if ($slug !== $correctSlug) {
			return redirect()->to(
				$this->generateProductUrl($product, $correctSlug, $request),
				301
			);
		}

		/*
		|--------------------------------------------------------------------------
		| ESTRAZIONE CATEGORIE DA STRINGA @@
		|--------------------------------------------------------------------------
		*/

		$categoryIds = collect(explode('@@', $product->categorie))
			->filter()
			->map(fn($id) => (int) str_replace('@', '', $id))
			->values();

		$categories = Category::whereIn('entity_id', $categoryIds)
			->orderBy('level')
			->orderByDesc('position')
			->get();

		$relatedProducts = collect();
		if (\Schema::hasColumn($product->getTable(), 'correlati') && !empty(trim((string) $product->correlati))) {
			$raw = trim((string) $product->correlati, '@');
			$ids = collect(preg_split('/@+/', $raw, -1, PREG_SPLIT_NO_EMPTY))
				->map(fn ($s) => (int) str_replace('@', '', trim($s)))
				->filter()
				->unique()
				->values()
				->all();
			if (!empty($ids)) {
				$related = Product::whereIn('entity_id', $ids)
					->whereIn('visibility', [1, 4])
					->where('qty', '>', 0)
					->where('entity_id', '!=', $product->entity_id)
					->get();
				$relatedProducts = $related->sortBy(function ($p) use ($ids) {
					$pos = array_search($p->entity_id, $ids);
					return $pos === false ? 999 : $pos;
				})->values();
			}
		}

		app(ProductAvailabilityService::class)->hydrateCollection(
			collect([$product])->concat($relatedProducts)
		);

		$availableQuantity = $product->availableQuantity();
		$cartQuantity = $this->cartItemQuantity($product->entity_id);
		$guideLinks = $this->guideCommerce->guideLinksForProduct($product);

		return view('web.prodotti_dett', compact(
			'product',
			'categories',
			'relatedProducts',
			'availableQuantity',
			'cartQuantity',
			'guideLinks',
		));
	}

	private function cartItemQuantity(int $productId): int
	{
		return $this->cartService->quantityForProduct($productId);
	}

    private function generateProductUrl($product, $slug, $request = null)
	{
		return product_url($product);
	}
}
