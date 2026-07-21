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
        .register-wrapper {
            margin: var(--generalMargin);
            display: flex;
            gap: 40px;
            padding-bottom: 60px;
        }
        .register-left {
            flex: 1;
            display: flex;
            background: url( {{ moruzzi_asset('images/stime_prezzi.png') }} ) no-repeat center center;
            background-size: cover;
            color: #fff;
        }
        .register-left-inner {
            width: calc(75% - 80px);
            align-self: flex-start;
            display: flex;
            background: var(--background);
            color: var(--black);
            flex-direction: column;
            padding: 40px 30px;
            margin: 50px;
            gap: 20px;
        }
        .register-right {
            flex: 1;
            min-width: 0;
        }
        .register-form-wrapper {
            padding: 15px 0 50px;
        }
        @media (max-width: 900px) {
            .register-wrapper {
                flex-direction: column;
                margin: 20px;
            }
        }
        @media (max-width: 500px) {
            .register-left-inner {
                width: calc(100% - 60px);
                padding: 20px 10px;
                margin: 30px;
                gap: 10px;
            }
        }
    </style>

    <div class="generalMargin" style="padding-top: 20px;">
        <div class="checkout-steps">
            <span class="step">{{ __('checkout.step_shipping') }}</span>
            <span class="step">{{ __('checkout.step_review') }}</span>
            <span class="step active">{{ __('checkout.step_result') }}</span>
        </div>
    </div>

    <div class="register-wrapper">
        <div class="register-left">
            <div class="register-left-inner">
                <span style="font-family:'Inria Serif'; font-size:35px; font-style:italic; font-weight:500; line-height:35px;">
                    {{ __('checkout.thankyou_title') }}
                </span>
                <span style="font-size: 14px;">
                    {{ __('checkout.thankyou_subtitle', ['number' => $order->id]) }}
                </span>
            </div>
        </div>

        <div class="register-right">
            <div class="register-form-wrapper">
                <p style="margin-top: 0;">
                    @if ($order->pagamento === 'paypal' && $order->status === 'pagato')
                        {!! __('checkout.thankyou_paypal_paid', ['number' => $order->id]) !!}
                    @elseif ($order->pagamento === 'paypal')
                        {!! __('checkout.thankyou_paypal_pending', ['number' => $order->id]) !!}
                    @elseif ($order->pagamento === 'bonifico')
                        {!! __('checkout.thankyou_bank_transfer', ['number' => $order->id]) !!}
                    @else
                        {!! __('checkout.thankyou_text', ['number' => $order->id]) !!}
                    @endif
                </p>

                <div style="margin-top: 24px;">
                    <a href="{{ locale_route('home') }}" class="morButton morButton2 morButtonFit" style="border:none;">
                        <span class="morButtonTxt">{{ __('checkout.back_to_shop') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
