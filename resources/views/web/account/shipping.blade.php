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
        .account-form-wrapper { padding: 15px 0 50px; }
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
                    {{ __('account.my_shipping_data') }}
                </span>
                <span style="font-size:14px;">
                    {{ __('checkout.shipping_intro') }}
                </span>
            </div>
        </div>

        <div class="account-right">
            <div class="account-form-wrapper">
                <form method="POST" action="{{ locale_route('account.shipping.update') }}" id="shipping-form">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.first_name') }} *</label>
                            <input type="text"
                                   name="nome_sped"
                                   class="inputFormText"
                                   value="{{ old('nome_sped', $customer->nome_sped) }}"
                                   required>
                            @error('nome_sped')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.last_name') }} *</label>
                            <input type="text"
                                   name="cognome_sped"
                                   class="inputFormText"
                                   value="{{ old('cognome_sped', $customer->cognome_sped) }}"
                                   required>
                            @error('cognome_sped')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top:10px;">
                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.address') }} *</label>
                            <input type="text"
                                   name="indirizzo"
                                   class="inputFormText"
                                   value="{{ old('indirizzo', $customer->indirizzo) }}"
                                   required>
                            @error('indirizzo')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.zip') }} *</label>
                            <input type="text"
                                   name="cap"
                                   class="inputFormText"
                                   value="{{ old('cap', $customer->cap) }}"
                                   required>
                            @error('cap')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.city') }} *</label>
                            <input type="text"
                                   name="citta"
                                   class="inputFormText"
                                   value="{{ old('citta', $customer->citta) }}"
                                   required>
                            @error('citta')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top:10px;">
                        <div class="col-md-4 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.province') }} *</label>
                            <input type="text"
                                   name="provincia"
                                   class="inputFormText"
                                   value="{{ old('provincia', $customer->provincia) }}"
                                   required>
                            @error('provincia')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.country') }} *</label>
                            <input type="text"
                                   name="nazione"
                                   class="inputFormText"
                                   value="{{ old('nazione', $customer->nazione ?? 'Italia') }}"
                                   required>
                            @error('nazione')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.phone') }}</label>
                            <input type="text"
                                   name="telefono"
                                   class="inputFormText"
                                   value="{{ old('telefono', $customer->telefono) }}">
                            @error('telefono')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top:10px;">
                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.tax_code') }}</label>
                            <input type="text"
                                   name="cod_fiscale"
                                   class="inputFormText"
                                   value="{{ old('cod_fiscale', $customer->cod_fiscale) }}">
                            @error('cod_fiscale')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.company_name') }}</label>
                            <input type="text"
                                   name="rag_sociale"
                                   class="inputFormText"
                                   value="{{ old('rag_sociale', $customer->rag_sociale) }}">
                            @error('rag_sociale')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3" style="margin-top:10px;">
                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.vat_number') }} ***</label>
                            <input type="text"
                                   name="partita_iva"
                                   class="inputFormText"
                                   value="{{ old('partita_iva', $customer->partita_iva) }}">
                            @error('partita_iva')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label style="font-size:14px; margin-bottom:4px;">{{ __('checkout.sdi_pec') }} ***</label>
                            <input type="text"
                                   name="pec_sdu"
                                   class="inputFormText"
                                   value="{{ old('pec_sdu', $customer->pec_sdu) }}">
                            @error('pec_sdu')
                                <div class="account-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <p class="form-required-note" style="margin-top:15px; font-size:13px; color:var(--blackLight); line-height:1.4;">
                        {{ __('general.required_fields_note') }}
                    </p>
                    <p class="small">{{ __('checkout.company_required_hint') }}</p>

                    <div style="margin-top:20px; display:flex; gap:10px;">
                        <button type="button"
                                class="morButton morButton2"
                                style="background:#fff; border:none;"
                                onclick="copyAccountData()">
                            <span class="morButtonTxt">{{ __('checkout.use_account_data') }}</span>
                        </button>

                        <button type="submit"
                                class="morButton morButton2"
                                style="background:#fff; border:none;">
                            <span class="morButtonTxt">{{ __('checkout.save_shipping') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function copyAccountData() {
            const firstName = @json($customer->nome);
            const lastName  = @json($customer->cognome);
            const form = document.getElementById('shipping-form');
            if (!form) return;
            form.nome_sped.value    = firstName || '';
            form.cognome_sped.value = lastName || '';
        }
    </script>
@endsection

