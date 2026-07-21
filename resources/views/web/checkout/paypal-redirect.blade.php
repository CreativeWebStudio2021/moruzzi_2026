@extends('web.layout')

@section('content')
    <div class="generalMargin" style="padding: 60px 0; text-align: center;">
        <h1 style="font-family: 'Inria Serif'; font-style: italic; font-weight: 500; margin-bottom: 16px;">
            {{ __('checkout.paypal_redirect_title') }}
        </h1>
        <p style="margin-bottom: 8px;">
            {{ __('checkout.paypal_redirect_text', ['number' => $order->id]) }}
        </p>
        <p style="margin-bottom: 24px;">
            <strong>{{ __('checkout.paypal_redirect_wait') }}</strong>
        </p>

        @if (!empty($testPayment))
            <p style="margin-bottom: 16px; padding: 12px 16px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; font-size: 14px;">
                {{ __('checkout.paypal_test_payment_notice', ['amount' => number_format((float) config('paypal.test_payment_amount', 0.01), 2, ',', '.')]) }}
            </p>
        @endif

        <p style="font-size: 14px; color: #666;">
            {{ __('checkout.paypal_redirect_manual') }}
        </p>
    </div>

    <form name="paypal_checkout" id="paypal_checkout" action="{{ $action }}" method="post">
        @foreach ($formFields as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
        <noscript>
            <div style="text-align: center; margin: 40px 0;">
                <button type="submit" class="morButton morButton2 morButtonFit">
                    <span class="morButtonTxt">{{ __('checkout.paypal_redirect_button') }}</span>
                </button>
            </div>
        </noscript>
    </form>

    <script>
        window.setTimeout(function () {
            document.getElementById('paypal_checkout').submit();
        }, 2000);
    </script>
@endsection
