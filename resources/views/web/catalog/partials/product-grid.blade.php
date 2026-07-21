<div class="product-wrapper-grid product catalog-product-grid">
    <div class="row">
        @foreach($products as $product)
            @include('web.catalog.partials.product-card', [
                'product' => $product,
                'cartProductIds' => $cartProductIds ?? [],
                'searchKeywords' => $searchKeywords ?? [],
            ])
        @endforeach
    </div>
</div>
