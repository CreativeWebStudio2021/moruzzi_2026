<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductAvailabilityService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $newArrivals = Cache::remember('home_category_new_arrivals', now()->addHours(6), function () {
            return Category::where('entity_id', 1436)->first();
        });

        $latestProducts = $this->homeProducts(1436);
        $featuredProducts = $this->homeProducts(1435);
        $offertProducts = $this->homeProducts(969);

        app(ProductAvailabilityService::class)->hydrateCollection(
            $latestProducts->concat($featuredProducts)->concat($offertProducts)
        );

        $tags = Cache::remember(
            'categories_structure',
            now()->addHours(12),
            function () {
                return Category::where('level', 2)
                    ->where('parent_id', 2)
                    ->whereNotIn('entity_id', [1436, 969, 1435])
                    ->orderBy('position')
                    ->with('childrenRecursive')
                    ->get();
            }
        );

        return view('web.index', compact('newArrivals', 'latestProducts', 'featuredProducts', 'offertProducts', 'tags'));
    }

    private function homeProducts(int $categoryId)
    {
        return Cache::remember(
            'home_products_' . $categoryId,
            now()->addMinutes(15),
            function () use ($categoryId) {
                return Product::whereIn('visibility', [1, 4])
                    ->where('qty', '>', 0)
                    ->where('categorie', 'LIKE', '%@' . $categoryId . '@%')
                    ->orderByDesc('entity_id')
                    ->take(10)
                    ->get();
            }
        );
    }
}
