@extends('emails.layout')

@section('preinfo')
@stop

@section('image')
@stop

@section('content')
<div class="content" style="padding-top:0">
    <h1>{{ __('emails.order_confirmation_admin_subject', ['number' => $order->id]) }}</h1>

    <p>
        {!! __('emails.order_confirmation_admin_intro', [
            'name' => '<b>'.e($order->cognome).' '.e($order->nome).'</b>',
            'number' => $order->id,
        ]) !!}
    </p>

    @include('emails.partials.order-summary', ['order' => $order, 'locale' => $locale ?? app()->getLocale()])
</div>
@stop
