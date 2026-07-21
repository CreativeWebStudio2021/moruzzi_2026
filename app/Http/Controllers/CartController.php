<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\CartService;
use App\Services\ProductAvailabilityService;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
    ) {}

    /**
     * Pagina carrello.
     */
    public function index()
    {
        $cart = $this->cartService->findForCurrentVisitor();

        $items = $cart?->items ?? collect();

        $subtotal = 0.0;
        $weight   = 0.0;

        foreach ($items as $item) {
            if (!$item->product) {
                continue;
            }

            $linePrice = $item->price_snapshot * $item->quantity;
            $subtotal += $linePrice;

            $productWeight = (float) ($item->product->weight ?? 0);
            $weight += $productWeight * $item->quantity;
        }

        return view('web.cart.index', [
            'cart'     => $cart,
            'items'    => $items,
            'subtotal' => $subtotal,
            'weight'   => $weight,
        ]);
    }

    /**
     * Aggiunge prodotto al carrello
     */
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($data['product_id']);

        $cart = $this->cartService->getOrCreate();

        $item = $cart->items()
            ->where('product_id', $product->entity_id)
            ->first();

        $requestedQty = (int) $data['quantity'];
        $currentInCart = $item ? (int) $item->quantity : 0;

        // Calcolo fresco: carrello e checkout non usano cache/listing batch.
        $maxAddable = app(ProductAvailabilityService::class)->computeForProduct($product);

        if ($maxAddable <= 0 || $requestedQty > $maxAddable) {
            return response()->json([
                'success' => false,
                'count'   => $cart->items()->sum('quantity'),
                'message' => $maxAddable <= 0
                    ? __('cart.no_more_available')
                    : __('cart.only_n_available', ['n' => $maxAddable]),
            ]);
        }

        if ($item) {
            $item->increment('quantity', $requestedQty);
        } else {
            $cart->items()->create([
                'product_id'     => $product->entity_id,
                'quantity'       => $requestedQty,
                'price_snapshot' => $product->final_price,
            ]);
        }

        $this->cartService->touchExpiry($cart);

        app(ProductAvailabilityService::class)->forget($product);

        return response()->json([
            'success' => true,
            'count'   => $cart->items()->sum('quantity'),
            'message' => __('Prodotto inserito nel carrello')
        ]);
    }
	
    /**
     * Aggiorna la quantità di un elemento del carrello.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'item_id'  => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->cartService->getOrCreate();

        $item = $cart->items()->where('id', $data['item_id'])->first();

        if ($item) {
            $product = $item->product;

            if ($product) {
                $newQty = (int) $data['quantity'];

                // Disponibilità complessiva + quantità già presente su questa riga
                $available = app(ProductAvailabilityService::class)->computeForProduct($product) + (int) $item->quantity;

                if ($newQty > $available) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => $available > 0
                                ? __('cart.only_n_available', ['n' => $available])
                                : __('cart.no_more_available'),
                        ]);
                    }

                    return redirect()
                        ->route('cart.index')
                        ->withErrors(['quantity' => $available > 0
                            ? __('cart.only_n_available', ['n' => $available])
                            : __('cart.no_more_available')]);
                }

                $item->update(['quantity' => $newQty]);
                $this->cartService->touchExpiry($cart);
                app(ProductAvailabilityService::class)->forget($product);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->to(locale_route('cart.index'));
    }

    /**
     * Rimuove un elemento dal carrello.
     */
    public function remove(Request $request)
    {
        $data = $request->validate([
            'item_id' => ['required', 'integer'],
        ]);

        $cart = $this->cartService->findForCurrentVisitor();

        if (! $cart) {
            if ($request->expectsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->to(locale_route('cart.index'));
        }

        $item = $cart->items()->where('id', $data['item_id'])->first();

        if ($item) {
            $productId = (int) $item->product_id;
            $item->delete();
            app(ProductAvailabilityService::class)->forget($productId);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->to(locale_route('cart.index'));
    }
    
    /**
     * Svuota l'intero carrello.
     */
    public function clear(Request $request)
    {
        $cart = $this->cartService->findForCurrentVisitor();

        if ($cart) {
            $productIds = $cart->items()->pluck('product_id')->all();
            $cart->items()->delete();
            $cart->delete();
            app(ProductAvailabilityService::class)->forgetMany($productIds);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->to(locale_route('cart.index'));
    }
	
	public function count()
	{
		$cart = $this->cartService->findForCurrentVisitor();

		$count = $cart ? $cart->items()->sum('quantity') : 0;

		return response()->json([
			'count' => $count
		]);
	}
	
	public function mini()
	{
		$cart = $this->cartService->findForCurrentVisitor();

		if (!$cart) {
			return response()->json([
				'items' => [],
				'subtotal' => 0
			]);
		}

		$items = $cart->items->map(function ($item) {
			$imgPath = $item->product->image ?? $item->product->main_image ?? '';
			return [
				'id' => $item->id,
				'product_id' => $item->product_id,
				'title' => $item->product->title ?? $item->product->name ?? '',
				'image' => $imgPath ? product_image_url($imgPath, 'thumb') : '',
				'price' => $item->price_snapshot,
				'quantity' => $item->quantity,
				'total' => $item->price_snapshot * $item->quantity
			];
		});

		return response()->json([
			'items' => $items,
			'subtotal' => $cart->items->sum(fn($i) => $i->price_snapshot * $i->quantity)
		]);
	}


}
