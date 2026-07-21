<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use App\Services\GuideCommerceService;
use App\Services\ProductAvailabilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __construct(
        private readonly GuideCommerceService $guideCommerce,
        private readonly CartService $cartService,
    ) {}

    private const SESSION_PER_PAGE = 'catalog_per_page';
    private const SESSION_ORDER = 'catalog_order';
    private const SESSION_DIRECTION = 'catalog_direction';

    private const DEFAULT_PER_PAGE = 48;
    private const DEFAULT_ORDER = 'data';
    private const DEFAULT_DIRECTION = 'desc';

    /**
     * Pagina catalogo: ricerca e/o categoria.
     */
    public function index(Request $request): View
    {
        $categoryId = $request->query('category');
        $searchQuery = trim((string) $request->query('q', ''));
        $category = $categoryId ? Category::where('entity_id', $categoryId)->first() : null;

        $this->syncSessionFromRequest($request);

        $perPage = (int) session(self::SESSION_PER_PAGE, self::DEFAULT_PER_PAGE);
        $orderBy = session(self::SESSION_ORDER, self::DEFAULT_ORDER);
        $direction = session(self::SESSION_DIRECTION, self::DEFAULT_DIRECTION);

        $query = $this->buildProductQuery($categoryId, $searchQuery);
        $total = $query->count();

        $orderColumn = $this->orderColumn($orderBy);
        $products = (clone $query)
            ->orderBy($orderColumn, $direction)
            ->limit($perPage)
            ->get();

        app(ProductAvailabilityService::class)->hydrateCollection($products);

        $breadcrumb = $category ? $this->breadcrumb($category) : [];
        $openCategoryIds = $category ? $this->openCategoryIds($category) : [];
        $sidebarCategories = $this->sidebarCategories();

        $cartProductIds = $this->cartProductIds();
        $guideLinks = $category ? $this->guideCommerce->guideLinksForCategory($category) : [];

        return view('web.catalog.index', [
            'category' => $category,
            'searchQuery' => $searchQuery,
            'products' => $products,
            'total' => $total,
            'perPage' => $perPage,
            'orderBy' => $orderBy,
            'direction' => $direction,
            'breadcrumb' => $breadcrumb,
            'sidebarCategories' => $sidebarCategories,
            'cartProductIds' => $cartProductIds,
            'page' => 1,
            'hasMore' => $total > $perPage,
            'openCategoryIds' => $openCategoryIds,
            'guideLinks' => $guideLinks,
        ]);
    }

    /**
     * Pagina categoria con URL SEO friendly (es. monete/monete-greche.html).
     */
    public function category(Request $request, string $categoryPath): View|RedirectResponse
    {
        $path = $request->path();
        $locale = app()->getLocale();
        $linkColumn = 'link_' . $locale;


        // Se il path inizia con la lingua, la rimuoviamo
        if (str_starts_with($path, $locale . '/')) {
            $path = substr($path, strlen($locale) + 1);
        }

        // Ora $path è solo:
        // monete/monete-greche.html
        
        if (!preg_match('/^(.*)\.html$/', $path, $matches)) {
            abort(404);
        }

        $categoryPath = $matches[1];

        $fullLink = $categoryPath . '.html';

        $category = resolve_category_by_link($fullLink, $locale);
       
        if (!$category) {
            abort(404);
        }

        $canonical = ltrim((string) ($category->{$linkColumn} ?? $category->link_it), '/');
        $shouldRedirectToCanonical = false;

        if (strtolower($canonical) !== strtolower($path)) {
            foreach (category_link_alternates($path) as $alternate) {
                if (strtolower($alternate) === strtolower($canonical)) {
                    $shouldRedirectToCanonical = true;
                    break;
                }
            }
        }

        if ($shouldRedirectToCanonical) {
            $prefix = $locale === 'it' ? '' : $locale.'/';

            return redirect()->to(url($prefix.$canonical), 301);
        }
        
        // Simula richiesta a index() con category impostata
        $request->merge(['category' => $category->entity_id]);

        $this->syncSessionFromRequest($request);

        $categoryId = (string) $category->entity_id;
        $searchQuery = trim((string) $request->query('q', ''));

        $perPage = (int) session(self::SESSION_PER_PAGE, self::DEFAULT_PER_PAGE);
        $orderBy = session(self::SESSION_ORDER, self::DEFAULT_ORDER);
        $direction = session(self::SESSION_DIRECTION, self::DEFAULT_DIRECTION);

        $query = $this->buildProductQuery($categoryId, $searchQuery);
        $total = $query->count();

        $orderColumn = $this->orderColumn($orderBy);
        $products = (clone $query)
            ->orderBy($orderColumn, $direction)
            ->limit($perPage)
            ->get();

        app(ProductAvailabilityService::class)->hydrateCollection($products);

        $breadcrumb = $this->breadcrumb($category);
        $openCategoryIds = $this->openCategoryIds($category);
        $sidebarCategories = $this->sidebarCategories();
        $cartProductIds = $this->cartProductIds();
        $guideLinks = $this->guideCommerce->guideLinksForCategory($category);

        return view('web.catalog.index', [
            'category' => $category,
            'searchQuery' => $searchQuery,
            'products' => $products,
            'total' => $total,
            'perPage' => $perPage,
            'orderBy' => $orderBy,
            'direction' => $direction,
            'breadcrumb' => $breadcrumb,
            'sidebarCategories' => $sidebarCategories,
            'cartProductIds' => $cartProductIds,
            'page' => 1,
            'hasMore' => $total > $perPage,
            'openCategoryIds' => $openCategoryIds,
            'guideLinks' => $guideLinks,
        ]);
    }

    /**
     * AJAX: carica successiva pagina prodotti (infinite scroll).
     */
    public function loadProducts(Request $request)
    {
        $categoryId = $request->input('category');
        $searchQuery = trim((string) $request->input('q', ''));
        $page = max(1, (int) $request->input('page', 1));

        $perPage = (int) session(self::SESSION_PER_PAGE, self::DEFAULT_PER_PAGE);
        $orderBy = session(self::SESSION_ORDER, self::DEFAULT_ORDER);
        $direction = session(self::SESSION_DIRECTION, self::DEFAULT_DIRECTION);

        $query = $this->buildProductQuery($categoryId, $searchQuery);
        $total = $query->count();
        $orderColumn = $this->orderColumn($orderBy);
        $products = (clone $query)
            ->orderBy($orderColumn, $direction)
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        app(ProductAvailabilityService::class)->hydrateCollection($products);

        $cartProductIds = $this->cartProductIds();
        $hasMore = ($page * $perPage) < $total;

        $keywords = $searchQuery !== '' ? preg_split('/\s+/', $searchQuery, -1, PREG_SPLIT_NO_EMPTY) : [];

        $html = view('web.catalog.partials.product-grid', [
            'products' => $products,
            'cartProductIds' => $cartProductIds,
            'searchKeywords' => $keywords,
        ])->render();

        return response()->json([
            'html' => $html,
            'has_more' => $hasMore,
            'page' => $page,
            'shown_until' => min($page * $perPage, $total),
        ]);
    }

    /**
     * AJAX: ricerca live per pannello "cerca un prodotto" in header.
     * La lingua può arrivare dalla route (es. /en/catalogo/search) o dal query param ?locale=
     * così il partial viene sempre renderizzato nella lingua corretta.
     */
    public function liveSearch(Request $request)
    {
        $locale = $request->query('locale');
        $allowedLocales = ['it', 'en', 'es', 'fr', 'de'];
        if ($locale && in_array($locale, $allowedLocales, true)) {
            \Illuminate\Support\Facades\App::setLocale($locale);
        }

        $searchQuery = trim((string) $request->query('q', ''));
        $family = $request->query('family');

        if ($searchQuery === '') {
            return response()->json([
                'html' => '',
                'total' => 0,
            ]);
        }

        $limit = 5;

        // Filtro opzionale per macro-categoria (colonna di destra):
        // usiamo direttamente l'entity_id della categoria di livello 2 (parent_id = 2).
        $categoryId = null;
        if ($family) {
            $categoryId = $this->familyCategoryId($family);
        }

        $query = $this->buildProductQuery(
            $categoryId !== null ? (string) $categoryId : null,
            $searchQuery
        );

        $orderColumn = $this->orderColumn(self::DEFAULT_ORDER);
        $total = $query->count();

        $products = $query
            ->orderBy($orderColumn, self::DEFAULT_DIRECTION)
            ->limit($limit)
            ->get();

        app(ProductAvailabilityService::class)->hydrateCollection($products);

        $cartProductIds = $this->cartProductIds();
        $keywords = preg_split('/\s+/', $searchQuery, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        // Mappa categorie da campo "@id@id@" dei prodotti
        $allCategoryIds = [];
        foreach ($products as $product) {
            $raw = trim((string) $product->categorie, '@');
            if ($raw === '') {
                continue;
            }
            $ids = collect(preg_split('/@+/', $raw, -1, PREG_SPLIT_NO_EMPTY))
                ->map(fn ($v) => (int) $v)
                ->filter()
                ->values()
                ->all();
            $allCategoryIds = array_merge($allCategoryIds, $ids);
        }
        $allCategoryIds = array_values(array_unique($allCategoryIds));

        $categoriesById = [];
        if (!empty($allCategoryIds)) {
            $categoriesById = Category::whereIn('entity_id', $allCategoryIds)
                ->get()
                ->keyBy('entity_id');
        }

        $html = view('web.catalog.partials.search-results', [
            'products' => $products,
            'cartProductIds' => $cartProductIds,
            'searchKeywords' => $keywords,
            'total' => $total,
            'categoriesById' => $categoriesById,
        ])->render();

        return response()->json([
            'html' => $html,
            'total' => $total,
        ]);
    }

    /**
     * AJAX: aggiorna variabile di sessione (per_page, order, direction) e ricarica.
     */
    public function updateSession(Request $request)
    {
        $name = $request->query('name');
        $value = $request->query('value');

        $allowed = [
            self::SESSION_PER_PAGE => [24, 48, 96],
            self::SESSION_ORDER => ['data', 'prezzo', 'nome'],
            self::SESSION_DIRECTION => ['asc', 'desc'],
        ];

        if (isset($allowed[$name])) {
            $valid = in_array($value, $allowed[$name], true)
                || ($name === self::SESSION_PER_PAGE && in_array((int) $value, $allowed[$name], true));
            if ($valid) {
                if ($name === self::SESSION_PER_PAGE) {
                    session([$name => (int) $value]);
                } else {
                    session([$name => $value]);
                }
            }
        }

        return response()->json(['success' => true]);
    }

    private function syncSessionFromRequest(Request $request): void
    {
        if ($request->has('per_page')) {
            $v = (int) $request->query('per_page');
            if (in_array($v, [24, 48, 96], true)) {
                session([self::SESSION_PER_PAGE => $v]);
            }
        }
        if ($request->has('order')) {
            $v = $request->query('order');
            if (in_array($v, ['data', 'prezzo', 'nome'], true)) {
                session([self::SESSION_ORDER => $v]);
            }
        }
        if ($request->has('direction')) {
            $v = strtolower($request->query('direction'));
            if (in_array($v, ['asc', 'desc'], true)) {
                session([self::SESSION_DIRECTION => $v]);
            }
        }
    }

    private function buildProductQuery(?string $categoryId, string $searchQuery)
    {
        $q = Product::query()
            ->whereIn('visibility', [1, 4])
            ->where('qty', '>', 0);

        if ($categoryId !== null && $categoryId !== '') {
            $q->where('categorie', 'LIKE', '%@' . (int) $categoryId . '@%');
        }

        if ($searchQuery !== '') {
            $keywords = preg_split('/\s+/', $searchQuery, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($keywords as $word) {
                $like = '%' . $word . '%';
                $q->where(function ($qb) use ($like) {
                    $qb->where('name', 'LIKE', $like)->orWhere('sku', 'LIKE', $like);
                });
            }
        }

        return $q;
    }

    private function orderColumn(string $orderBy): string
    {
        return match ($orderBy) {
            'prezzo' => 'price',
            'nome' => 'name',
            default => 'entity_id',
        };
    }

    /**
     * Restituisce l'entity_id della macro-categoria (livello 2, parent_id = 2)
     * a partire dalla chiave usata nel pannello di ricerca (monete, medaglie, ...).
     */
    private function familyCategoryId(string $family): ?int
    {
        static $cache = [];

        if (array_key_exists($family, $cache)) {
            return $cache[$family];
        }

        // Mappa chiave -> etichetta italiana della categoria principale
        $labels = [
            'monete'        => 'Monete',
            'medaglie'      => 'Medaglie',
            'banconote'     => 'Banconote',
            'pubblicazioni' => 'Pubblicazioni',
            'antiquariato'  => 'Antiquariato',
        ];

        if (!isset($labels[$family])) {
            $cache[$family] = null;
            return null;
        }

        $nameIt = $labels[$family];

        // Categorie principali: parent_id = 2 o level = 2 (colonna name in mor_categorie_new)
        $id = Category::where(function ($q) {
            $q->where('parent_id', 2)->orWhere('level', 2);
        })
            ->where('name', $nameIt)
            ->value('entity_id');

        $cache[$family] = $id ? (int) $id : null;

        return $cache[$family];
    }

    private function breadcrumb(Category $category): array
    {
        $items = [];
        $current = $category;

        $locale = app()->getLocale();
        $base = app()->getLocale() === 'it' ? '' : app()->getLocale().'/';

        while ($current) {
            // Salta nodi radice non significativi
            $rawName = $current->name;
            $translatedName = $current->translated_name;
            if (!in_array($rawName, ['Root Catalog', 'Default Category'], true)
                && !in_array($translatedName, ['Root Catalog', 'Default Category'], true)) {
                $items[] = [
                    'name' => $translatedName,
                    'url' => $current->entity_id === $category->entity_id
                        ? null
                        : url($base . $current->translated_link),
                ];
            }

            $parentId = $current->parent_id ?? 0;
            $current = $parentId ? Category::where('entity_id', $parentId)->first() : null;
        }

        return array_reverse($items);
    }

    private function sidebarCategories()
    {
        return Cache::remember('catalog_sidebar_categories', now()->addHours(12), function () {
            return Category::where('level', 2)
                ->where('parent_id', 2)
                ->whereNotIn('entity_id', [1436, 969, 1435])
                ->orderBy('position')
                ->with('childrenRecursive')
                ->get();
        });
    }

    /**
     * Ritorna gli ID della categoria corrente e di tutti i suoi antenati.
     */
    private function openCategoryIds(Category $category): array
    {
        $ids = [];
        $current = $category;
        while ($current) {
            $ids[] = $current->entity_id;
            $parentId = $current->parent_id ?? 0;
            $current = $parentId ? Category::where('entity_id', $parentId)->first() : null;
        }

        return $ids;
    }

    private function cartProductIds(): array
    {
        return $this->cartService->currentProductIds();
    }
}
