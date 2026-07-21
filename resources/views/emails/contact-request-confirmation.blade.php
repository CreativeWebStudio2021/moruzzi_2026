@extends('emails.layout')

@section('preinfo')
@stop

@section('image')
@stop

@section('content')
<div class="content" style="padding-top:0">
    <h1>{{ __('contact.user_subject') }}</h1>
    <div class="order-info">
        <p>{{ __('contact.thankyou_text') }}</p>
        <p><strong>{{ __('contact.name') }}:</strong> {{ $data['nome'] }}</p>
        <p><strong>{{ __('contact.surname') }}:</strong> {{ $data['cognome'] }}</p>
        <p><strong>{{ __('contact.email') }}:</strong> {{ $data['email'] }}</p>
        @if(!empty($data['telefono']))
            <p><strong>{{ __('contact.phone') }}:</strong> {{ $data['telefono'] }}</p>
        @endif
        <p><strong>{{ __('contact.message') }}:</strong></p>
        <p>{!! nl2br(e($data['messaggio'])) !!}</p>
    </div>
</div>
@stop
