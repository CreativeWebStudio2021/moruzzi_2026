@extends('web.layout')

@section('content')
    <style>
        .account-wrapper {
            margin: var(--generalMargin);
            display: flex;
            gap: 40px;
            padding-top: 60px;
            padding-bottom: 60px;
        }
        .account-left {
            flex: 1;
            display: flex;
            background: url( {{ moruzzi_asset('images/stime_prezzi.png') }} ) no-repeat center center;
            background-size: cover;
            color: #fff;
        }
        .account-left-inner {
            width: calc(75% - 80px);
            align-self: flex-start;
            display: flex;
            background:var(--background);
            color:var(--black);
            flex-direction: column;
            padding: 40px 30px;
            margin:50px;
            gap: 20px;
        }
        .account-right { flex: 2; }
        .account-orders-wrapper { padding: 15px 0 50px; }
        @media (max-width: 900px) {
            .account-wrapper { flex-direction: column; margin: 20px; }
        }
        @media (max-width: 500px) {
            .account-left-inner {
                width: calc(100% - 60px);
                padding: 20px 10px;
                margin:30px;
                gap: 10px;
            }
        }
    </style>

    <div class="account-wrapper">
        <div class="account-left">
            <div class="account-left-inner">
                <span style="font-family:'Inria Serif'; font-size:35px; font-style:italic; font-weight:500; line-height:35px;">
                    {{ __('account.my_orders') }}
                </span>
                <span style="font-size:14px;">
                    {{ __('account.welcome') }}
                    <b>{{ auth()->user()->nome ?? auth()->user()->name }}</b>
                </span>
            </div>
        </div>

        <div class="account-right">
            <div class="account-orders-wrapper">
        <div style="margin-bottom:20px; display:flex; flex-wrap:wrap; gap:10px;">
            @php
                $currentStatus = $status ?? 'in_corso';
            @endphp
            <a href="{{ locale_route('account.orders', ['status' => 'in_corso']) }}"
               class="morButton morButton2"
               style="width:auto; padding:0 15px; background:{{ $currentStatus==='in_corso' ? 'var(--red)' : '#E1E1E1' }}; color:{{ $currentStatus==='in_corso' ? '#fff' : '#000' }};">
                <span class="morButtonTxt">{{ __('orders.in_progress') }}</span>
            </a>
            <a href="{{ locale_route('account.orders', ['status' => 'evasi']) }}"
               class="morButton morButton2"
               style="width:auto; padding:0 15px; background:{{ $currentStatus==='evasi' ? 'var(--red)' : '#E1E1E1' }}; color:{{ $currentStatus==='evasi' ? '#fff' : '#000' }};">
                <span class="morButtonTxt">{{ __('orders.completed') }}</span>
            </a>
            <a href="{{ locale_route('account.orders', ['status' => 'annullati']) }}"
               class="morButton morButton2"
               style="width:auto; padding:0 15px; background:{{ $currentStatus==='annullati' ? 'var(--red)' : '#E1E1E1' }}; color:{{ $currentStatus==='annullati' ? '#fff' : '#000' }};">
                <span class="morButtonTxt">{{ __('orders.canceled') }}</span>
            </a>
            <a href="{{ locale_route('account.orders', ['status' => 'tutti']) }}"
               class="morButton morButton2"
               style="width:auto; padding:0 15px; background:{{ $currentStatus==='tutti' ? 'var(--red)' : '#E1E1E1' }}; color:{{ $currentStatus==='tutti' ? '#fff' : '#000' }};">
                <span class="morButtonTxt">{{ __('orders.all') }}</span>
            </a>
        </div>

        @if ($orders->isEmpty())
            <p>{{ __('orders.none') }}</p>
        @else
            <style>
                .orders-table { width:100%; }
                .orders-table th,
                .orders-table td { padding:14px 22px; vertical-align:middle; }
                .orders-table thead th { text-align:left; }
                .orders-table tbody tr:nth-child(odd)  { background:#fbfbfb; }
                .orders-table tbody tr:nth-child(even) { background:#eef0f2; }
            </style>
            <div class="table-responsive" style="background:#fff; padding:10px;">
                <table class="table orders-table">
                    <thead>
                        <tr>
                            <th style="white-space:nowrap;">{{ __('orders.date') }}</th>
                            <th style="white-space:nowrap;">{{ __('orders.number') }}</th>
                            <th style="white-space:nowrap;">{{ __('orders.total') }}</th>
                            <th style="width:100%;">{{ __('orders.shipped_to') }}</th>
                            <th style="white-space:nowrap;">{{ __('orders.status') }}</th>
                            <th style="text-align:right;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $date = $order->data_ord ? \Carbon\Carbon::parse($order->data_ord)->format('d-m-Y') : '';
                                $statusLabel = $order->status;
                                $statusColor = '#f9864d'; // in corso
                                if (in_array($order->status, ['spedito','complete','closed'])) {
                                    $statusColor = '#7b9e1e'; // evaso
                                } elseif (in_array($order->status, ['annullato','canceled'])) {
                                    $statusColor = 'red'; // annullato
                                }
                            @endphp
                            <tr>
                                <td style="white-space:nowrap;">{{ $date }}</td>
                                <td style="white-space:nowrap;">#{{ $order->id }}</td>
                                <td style="white-space:nowrap;">{{ format_price($order->totale) }}</td>
                                <td>{{ ucfirst($order->cognome_spe).' '.ucfirst($order->nome_spe) }}</td>
                                <td style="white-space:nowrap;"><span style="color:{{ $statusColor }};">{{ $statusLabel }}</span></td>
                                <td style="text-align:right; white-space:nowrap;">
                                    <a href="{{ locale_route('account.orders.show', $order) }}" class="btn btn-sm btn-outline-dark">
                                        {{ __('orders.view_detail') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
            </div>
        </div>
    </div>
@endsection

