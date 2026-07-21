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

        .auth-checkbox-row {
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
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
                margin:30px;
                gap: 10px;
            }
        }
    </style>

    <div class="auth-wrapper">
        <div class="auth-left">
            <div class="auth-left-inner">
                <span style="font-family:'Inria Serif'; font-size:35px; font-style:italic; font-weight:500; line-height:35px;">
                    {{ __('auth.login') }}<br/><br/>
                </span>
                <span>
                    {{ __('auth.already_registered_msg') }}
                </span>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-form-wrapper">
                <form method="POST" action="{{ locale_route('login') }}">
                    @csrf

                    <div class="auth-info">
                        {{ __('auth.login') }}
                    </div>

                    <div class="row g-3">
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
                                <div class="auth-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top:25px;">
                        <div class="col-md-12 form-group">
                            <input
                                type="password"
                                name="password"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.password') }}"
                                required
                            >
                        </div>
                    </div>

                    <div class="auth-checkbox-row">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label for="remember">
                            {{ __('auth.remember_me') }}
                        </label>
                    </div>

                    @include('web.common.form-required-note')

                    <div style="margin-top:35px; display:flex; justify-content:space-between; align-items:center; gap:20px;">
                        <a href="{{ locale_route('password.request') }}" style="text-decoration:underline;">
                            {{ __('auth.forgot_password_link') }}
                        </a>

                        <button type="submit" class="morButton morButton2" style="width:150px; background:#fff; border:none;">
                            <span class="morButtonTxt">{{ __('auth.login_button') }}</span>
                        </button>
                    </div>

                    <div class="auth-links">
                        <span>{{ __('auth.not_registered_yet') }}</span><br>
                        <a href="{{ locale_route('register') }}">
                            {{ __('auth.register_now_link') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection