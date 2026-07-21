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
            margin-top: 15px;
            color: #dc2626;
            font-size: 14px;
        }

        .auth-info {
            margin-bottom: 25px;
            font-size: 15px;
            line-height: 1.5;
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
                    {{ __('auth.forgot_password') }}<br/><br/>
                </span>
                <span>
                    {{ __('auth.forgot_password_link') }}
                </span>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-form-wrapper">
                <form method="POST" action="{{ locale_route('password.email') }}">
                    @csrf

                    <div class="auth-info">
                        {{ __('auth.already_registered_msg') }}
                    </div>

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

                    @include('web.common.form-required-note')

                    <div style="margin-top:35px; display:flex; justify-content:flex-end;">
                        <button type="submit" class="morButton morButton2" style="width:220px; border:none;">
                            <span class="morButtonTxt">{{ __('auth.send_reset_link') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection