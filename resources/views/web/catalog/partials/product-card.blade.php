@php
    $displayName = $product->name;
    $displaySku = $product->sku ?? '';
    if (!empty($searchKeywords)) {
        $displayName = highlight_search($displayName, $searchKeywords);
        $displaySku = highlight_search($displaySku, $searchKeywords);
    } else {
        $displayName = e($displayName);
        $displaySku = e($displaySku);
    }
    $inCart = in_array($product->entity_id, $cartProductIds ?? [], true);
    $isNew = $product->is_new;
    $available = method_exists($product, 'availableQuantity')
        ? $product->availableQuantity()
        : (int) ($product->qty ?? 0);
    $soldOut = $available <= 0;
@endphp
<div class="catalog-product-col col-xl-4 col-md-4 col-6 col-grid-box">
    <div class="product-box catalog-product-box">
        <div class="catalog-product-imgbox product-imgbox">
            <div class="product-front catalog-product-front">
                <div class="catalog-product-img-wrap">
                    <a href="{{ $product->url }}" title="{{ $product->title }}" class="catalog-product-img-link">
                        <img src="{{ product_image_url($product->image, 'thumb') }}" alt="{{ image_alt($product->title) }}" class="img-fluid catalog-product-img" loading="lazy">
                    </a>
                </div>
                @if($isNew)
                    <div class="catalog-label catalog-label-new">new</div>
                @endif
                @if($soldOut)
                    <div class="catalog-label catalog-label-soldout">{{ __('catalog.sold_out') }}</div>
                @elseif($product->is_on_sale)
                    <div class="catalog-label catalog-label-sale">{{ __('catalog.offer') }}</div>
                @endif
            </div>
            <div class="product-icon catalog-product-icon">
                @if($soldOut)
                    <button type="button" class="catalog-cart-btn in-cart" disabled title="{{ __('catalog.sold_out') }}">
                        <x-icon name="icona-agg-carrello" class="agg-carrello"/>
                    </button>
                @elseif($inCart)
                    <button type="button" class="catalog-cart-btn in-cart" disabled title="{{ __('catalog.already_in_cart') }}">
                        <x-icon name="icona-agg-carrello" class="agg-carrello"/>
                    </button>
                @else
                    <button type="button" class="catalog-cart-btn add-to-cart-btn" data-id="{{ $product->entity_id }}" title="{{ __('catalog.add_to_cart') }}">
                        <x-icon name="icona-agg-carrello" class="agg-carrello"/>
                    </button>
                @endif
            </div>
        </div>
        <div class="product-detail catalog-product-detail">
            <div class="catalog-product-detail-inner">
                <div class="detail-left">
                    <a href="{{ $product->url }}" title="{{ $product->title }}">
                        <h6 class="price-title pt-sans-bold catalog-product-name">
                            {!! $displayName !!}
                        </h6>
                    </a>
                    @if(!empty($product->sku))
                        <div class="catalog-product-sku pt-sans">SKU: {!! $displaySku !!}</div>
                    @endif
                </div>
                <div class="catalog-product-price-block">
                    <div class="catalog-slidePrezzo">
                        <div class="catalog-slidePrezzoFinale">
                            <span class="price pt-sans pt-sans-bold catalog-product-price">{{ $product->formatted_final_price }}</span>
                            @if($soldOut)
                                <button type="button" class="catalog-cart-btn in-cart catalog-cart-btn-inline" disabled title="{{ __('catalog.sold_out') }}">
                                    <x-icon name="icona-agg-carrello" class="agg-carrello"/>
                                </button>
                            @elseif($inCart)
                                <button type="button" class="catalog-cart-btn in-cart catalog-cart-btn-inline" disabled title="{{ __('catalog.already_in_cart') }}">
                                    <x-icon name="icona-agg-carrello" class="agg-carrello"/>
                                </button>
                            @else
                                <button type="button" class="catalog-cart-btn add-to-cart-btn catalog-cart-btn-inline" data-id="{{ $product->entity_id }}" title="{{ __('catalog.add_to_cart') }}">
                                    <x-icon name="icona-agg-carrello" class="agg-carrello"/>
                                </button>
                            @endif
                        </div>
                        @if($product->is_on_sale)
                            <div class="catalog-slidePrezzoBarrato">{{ $product->formatted_original_price }}</div>
                        @endif
                    </div>
                    <a href="{{ $product->url }}" title="{{ $product->title }}" class="catalog-product-link-more">
                        <span class="morButton morButton2 catalog-morButton">
                            <span class="morButtonTxt">{{ __('catalog.discover_more') }}</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
