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
        .checkout-form .inputFormText {
            width: 100%;
            border: none;
            border-bottom: solid 1px var(--black);
            background: none;
            padding: 8px 2px;
        }
        .checkout-form .inputFormText:focus {
            outline: none;
            box-shadow: none;
        }
        .register-errors {
            margin-top: 8px;
            color: #dc2626;
            font-size: 13px;
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
            <span class="step active">{{ __('checkout.step_shipping') }}</span>
            <span class="step">{{ __('checkout.step_review') }}</span>
            <span class="step">{{ __('checkout.step_result') }}</span>
        </div>
    </div>

    <div class="register-wrapper">
        <div class="register-left">
            <div class="register-left-inner">
                <span style="font-family:'Inria Serif'; font-size:35px; font-style:italic; font-weight:500; line-height:35px;">
                    {{ __('checkout.shipping_title') }}
                </span>
                <span style="font-size: 14px;">
                    {{ __('checkout.required_fields_note') }}
                </span>
            </div>
        </div>

        <div class="register-right">
            <div class="register-form-wrapper">
                <form method="POST" action="{{ locale_route('checkout.shipping.store') }}" class="checkout-form">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="cognome"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.last_name') }}"
                                value="{{ old('cognome', $customer->cognome) }}"
                                required
                            >
                            @error('cognome')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="nome"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('auth.first_name') }}"
                                value="{{ old('nome', $customer->nome) }}"
                                required
                            >
                            @error('nome')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top: 20px;">
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="indirizzo"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.address') }}"
                                value="{{ old('indirizzo', $customer->indirizzo) }}"
                                required
                            >
                            @error('indirizzo')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="citta"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.city') }}"
                                value="{{ old('citta', $customer->citta) }}"
                                required
                            >
                            @error('citta')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top: 20px;">
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="provincia"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.province') }}"
                                value="{{ old('provincia', $customer->provincia) }}"
                                required
                            >
                            @error('provincia')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="cap"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.zip') }}"
                                value="{{ old('cap', $customer->cap) }}"
                                required
                            >
                            @error('cap')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top: 20px;">
                        <div class="col-md-12 form-group">
                            <input
                                type="text"
                                name="nazione"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.country') }}"
                                value="{{ old('nazione', $customer->nazione ?: 'Italia') }}"
                                required
                            >
                            @error('nazione')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top: 20px;">
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="cod_fiscale"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.tax_code', false) }}"
                                value="{{ old('cod_fiscale', $customer->cod_fiscale) }}"
                            >
                            @error('cod_fiscale')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="telefono"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.phone') }}"
                                value="{{ old('telefono', $customer->telefono) }}"
                                required
                            >
                            @error('telefono')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top: 20px;">
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="rag_sociale"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.company_name', false) }}"
                                value="{{ old('rag_sociale', $customer->rag_sociale) }}"
                            >
                            @error('rag_sociale')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input
                                type="text"
                                name="partita_iva"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.vat', false) }}"
                                value="{{ old('partita_iva', $customer->partita_iva) }}"
                            >
                            @error('partita_iva')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top: 20px;">
                        <div class="col-md-12 form-group">
                            <input
                                type="text"
                                name="pec_sdu"
                                class="inputFormText"
                                placeholder="{{ field_placeholder('checkout.pec_sdi', false) }}"
                                value="{{ old('pec_sdu', $customer->pec_sdu) }}"
                            >
                            @error('pec_sdu')
                                <div class="register-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <p class="form-required-note" style="margin-top: 16px; font-size: 13px; color: var(--blackLight); line-height: 1.4;">
                        {{ __('checkout.required_fields_note') }}
                    </p>

                    <div style="margin-top: 35px; display: flex; justify-content: flex-end;">
                        <button type="submit" class="morButton morButton2 morButtonFit" style="border: none;">
                            <span class="morButtonTxt">{{ __('checkout.proceed_to_review') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
