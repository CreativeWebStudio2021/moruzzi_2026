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
            background:var(--background);
            color:var(--black);
            flex-direction: column;
            padding: 40px 30px;
            margin:50px;
            gap: 20px;
        }
        .account-right { flex: 1; }
        .account-form-wrapper { padding: 15px 0 50px; max-width: 520px; }
        .inputFormText {
            width: 100%;
            border: none;
            border-bottom: solid 1px var(--black);
            background: none;
            padding: 8px 2px;
        }
        .inputFormText:focus { outline: none; box-shadow: none; }
        .account-errors {
            margin-top: 8px;
            color: #dc2626;
            font-size: 13px;
        }
        @media (max-width: 900px) {
            .account-wrapper { flex-direction: column; margin: 20px; }
        }
        @media (max-width: 500px) {
            .account-left-inner {
                width: calc(100% - 60px);
                padding: 20px 10px;
                margin:30px;
                gap: 10px;
            }
        }
    </style>

    <div class="account-wrapper">
        <div class="account-left">
            <div class="account-left-inner">
                <span style="font-family:'Inria Serif'; font-size:35px; font-style:italic; font-weight:500; line-height:35px;">
                    {{ __('account.my_account') }}
                </span>
                <span>
                    {{ __('account.welcome') }}
                    <b>{{ $customer->nome ?? $customer->name }}</b>
                </span>
            </div>
        </div>

        <div class="account-right">
            <div class="account-form-wrapper">
                <form method="POST" action="{{ locale_route('account.dashboard') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">
                                {{ __('auth.first_name') }} *
                            </label>
                            <input type="text"
                                   name="nome"
                                   class="inputFormText"
                                   value="{{ old('nome', $customer->nome) }}"
                                   required>
                            @error('nome')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">
                                {{ __('auth.last_name') }} *
                            </label>
                            <input type="text"
                                   name="cognome"
                                   class="inputFormText"
                                   value="{{ old('cognome', $customer->cognome) }}"
                                   required>
                            @error('cognome')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top:20px;">
                        <label style="display:block; font-size:14px; margin-bottom:4px;">
                            {{ __('auth.email') }} *
                        </label>
                        <input type="email"
                               name="email"
                               class="inputFormText"
                               value="{{ old('email', $customer->email) }}"
                               required>
                        @error('email')
                            <div class="account-errors">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-top:15px; font-size:13px; display:flex; align-items:center; gap:8px;">
                        <input type="checkbox"
                               id="newsletter"
                               name="newsletter"
                               value="1"
                               {{ old('newsletter', $customer->news) == '1' ? 'checked' : '' }}>
                        <label for="newsletter" style="margin:0;">
                            {{ __('auth.newsletter_label') }}
                        </label>
                    </div>

                    <div style="margin-top:25px; display:flex; justify-content:flex-end;">
                        <button type="submit" class="morButton morButton2" style="background:#fff; border:none;">
                            <span class="morButtonTxt">{{ __('account.my_account') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

