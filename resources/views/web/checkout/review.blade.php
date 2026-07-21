@extends('web.layout')

@section('content')
    <style>
        .checkout-steps {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            font-size: 14px;
        }
        .checkout-steps .step {
            padding: 6px 12px;
            border-radius: 12px;
            border: 1px solid var(--blackLight);
        }
        .checkout-steps .step.active {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
        }
        .checkout-subtitle {
            font-size: 16px;
            margin-bottom: 10px;
            font-family: 'Inria Serif', serif;
        }
        .checkout-summary-box {
            background: #f9f9f9;
            padding: 15px;
            font-size: 14px;
        }
        .checkout-radio {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            margin-bottom: 6px;
            font-size: 14px;
        }
        .checkout-totals-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .checkout-total-main {
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 8px;
        }
        .register-errors {
            margin-top: 8px;
            color: #dc2626;
            font-size: 13px;
        }
        .checkout-form .inputFormText {
            width: 100%;
            border: none;
            border-bottom: solid 1px var(--black);
            background: none;
            padding: 8px 2px;
        }
        .checkout-form .inputFormText:focus {
            outline: none;
            box-shadow: none;
        }
        textarea.inputFormText {
            border: 1px solid var(--black);
            padding: 10px;
            min-height: 100px;
        }
        /* Lista prodotti in sola lettura (come carrello) */
        .checkout-review-items .cart-cards {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .checkout-review-items .cart-card {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.08);
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
            padding: 15px;
        }
        .checkout-review-items .cart-card-main {
            display: flex;
            flex-direction: row;
            gap: 15px;
        }
        .checkout-review-items .cart-card-image img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            object-position: center;
        }
        .checkout-review-items .cart-card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .checkout-review-items .cart-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }
        .checkout-review-items .cart-card-sku {
            font-size: 12px;
            color: var(--blackLight);
        }
        .checkout-review-items .cart-card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--black);
            text-decoration: none;
        }
        .checkout-review-items .cart-card-title:hover {
            text-decoration: underline;
        }
        .checkout-review-items .cart-card-meta {
            font-size: 13px;
            color: var(--blackLight);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 4px 12px;
        }
        .checkout-review-items .cart-card-qty-readonly {
            font-size: 13px;
            margin-top: 4px;
        }
        @media (max-width: 768px) {
            .checkout-review-items .cart-card-main {
                flex-direction: column;
                align-items: center;
            }
            .checkout-review-items .cart-card-image img {
                width: 180px;
                height: 180px;
            }
        }
        .checkout-review-form {
            margin-top: 24px;
            padding-bottom: 0;
        }
        .checkout-review-side {
            width: 100%;
        }
        @media (min-width: 992px) {
            .checkout-review-side {
                width: 50%;
                margin-left: 50%;
                box-sizing: border-box;
                padding-right: var(--generalMarginLat, 130px);
            }
        }
        @media (max-width: 1200px) and (min-width: 992px) {
            .checkout-review-side {
                padding-right: 50px;
            }
        }
        @media (max-width: 991px) {
            .checkout-review-side {
                padding-left: var(--generalMarginLat, 20px);
                padding-right: var(--generalMarginLat, 20px);
            }
        }
        .checkout-review-products-wrap {
            margin-top: 28px;
            margin-bottom: 40px;
        }
    </style>

    <section class="checkout-review-section">
    <div style="margin-top:50px; padding-bottom:60px;">

        <div class="checkout-review-side">
            <div class="checkout-steps">
                <span class="step">{{ __('checkout.step_shipping') }}</span>
                <span class="step active">{{ __('checkout.step_review') }}</span>
                <span class="step">{{ __('checkout.step_result') }}</span>
            </div>

            <div style="font-size:50px; font-style:italic; color:var(--red); line-height:40px; margin-top:24px;">
                {{ __('checkout.review_title') }}
            </div>

            <p style="margin-top:20px; margin-bottom:0;">
                {{ __('checkout.shipping_summary') }}, {{ __('checkout.order_summary') }}
            </p>
        </div>

        {{-- Lista prodotti a tutta larghezza --}}
        <div class="generalMargin checkout-review-products-wrap checkout-review-items">
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
                                            </div>
                                            <div class="cart-card-meta">
                                                <div><strong>{{ __('cart.weight') }}:</strong> {{ locale_number_format($unitWeight, 3) }} kg</div>
                                                <div><strong>{{ __('cart.price') }}:</strong> {{ format_price($unitPrice) }}</div>
                                                <div><strong>{{ __('cart.weight_total') }}:</strong> {{ locale_number_format($lineWeight, 3) }} kg</div>
                                                <div><strong>{{ __('cart.price_total') }}:</strong> {{ format_price($linePrice) }}</div>
                                            </div>
                                            <div class="cart-card-qty-readonly">
                                                <strong>{{ __('cart.quantity') }}:</strong> {{ $item->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
        </div>

        {{-- Form e riepilogo: metà destra su desktop --}}
        <div class="checkout-review-side">
        @if ($errors->has('stock'))
                    <div class="checkout-stock-errors" style="margin-bottom: 20px; padding: 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 4px;">
                        <p style="margin: 0 0 8px; font-weight: 600; color: #dc2626;">
                            {{ __('checkout.stock_error_title') }}
                        </p>
                        <ul style="margin: 0; padding-left: 18px; color: #dc2626; font-size: 14px; line-height: 1.5;">
                            @foreach ($errors->get('stock') as $stockMessage)
                                <li>{{ $stockMessage }}</li>
                            @endforeach
                        </ul>
                        <p style="margin: 12px 0 0; font-size: 13px;">
                            <a href="{{ locale_route('cart.index') }}" style="text-decoration: underline;">
                                {{ __('checkout.stock_back_to_cart') }}
                            </a>
                        </p>
                    </div>
        @endif

        <form method="POST" action="{{ locale_route('checkout.confirm') }}" class="checkout-form checkout-review-form">
            @csrf
        <div class="row g-3">
                    <div class="col-lg-4">
                        <h4 class="checkout-subtitle">{{ __('checkout.shipping_summary') }}</h4>
                        <div class="checkout-summary-box">
                            <div><strong>{{ $customer->cognome_sped ?? $customer->cognome }} {{ $customer->nome_sped ?? $customer->nome }}</strong></div>
                            <div>{{ $customer->indirizzo }}</div>
                            <div>{{ $customer->cap }} {{ $customer->citta }} ({{ $customer->provincia }})</div>
                            <div>{{ $customer->nazione }}</div>
                            @if($customer->rag_sociale)
                                <hr>
                                <div><strong>{{ $customer->rag_sociale }}</strong></div>
                                @if($customer->partita_iva)
                                    <div>{{ __('checkout.vat') }}: {{ $customer->partita_iva }}</div>
                                @endif
                                @if($customer->pec_sdu)
                                    <div>{{ __('checkout.pec_sdi') }}: {{ $customer->pec_sdu }}</div>
                                @endif
                            @elseif($customer->cod_fiscale)
                                <hr>
                                <div>{{ __('checkout.tax_code') }}: {{ $customer->cod_fiscale }}</div>
                            @endif
                            <hr>
                            <div>{{ __('checkout.phone') }}: {{ $customer->telefono }}</div>
                            <div>{{ __('auth.email') }}: {{ $customer->email }}</div>
                        </div>

                        <h4 class="checkout-subtitle" style="margin-top:25px;">{{ __('checkout.note_for_order') }}</h4>
                            <textarea
                                name="note"
                                id="note"
                                rows="5"
                                class="inputFormText"
                                placeholder="{{ __('checkout.insert_note') }}"
                            >{{ old('note') }}</textarea>
                            @error('note')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="col-lg-4">
                        <h4 class="checkout-subtitle">{{ __('checkout.shipping_method') }}</h4>
                        <div class="checkout-summary-box">
                            @foreach($shippingMethods as $key => $method)
                                <label class="checkout-radio">
                                    <input
                                        type="radio"
                                        name="shipping_method"
                                        value="{{ $key }}"
                                        {{ old('shipping_method', 'standard') === $key ? 'checked' : '' }}
                                    >
                                    <span>{{ $method['label'] ?? $key }} ({{ format_price($method['cost'] ?? 0) }})</span>
                                </label>
                            @endforeach
                            @error('shipping_method')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>

                        <h4 class="checkout-subtitle" style="margin-top:25px;">{{ __('checkout.payment_method') }}</h4>
                        <div class="checkout-summary-box">
                            @foreach($paymentMethods as $key => $label)
                                <label class="checkout-radio">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="{{ $key }}"
                                        {{ old('payment_method') === $key ? 'checked' : '' }}
                                    >
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                            @error('payment_method')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <h4 class="checkout-subtitle">{{ __('checkout.order_summary') }}</h4>
                        <div class="checkout-summary-box">
                            <div class="checkout-totals-row">
                                <span>{{ __('checkout.subtotal') }}:</span>
                                <span>{{ format_price($subtotal) }}</span>
                            </div>
                            <div class="checkout-totals-row">
                                <span>{{ __('checkout.weight') }}:</span>
                                <span>{{ locale_number_format($weight, 3) }} kg</span>
                            </div>
                            <hr>
                            <div class="checkout-totals-row">
                                <span>{{ __('checkout.shipping_cost_dynamic') }}:</span>
                                <span id="shippingCostPreview">
                                    {{ format_price($shippingMethods['standard']['cost']) }}
                                </span>
                            </div>
                            <div class="checkout-totals-row checkout-total-main">
                                <span>{{ __('checkout.total') }}:</span>
                                <span id="orderTotalPreview">
                                    {{ format_price($subtotal + $shippingMethods['standard']['cost']) }}
                                </span>
                            </div>
                        </div>

                        <div class="checkout-summary-box" style="margin-top:20px;">
                            <label class="checkout-radio">
                                <input
                                    type="checkbox"
                                    name="terms_accepted"
                                    value="1"
                                    {{ old('terms_accepted') ? 'checked' : '' }}
                                >
                                <span>{!! __('checkout.terms_text') !!}</span>
                            </label>
                            @error('terms_accepted')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="margin-top:25px; display:flex; flex-wrap:wrap; gap:10px; justify-content:flex-end;">
                            <a href="{{ locale_route('checkout.shipping') }}" class="morButton morButton2 morButtonFit" style="border:none;">
                                <span class="morButtonTxt">{{ __('checkout.back_to_shipping') }}</span>
                            </a>
                            <button type="submit" class="morButton morButton2 morButtonFit" style="border:none;">
                                <span class="morButtonTxt">{{ __('checkout.place_order') }}</span>
                            </button>
                        </div>
                    </div>
        </div>
        </form>
        </div>
    </div>
    </section>

@push('scripts')
@php
    $moneyLocale = match (app()->getLocale()) {
        'en' => 'en-GB',
        'fr' => 'fr-FR',
        'de' => 'de-DE',
        'es' => 'es-ES',
        default => 'it-IT',
    };
@endphp
<script>
(function() {
    const shippingInputs = document.querySelectorAll('input[name="shipping_method"]');
    const shippingPreview = document.getElementById('shippingCostPreview');
    const totalPreview = document.getElementById('orderTotalPreview');
    const baseSubtotal = {{ json_encode($subtotal) }};
    const shippingMethods = @json($shippingMethods);
    const moneyLocale = @json($moneyLocale);

    function formatMoney(amount) {
        const value = Number(amount) || 0;
        return value.toLocaleString(moneyLocale, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }) + ' €';
    }

    function updateTotals() {
        let method = 'standard';
        if (shippingInputs && shippingInputs.length) {
            shippingInputs.forEach(function (input) {
                if (input.checked) method = input.value;
            });
        }

        const cost = shippingMethods[method]?.cost ?? 0;
        if (shippingPreview) {
            shippingPreview.textContent = formatMoney(cost);
        }
        if (totalPreview) {
            const total = baseSubtotal + (typeof cost === 'number' ? cost : parseFloat(cost) || 0);
            totalPreview.textContent = formatMoney(total);
        }
    }

    if (shippingInputs && shippingInputs.length) {
        shippingInputs.forEach(function (input) {
            input.addEventListener('change', updateTotals);
        });
    }

    updateTotals();
})();
</script>
@endpush
@endsection
