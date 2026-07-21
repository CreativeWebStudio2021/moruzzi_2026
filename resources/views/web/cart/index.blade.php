@extends('web.layout')

@section('content')
<section class="cart-section section-big-py-space b-g-light">
    <div class="generalMargin" style="margin-top:50px;">

        <div style="font-size:50px; font-style:italic; color:var(--red); line-height:40px;">
            {{ __('cart.title') }}
        </div>

        <p style="margin-top:20px;">
            {{ __('cart.intro') }}
        </p>

        @if(!$cart || $items->isEmpty())
            <div style="padding:20px; text-align:center; font-size:1.1em;">
                {{ __('cart.empty') }}
            </div>
        @else
            {{-- Lista prodotti come card --}}
            <div class="cart-cards">
                @foreach($items as $item)
                    @if($item->product)
                        @php
                            $product    = $item->product;
                            $unitWeight = (float) ($product->weight ?? 0);
                            $lineWeight = $unitWeight * $item->quantity;
                            $unitPrice  = $item->price_snapshot;
                            $linePrice  = $unitPrice * $item->quantity;
                        @endphp

                        <div class="cart-card">
                            <div class="cart-card-main">
                                <div class="cart-card-image">
                                    <a href="{{ $product->url }}">
                                        <img src="{{ product_image_url($product->image, 'thumb') }}"
                                             alt="{{ image_alt($product->name) }}">
                                    </a>
                                </div>

                                <div class="cart-card-body">
                                    <div class="cart-card-header">
                                        <div>
                                            <div class="cart-card-sku">Cod. {{ $product->sku }}</div>
                                            <a href="{{ $product->url }}" class="cart-card-title">
                                                {{ $product->name }}
                                            </a>
                                        </div>

                                        <form method="POST"
                                              action="{{ locale_route('cart.remove') }}"
                                              class="cart-item-remove-form">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <button type="submit" class="cart-remove-btn" aria-label="{{ __('cart.remove') }}">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="cart-card-meta">
                                        <div><strong>{{ __('cart.weight') }}:</strong> {{ locale_number_format($unitWeight, 3) }} kg</div>
                                        <div><strong>{{ __('cart.price') }}:</strong> {{ format_price($unitPrice) }}</div>
                                        <div><strong>{{ __('cart.weight_total') }}:</strong> {{ locale_number_format($lineWeight, 3) }} kg</div>
                                        <div><strong>{{ __('cart.price_total') }}:</strong> {{ format_price($linePrice) }}</div>
                                    </div>

                                    <form method="POST"
                                          action="{{ locale_route('cart.update') }}"
                                          class="cart-update-form"
                                          data-item="{{ $item->id }}">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">

                                        <div class="cart-card-qty">
                                            <span class="cart-card-qty-label">{{ __('cart.quantity') }}:</span>
                                            <div class="qty-box">
                                                <button type="button" class="btn-qty-minus" data-item="{{ $item->id }}">-</button>
                                                <input type="number"
                                                       name="quantity"
                                                       id="qty-{{ $item->id }}"
                                                       min="1"
                                                       value="{{ $item->quantity }}">
                                                <button type="button" class="btn-qty-plus" data-item="{{ $item->id }}">+</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            @php
                $subtotalFormatted = format_price($subtotal);
                $weightFormatted   = locale_number_format($weight, 3);
            @endphp

            {{-- Riepilogo totali --}}
            <div class="cart-summary">
                <div class="cart-summary-row">
                    <span>{{ __('cart.total_weight') }}:</span>
                    <span>{{ $weightFormatted }} kg</span>
                </div>
                <div class="cart-summary-row">
                    <span>{{ __('cart.subtotal') }}:</span>
                    <span>{{ $subtotalFormatted }}</span>
                </div>
            </div>

            {{-- Azioni --}}
            <div class="cart-actions">
                <form method="POST"
                      action="{{ locale_route('cart.clear') }}"
                      class="cart-clear-form">
                    @csrf
                    <button type="submit" class="morButton morButton2" style="margin-right:10px; font-size:18px; background:#333; color:#fff;">
                        <span class="morButtonTxt">{{ __('cart.clear_order') }}</span>
                    </button>
                </form>

                <a href="{{ locale_route('checkout.options') }}" class="morButton morButton2 morButtonFit">
                    <span class="morButtonTxt">{{ __('cart.proceed_checkout') }}</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .cart-cards {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .cart-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.08);
        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        padding: 15px;
    }

    .cart-card-main {
        display: flex;
        flex-direction: row;
        gap: 15px;
    }

    .cart-card-image img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        object-position: center;
    }

    .cart-card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .cart-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
    }

    .cart-card-sku {
        font-size: 12px;
        color: var(--blackLight);
    }

    .cart-card-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--black);
        text-decoration: none;
    }

    .cart-card-title:hover {
        text-decoration: underline;
    }

    .cart-remove-btn {
        background: #333;
        border: none;
        color: #fff;
        padding: 4px 8px;
        cursor: pointer;
    }

    .cart-card-meta {
        font-size: 13px;
        color: var(--blackLight);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 4px 12px;
    }

    .cart-card-qty {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
    }

    .cart-card-qty-label {
        font-size: 13px;
    }

    .qty-box {
        display: inline-flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .qty-box input[type="number"] {
        width: 55px;
        border: none;
        text-align: center;
        font-size: 14px;
        padding: 4px 2px;
    }

    .qty-box button {
        background: #f1f1f1;
        border: none;
        width: 28px;
        height: 28px;
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
    }

    .qty-box button:hover {
        background: #e0e0e0;
    }

    .cart-summary {
        margin-top: 20px;
        max-width: 320px;
        margin-left: auto;
        border: 1px solid #ddd;
        background: #f9f9f9;
        padding: 10px 12px;
        font-size: 14px;
    }

    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
    }

    .cart-actions {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .cart-card-main {
            flex-direction: column;
            align-items: center;
        }

        .cart-card-image img {
            width: 180px;
            height: 180px;
        }

        .cart-card-body {
            width: 100%;
        }

        .cart-card-meta {
            grid-template-columns: 1fr;
        }

        .cart-summary {
            margin-left: 0;
            max-width: 100%;
        }

        .cart-actions {
            flex-direction: column;
            align-items: flex-end;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cart-clear-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            var message = window.cartClearConfirm || 'Clear the entire order?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    document.querySelectorAll('.cart-item-remove-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            var message = window.cartRemoveConfirm || 'Remove this product?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});

document.addEventListener('click', function (e) {
    const plus = e.target.closest('.btn-qty-plus');
    const minus = e.target.closest('.btn-qty-minus');
    if (!plus && !minus) return;

    const btn = plus || minus;
    const itemId = btn.dataset.item;
    if (!itemId) return;

    const form = document.querySelector('.cart-update-form[data-item="' + itemId + '"]');
    if (!form) return;

    const input = document.getElementById('qty-' + itemId);
    if (!input) return;

    let value = parseInt(input.value, 10) || 1;

    if (plus) {
        value++;
        input.value = value;
        form.submit();
        return;
    }

    if (minus) {
        if (value <= 1) {
            const message = window.cartQtyMinConfirm || 'Remove this item from your cart?';
            if (!confirm(message)) return;
            removeCartItem(itemId).then(function () {
                window.location.reload();
            });
            return;
        }
        value--;
        input.value = value;
        form.submit();
    }
});
</script>
@endpush