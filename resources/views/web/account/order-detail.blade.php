@extends('web.layout')

@section('content')
    <div class="generalMargin" style="margin-top:50px;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; margin-bottom:20px;">
            <div style="font-size:50px; font-style:italic; color:var(--red); line-height:40px;">
                {{ __('orders.detail_title', ['id' => $order->id]) }}
            </div>
            <a href="{{ locale_route('account.orders') }}" style="white-space:nowrap; color:var(--red); text-decoration:underline; font-weight:600;">
                {{ __('orders.back_to_list') }}
            </a>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <div class="col-xl-3 col-lg-6" style="margin-bottom:20px;">
                <div style="border:1px solid #ddd; background:#fff;">
                    <div style="background:#111; color:#fff; padding:10px;">
                        {{ __('orders.summary') }}
                    </div>
                    <div style="padding:10px;">
                        <div>{{ __('orders.date') }}: <b>{{ $orderDate }}</b></div>
                        <div>{{ __('orders.payment_method') }}: <b>{{ $order->pagamento }}</b></div>
                        <div>{{ __('orders.shipping_method') }}: <b>{{ $order->spedizione }}</b></div>
                        <div>{{ __('orders.status') }}: <b>{{ $order->status }}</b></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6" style="margin-bottom:20px;">
                <div style="border:1px solid #ddd; background:#fff;">
                    <div style="background:#111; color:#fff; padding:10px;">
                        <b>{{ __('orders.billing_address') }}</b>
                    </div>
                    <div style="padding:10px;">
                        <div><b>{{ ucfirst($order->cognome).' '.ucfirst($order->nome) }}</b></div>
                        <div>{{ ucfirst($order->indirizzo_spe) }}</div>
                        <div>{{ $order->cap_spe }} {{ ucfirst($order->citta_spe) }} ({{ strtoupper($order->prov_spe) }})</div>
                        <div>{{ $order->paese_spe }}</div>
                        <div style="margin-top:8px;">{{ __('checkout.tax_code') }}: <b>{{ strtoupper($order->cod_fiscale) }}</b></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6" style="margin-bottom:20px;">
                <div style="border:1px solid #ddd; background:#fff;">
                    <div style="background:#111; color:#fff; padding:10px;">
                        <b>{{ __('orders.shipping_address') }}</b>
                    </div>
                    <div style="padding:10px;">
                        <div><b>{{ ucfirst($order->cognome_spe).' '.ucfirst($order->nome_spe) }}</b></div>
                        <div>{{ ucfirst($order->indirizzo_spe) }}</div>
                        <div>{{ $order->cap_spe }} {{ ucfirst($order->citta_spe) }} ({{ strtoupper($order->prov_spe) }})</div>
                        <div>{{ $order->paese_spe }}</div>
                        <div style="margin-top:8px;">{{ __('checkout.phone') }}: <b>{{ $order->telefono_spe }}</b></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6" style="margin-bottom:20px;">
                <div style="border:1px solid #ddd; background:#fff;">
                    <div style="background:#111; color:#fff; padding:10px;">
                        <b>{{ __('orders.additional_info') }}</b>
                    </div>
                    <div style="padding:10px;">
                        <div>{{ $order->note_spe }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="background:#fff; border:1px solid #ddd; padding:15px; margin-bottom:20px;">
            <h3 style="margin-bottom:15px;">{{ __('orders.ordered_products') }}</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="text-align:left;">{{ __('orders.product') }}</th>
                            <th style="width:80px; text-align:center;">{{ __('orders.qty') }}</th>
                            <th style="width:120px; text-align:right;">{{ __('orders.price') }}</th>
                            <th style="width:120px; text-align:right;">{{ __('orders.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td style="text-align:left;">{{ $item->nome }}</td>
                                <td style="text-align:center;">{{ $item->quantita }}</td>
                                <td style="text-align:right;">
                                    {{ format_price($item->prezzo) }}
                                </td>
                                <td style="text-align:right;">
                                    {{ format_price($item->prezzo_f) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="max-width:320px; margin-left:auto; margin-top:20px; background:#f9f9f9; border:1px solid #ddd; padding:10px 12px; font-size:14px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                    <span>{{ __('orders.subtotal') }}:</span>
                    <span>{{ format_price($subtotal) }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                    <span>{{ __('orders.shipping_cost') }}:</span>
                    <span>{{ format_price($order->spese) }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:6px; font-weight:bold;">
                    <span>{{ __('orders.total') }}:</span>
                    <span>{{ format_price($order->totale) }}</span>
                </div>
            </div>
        </div>

        <div style="margin-top:10px; text-align:right;">
            <a href="{{ locale_route('account.orders') }}" style="white-space:nowrap; color:var(--red); text-decoration:underline; font-weight:600;">
                {{ __('orders.back_to_list') }}
            </a>
        </div>
    </div>
@endsection

