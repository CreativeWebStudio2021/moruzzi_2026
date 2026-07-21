@extends('web.layout')

@section('content')
    <style>
        .checkout-options-wrapper {
            margin: var(--generalMargin);
            padding: 50px 0 70px;
        }
        .checkout-options-title {
            font-family: 'Inria Serif';
            font-size: 42px;
            font-style: italic;
            font-weight: 300;
            line-height: 1.1;
            color: var(--red);
            margin-bottom: 16px;
        }
        .checkout-options-intro {
            margin-bottom: 32px;
            font-size: 16px;
            line-height: 1.5;
            max-width: 720px;
        }
        .checkout-options-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .checkout-option-card {
            border: 1px solid rgba(0,0,0,0.1);
            background: #fff;
            padding: 24px;
            text-align: center;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-sizing: border-box;
        }
        .checkout-option-card h2 {
            font-family: 'Inria Serif';
            font-size: 22px;
            font-style: italic;
            font-weight: 600;
            margin: 0 0 16px;
        }
        .checkout-option-card p {
            margin: 0 0 20px;
            color: var(--blackLight);
            font-size: 15px;
            line-height: 1.45;
            flex: 1;
        }
        .checkout-option-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: auto;
        }
        .checkout-option-actions .morButton {
            text-decoration: none;
        }
        @media (min-width: 900px) {
            .checkout-options-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
                align-items: stretch;
            }
        }
        @media (max-width: 899px) {
            .checkout-options-title {
                font-size: 34px;
            }
        }
    </style>

    <div class="checkout-options-wrapper">
        <h1 class="checkout-options-title">{{ __('checkout.options_title') }}</h1>
        <p class="checkout-options-intro">{{ __('checkout.options_intro') }}</p>

        <div class="checkout-options-grid">
        <div class="checkout-option-card">
            <h2>{{ __('checkout.registered_customer') }}</h2>
            <p>{{ __('auth.already_registered_msg') }}</p>
            <div class="checkout-option-actions">
                <a href="{{ url('/login') }}" class="morButton morButton2 morButtonFit">
                    <span class="morButtonTxt">{{ __('auth.login_button') }}</span>
                </a>
            </div>
        </div>

        <div class="checkout-option-card">
            <h2>{{ __('checkout.new_customer') }}</h2>
            <p>{{ __('auth.not_registered_yet') }}</p>
            <div class="checkout-option-actions">
                <a href="{{ locale_route('account.register.page') }}" class="morButton morButton2 morButtonFit">
                    <span class="morButtonTxt">{{ __('auth.register_button') }}</span>
                </a>
            </div>
        </div>

        <div class="checkout-option-card">
            <h2>{{ __('checkout.guest_customer') }}</h2>
            <p>{{ __('checkout.guest_intro') }}</p>
            <div class="checkout-option-actions">
                <a href="{{ locale_route('checkout.guest') }}" class="morButton morButton2 morButtonFit">
                    <span class="morButtonTxt">{{ __('checkout.buy_as_guest') }}</span>
                </a>
            </div>
        </div>
        </div>
    </div>
@endsection
