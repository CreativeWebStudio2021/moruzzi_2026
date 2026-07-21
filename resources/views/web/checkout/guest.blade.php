@extends('web.layout')

@section('content')
    <style>
        .guest-wrapper {
            margin: var(--generalMargin);
            display: flex;
            gap: 40px;
            padding-top: 60px;
            padding-bottom: 60px;
        }
        .guest-left {
            flex: 1;
            display: flex;
            background: url( {{ moruzzi_asset('images/stime_prezzi.png') }} ) no-repeat center center;
            background-size: cover;
        }
        .guest-left-inner {
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
        .guest-right {
            flex: 1;
            min-width: 0;
        }
        .guest-form-wrapper {
            padding: 15px 0 50px;
        }
        .inputFormText {
            width: 100%;
            border: none;
            border-bottom: solid 1px var(--black);
            background: none;
            padding: 8px 2px;
        }
        .inputFormText:focus {
            outline: none;
            box-shadow: none;
        }
        .register-errors {
            margin-top: 8px;
            color: #dc2626;
            font-size: 13px;
        }
        .guest-login-action {
            margin-top: 8px;
            display: flex;
            justify-content: flex-start;
        }
        .guest-login-action .morButton {
            width: auto;
            display: inline-flex;
        }
        @media (max-width: 900px) {
            .guest-wrapper {
                flex-direction: column;
                margin: 20px;
            }
        }
        @media (max-width: 500px) {
            .guest-left-inner {
                width: calc(100% - 60px);
                padding: 20px 10px;
                margin: 30px;
            }
        }
    </style>

    <div class="guest-wrapper">
        <div class="guest-left">
            <div class="guest-left-inner">
                <span style="font-family:'Inria Serif'; font-size:35px; font-style:italic; font-weight:500; line-height:35px;">
                    {{ __('checkout.guest_title') }}
                </span>
                <span>{{ __('checkout.guest_intro') }}</span>
            </div>
        </div>

        <div class="guest-right">
            <div class="guest-form-wrapper">
                <form method="POST" action="{{ locale_route('checkout.guest.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="nome"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.first_name') }}"
                                value="{{ old('nome', $guest['nome'] ?? '') }}"
                                required
                            >
                            @error('nome')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="cognome"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.last_name') }}"
                                value="{{ old('cognome', $guest['cognome'] ?? '') }}"
                                required
                            >
                            @error('cognome')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top: 20px;">
                        <div class="col-md-12 form-group">
                            <input
                                type="email"
                                name="email"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.email') }}"
                                value="{{ old('email', $guest['email'] ?? '') }}"
                                required
                            >
                            @error('email')
                                <div class="register-errors">{{ $message }}</div>
                                <div class="guest-login-action">
                                    <a href="{{ url('/login') }}" class="morButton morButton2 morButtonFit" style="text-decoration:none;">
                                        <span class="morButtonTxt">{{ __('checkout.guest_login_link') }}</span>
                                    </a>
                                </div>
                            @enderror
                        </div>
                    </div>

                    @include('web.common.form-required-note')

                    <div style="margin-top: 35px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;">
                        <a href="{{ locale_route('checkout.options') }}" style="text-decoration: underline;">
                            {{ __('checkout.back_to_options') }}
                        </a>
                        <button type="submit" class="morButton morButton2 morButtonFit" style="border: none;">
                            <span class="morButtonTxt">{{ __('checkout.guest_proceed') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
