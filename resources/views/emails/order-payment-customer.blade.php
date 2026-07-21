@extends('emails.layout')

@section('preinfo')
@stop

@section('image')
@stop

@section('content')
<div class="content" style="padding-top:0">
    <h1>{{ __('emails.order_payment_subject', ['number' => $order->id]) }}</h1>

    <p>
        {!! __('emails.order_payment_greeting', [
            'name' => '<b>'.e($order->nome).'</b>',
        ]) !!}
    </p>

    <p>{{ __('emails.order_payment_thanks', ['number' => $order->id]) }}</p>

    @include('emails.partials.order-summary', ['order' => $order, 'locale' => $locale ?? app()->getLocale()])
</div>
@stop
