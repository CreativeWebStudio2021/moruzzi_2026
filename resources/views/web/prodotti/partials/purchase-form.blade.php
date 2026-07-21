@php
    $purchaseClass = $purchaseClass ?? 'product-purchase';
    $availableQuantity = $availableQuantity ?? $product->availableQuantity();
    $cartQuantity = $cartQuantity ?? 0;
    $canPurchase = $availableQuantity > 0;
@endphp

<div class="{{ $purchaseClass }}">
    @if($canPurchase)
        <form method="POST" class="sidebar-form" onsubmit="event.preventDefault(); addProductDetailToCart(this);">
            @csrf

            <div class="cart-card-qty">
                <span class="cart-card-qty-label">{{ __('general.quantita') }}:</span>
                <div class="qty-box">
                    <button type="button" class="sidebar-qty-minus" aria-label="-">−</button>
                    <input
                        type="number"
                        name="quantity"
                        class="product-detail-qty"
                        value="1"
                        min="1"
                        max="{{ $availableQuantity }}"
                    >
                    <button type="button" class="sidebar-qty-plus" aria-label="+">+</button>
                </div>
            </div>

            @if($cartQuantity > 0)
                <button type="button" class="morButton morButton2" disabled style="opacity:0.65; cursor:default;">
                    <span class="morButtonTxt">{{ __('catalog.already_in_cart') }}</span>
                </button>
            @else
                <button type="submit" class="morButton morButton2">
                    <span class="morButtonTxt">{{ __('general.aggiungi_al_carrello') }}</span>
                </button>
            @endif
        </form>
    @elseif($cartQuantity > 0)
        <button type="button" class="morButton morButton2" disabled style="opacity:0.65; cursor:default;">
            <span class="morButtonTxt">{{ __('catalog.already_in_cart') }}</span>
        </button>
    @else
        <div class="stock unavailable">
            {{ __('general.non_disponibile') }}
        </div>
    @endif
</div>
