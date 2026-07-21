@extends('emails.layout')

@section('preinfo')
@stop

@section('image')
<div class="content" style="padding-top:0; padding-bottom:0;">
    <div class="order-confirmation">
        <img src="{{ email_asset('images/conferma-registrazione.jpg') }}" alt="{{ __('emails.welcome_image_alt') }}">
    </div>
</div>
@stop

@section('content')
<div class="content" style="padding-top:0">
    <div class="order-info">
        <br><br>
        <b>{{ $nome }} {{ $cognome }}</b>,
        <br><br>
        {{ __('emails.welcome_greeting') }}
        <br><br>
        {!! __('emails.welcome_credentials_intro', [
            'account_link' => '<a href="'.e(locale_route('account.dashboard')).'"><b>'.e(__('emails.welcome_my_account')).'</b></a>',
        ]) !!}
        <br><br>
        <b>{{ __('emails.welcome_email_label') }}:</b> {{ $email }}<br>
        <b>{{ __('emails.welcome_password_label') }}:</b> <i>{{ __('emails.welcome_password_hint') }}</i>
        <br><br>
        {!! __('emails.welcome_forgot_password', [
            'link' => '<a href="'.e(locale_route('password.request')).'"><b>'.e(__('emails.welcome_forgot_password_link')).'</b></a>',
        ]) !!}
        <br/><br/><br/>
        {{ __('emails.welcome_account_benefits_intro') }}
        <ul>
            <li>{{ __('emails.welcome_benefit_checkout') }}</li>
            <li>{{ __('emails.welcome_benefit_orders') }}</li>
            <li>{{ __('emails.welcome_benefit_profile') }}</li>
            <li>{{ __('emails.welcome_benefit_history') }}</li>
        </ul>
        <br/><br/>
    </div>
</div>
@stop
