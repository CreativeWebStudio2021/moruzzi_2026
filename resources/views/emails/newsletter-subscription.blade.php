@extends('emails.layout')

@section('preinfo')
@stop

@section('image')
<div class="content" style="padding-top:0; padding-bottom:0;">
    <div class="order-confirmation">
        <img src="{{ email_asset('images/conferma-newsletter.jpg') }}" alt="{{ __('emails.newsletter_image_alt') }}">
    </div>
</div>
@stop

@section('content')
<div class="content" style="padding-top:0">
    <div class="order-info">
        <br/><br/>
        <strong>{{ __('emails.newsletter_thanks') }}</strong>
        <br/><br/>
        {{ __('emails.newsletter_subscribed_with') }}<br/> <b>{{ $email }}</b>
        <br/><br/>
    </div>
</div>
@stop
