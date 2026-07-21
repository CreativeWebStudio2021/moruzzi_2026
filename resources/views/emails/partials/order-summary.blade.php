@php
    $subtotal = $order->items->sum(fn ($item) => (float) $item->prezzo_f);
    $orderDate = $order->data_ord
        ? \Illuminate\Support\Carbon::parse($order->data_ord)->format('d/m/Y')
        : '';
@endphp

<div class="order-info">
    <p><strong>{{ __('orders.number') }}</strong> #{{ $order->id }}</p>
    @if ($orderDate)
        <p><strong>{{ __('orders.date') }}</strong> {{ $orderDate }}</p>
    @endif
    <p><strong>{{ __('orders.payment_method') }}</strong> {{ ucfirst($order->pagamento) }}</p>
    <p><strong>{{ __('orders.shipping_method') }}</strong> {{ $order->spedizione }}</p>
</div>

<table class="order-items-table">
    <thead>
        <tr>
            <th class="order-item-thumb" style="width:56px;"></th>
            <th style="text-align:left;">{{ __('orders.product') }}</th>
            <th class="order-item-qty">{{ __('orders.qty') }}</th>
            <th class="order-item-price">{{ __('orders.price') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->items as $item)
            @php
                $productImage = $item->product->image ?? null;
                $thumbUrl = $productImage ? product_image_url($productImage, 'thumb') : '';
                $itemAlt = image_alt($item->nome);
            @endphp
            <tr>
                <td class="order-item-thumb">
                    @if ($thumbUrl !== '')
                        <img
                            src="{{ $thumbUrl }}"
                            alt="{{ $itemAlt }}"
                            width="48"
                            style="width:48px;height:auto;display:block;margin:0 auto;border-radius:4px;border:0;"
                        >
                    @endif
                </td>
                <td>
                    {{ \Illuminate\Support\Str::limit($item->nome, 80) }}
                    @if ($item->cod_prod)
                        <br><span style="font-size:12px; color:#666;">SKU: {{ $item->cod_prod }}</span>
                    @endif
                </td>
                <td class="order-item-qty">{{ $item->quantita }}</td>
                <td class="order-item-price">{{ format_price($item->prezzo, $locale ?? null) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="order-info">
    <p style="display:flex; justify-content:space-between; margin:4px 0;">
        <span>{{ __('orders.subtotal') }}</span>
        <span>{{ format_price($subtotal, $locale ?? null) }}</span>
    </p>
    <p style="display:flex; justify-content:space-between; margin:4px 0;">
        <span>{{ __('orders.shipping_cost') }}</span>
        <span>{{ format_price($order->spese, $locale ?? null) }}</span>
    </p>
    <p style="display:flex; justify-content:space-between; margin:8px 0 0; font-weight:bold;">
        <span>{{ __('orders.total') }}</span>
        <span>{{ format_price($order->totale, $locale ?? null) }}</span>
    </p>
</div>

<div class="order-info">
    <p><strong>{{ __('orders.shipping_address') }}</strong></p>
    <p>
        {{ $order->nome_spe }} {{ $order->cognome_spe }}<br>
        {{ $order->indirizzo_spe }}<br>
        {{ $order->cap_spe }} {{ $order->citta_spe }}@if($order->prov_spe) ({{ $order->prov_spe }})@endif<br>
        {{ $order->paese_spe }}
        @if ($order->telefono_spe)
            <br>{{ __('checkout.phone') }}: {{ $order->telefono_spe }}
        @endif
    </p>
    @if ($order->note_spe)
        <p><strong>{{ __('orders.additional_info') }}</strong><br>{!! nl2br(e($order->note_spe)) !!}</p>
    @endif
</div>
