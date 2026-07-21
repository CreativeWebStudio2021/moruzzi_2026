@extends('web.layout')

@section('content')
    <style>
        .register-wrapper {
            margin: var(--generalMargin);
            display: flex;
            gap: 40px;
            padding-top: 60px;
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
        }

        .register-form-wrapper {
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

        .register-checkbox-row {
            margin-top: 25px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
        }

        .register-checkbox-row input[type="checkbox"] {
            margin-top: 3px;
        }

        .register-errors {
            margin-top: 15px;
            color: #dc2626;
            font-size: 14px;
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
                margin:30px;
                gap: 10px;
            }
        }
    </style>

    <div class="register-wrapper">
        <div class="register-left">
            <div class="register-left-inner">
                <span style="font-family:'Inria Serif'; font-size:35px; font-style:italic; font-weight:500; line-height:35px;">
                    {{ __('auth.register') }}<br/><br/>
                </span>
                <span>
                    {{ __('auth.not_registered_yet') }}
                </span> 
            </div>
        </div>

        <div class="register-right">
            <div class="register-form-wrapper">
                <form method="POST" action="{{ locale_route('register') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="nome"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.first_name') }}"
                                value="{{ old('nome') }}"
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
                                value="{{ old('cognome') }}"
                                required
                            >
                            @error('cognome')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top:25px;">
                        <div class="col-md-12 form-group">
                            <input
                                type="email"
                                name="email"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.email') }}"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top:25px;">
                        <div class="col-md-6 form-group">
                            <input
                                type="password"
                                name="password"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.password') }}"
                                required
                            >
                            @error('password')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                            <div style="margin-top:5px; font-size:11px; color:var(--blackLight);">
                                {{ __('auth.password_hint') }}
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <input
                                type="password"
                                name="password_confirmation"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.confirm_password') }}"
                                required
                            >
                        </div>
                    </div>

                    <div class="register-checkbox-row">
                        <input
                            type="checkbox"
                            id="newsletter"
                            name="newsletter"
                            value="1"
                            {{ old('newsletter', true) ? 'checked' : '' }}
                        >
                        <label for="newsletter">
                            {{ __('auth.newsletter_label') }}
                        </label>
                    </div>

                    <div class="register-checkbox-row">
                        <input
                            type="checkbox"
                            id="privacy"
                            name="privacy"
                            value="1"
                            {{ old('privacy') ? 'checked' : '' }}
                            required
                        >
                        <label for="privacy">
                            {!! __('auth.privacy_text', ['url' => locale_route('legal.privacy')]) !!}<br>
                            <b>{{ __('auth.privacy_label') }}</b>
                        </label>
                    </div>
                    @error('privacy')
                        <div class="register-errors">{{ $message }}</div>
                    @enderror

                    @include('web.common.form-required-note')

                    <div style="margin-top:35px; display:flex; justify-content:flex-end;">
                        <button type="submit" class="morButton morButton2" style="width:160px; border:none;">
                            <span class="morButtonTxt">{{ __('auth.register_button') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection