@extends('web.layout')

@section('content')
    <style>
        .account-wrapper {
            margin: var(--generalMargin);
            display: flex;
            gap: 40px;
            padding-top: 60px;
            padding-bottom: 60px;
        }
        .account-left {
            flex: 1;
            display: flex;
            background: url( {{ moruzzi_asset('images/stime_prezzi.png') }} ) no-repeat center center;
            background-size: cover;
            color: #fff;
        }
        .account-left-inner {
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
        .account-right {
            flex: 1;
        }
        .account-form-wrapper {
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
        .account-errors {
            margin-top: 8px;
            color: #dc2626;
            font-size: 13px;
        }
        @media (max-width: 900px) {
            .account-wrapper {
                flex-direction: column;
                margin: 20px;
            }
        }
        @media (max-width: 500px) {
            .account-left-inner {
                width: calc(100% - 60px);
                padding: 20px 10px;
                margin: 30px;
                gap: 10px;
            }
        }
    </style>

    <div class="account-wrapper">
        <div class="account-left">
            <div class="account-left-inner">
                <span style="font-family:'Inria Serif'; font-size:32px; font-style:italic; font-weight:500; line-height:32px;">
                    {{ __('account.change_password') }}
                </span>
                <span style="font-size:14px;">
                    {{ __('auth.password_hint') }}
                </span>
            </div>
        </div>

        <div class="account-right">
            <div class="account-form-wrapper">
                <form method="POST" action="{{ locale_route('account.password.update') }}">
                    @csrf

                    <div style="margin-bottom:25px;">
                        <label for="current_password" style="display:block; font-size:14px; margin-bottom:4px;">
                            {{ __('auth.password') }} *
                        </label>
                        <input
                            id="current_password"
                            type="password"
                            name="current_password"
                            class="inputFormText"
                            required
                        >
                        @error('current_password')
                            <div class="account-errors">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom:25px;">
                        <label for="password" style="display:block; font-size:14px; margin-bottom:4px;">
                            {{ __('auth.new_password') }} *
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="inputFormText"
                            required
                        >
                        @error('password')
                            <div class="account-errors">{{ $message }}</div>
                        @enderror
                        <div style="margin-top:5px; font-size:11px; color:var(--blackLight);">
                            {{ __('auth.password_hint') }}
                        </div>
                    </div>

                    <div style="margin-bottom:30px;">
                        <label for="password_confirmation" style="display:block; font-size:14px; margin-bottom:4px;">
                            {{ __('auth.confirm_password') }} *
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="inputFormText"
                            required
                        >
                    </div>

                    <div style="display:flex; justify-content:flex-end;">
                        <button type="submit" class="morButton morButton2" style="width:200px; background:#fff; border:none;">
                            <span class="morButtonTxt">{{ __('account.change_password') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

