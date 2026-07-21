@extends('web.layout')

@section('content')
    <style>
        .auth-wrapper {
            margin: var(--generalMargin);
            display: flex;
            gap: 40px;
            padding-top: 60px;
            padding-bottom: 60px;
        }

        .auth-left {
            flex: 1;
            display: flex;
            background: url( {{ moruzzi_asset('images/stime_prezzi.png') }} ) no-repeat center center;
            background-size: cover;
            color: #fff;
        }

        .auth-left-inner {
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

        .auth-right {
            flex: 1;
            min-width: 0;
        }

        .auth-form-wrapper {
            padding: 15px 0 50px;
            max-width: 480px;
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

        .auth-errors {
            margin-top: 10px;
            color: #dc2626;
            font-size: 14px;
        }

        .auth-info {
            margin-bottom: 25px;
            font-size: 15px;
            line-height: 1.5;
        }

        .auth-field {
            margin-bottom: 25px;
        }

        .auth-hint {
            margin-top: 5px;
            font-size: 11px;
            color: var(--blackLight);
        }

        .auth-links {
            margin-top: 25px;
            font-size: 14px;
        }

        .auth-links a {
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .auth-wrapper {
                flex-direction: column;
                margin: 20px;
            }
        }

        @media (max-width: 500px) {
            .auth-left-inner {
                width: calc(100% - 60px);
                padding: 20px 10px;
                margin: 30px;
                gap: 10px;
            }
        }
    </style>

    <div class="auth-wrapper">
        <div class="auth-left">
            <div class="auth-left-inner">
                <span style="font-family:'Inria Serif'; font-size:35px; font-style:italic; font-weight:500; line-height:35px;">
                    {{ __('auth.reset_password') }}
                </span>
                <span style="font-size:14px;">
                    {{ __('auth.password_hint') }}
                </span>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-form-wrapper">
                <form method="POST" action="{{ locale_route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="auth-info">
                        {{ __('auth.reset_password') }}
                    </div>

                    <div class="auth-field">
                        <input
                            type="email"
                            name="email"
                            class="inputFormText"
                            value="{{ old('email', $request->email) }}"
                            placeholder="{{ field_placeholder('auth.email') }}"
                            required
                            autocomplete="username"
                        >
                        @error('email')
                            <div class="auth-errors">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <input
                            type="password"
                            name="password"
                            class="inputFormText"
                            placeholder="{{ field_placeholder('auth.new_password') }}"
                            required
                            autocomplete="new-password"
                        >
                        @error('password')
                            <div class="auth-errors">{{ $message }}</div>
                        @enderror
                        <div class="auth-hint">{{ __('auth.password_hint') }}</div>
                    </div>

                    <div class="auth-field">
                        <input
                            type="password"
                            name="password_confirmation"
                            class="inputFormText"
                            placeholder="{{ field_placeholder('auth.confirm_password') }}"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    @include('web.common.form-required-note')

                    <div style="margin-top:35px; display:flex; justify-content:flex-end;">
                        <button type="submit" class="morButton morButton2" style="width:220px; border:none;">
                            <span class="morButtonTxt">{{ __('auth.save_new_password') }}</span>
                        </button>
                    </div>

                    <div class="auth-links">
                        <a href="{{ locale_route('login') }}">
                            {{ __('auth.login_button') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
