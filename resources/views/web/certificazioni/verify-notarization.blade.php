@extends('web.layout')

@section('content')
<style>
    .verify-wrap {
        margin: var(--generalMargin);
        padding: 60px 0;
        max-width: 820px;
    }
    .verify-title {
        font-family: 'Inria Serif', serif;
        font-size: 34px;
        font-style: italic;
        margin-bottom: 10px;
    }
    .verify-lead {
        color: var(--blackLight, #555);
        margin-bottom: 28px;
        line-height: 1.5;
    }
    .verify-form label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .verify-form input[type=text] {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid rgba(0,0,0,.15);
        background: #fff;
        font-family: 'Fira Mono', monospace;
        font-size: 13px;
    }
    .verify-actions {
        margin-top: 16px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .verify-result {
        margin-top: 28px;
        padding: 20px;
        background: rgba(0,0,0,.03);
        border-left: 3px solid var(--black, #222);
    }
    .verify-result.ok { border-left-color: #2e7d32; }
    .verify-result.ko { border-left-color: #b00020; }
    .verify-meta {
        font-size: 14px;
        line-height: 1.6;
        word-break: break-all;
    }
</style>

<div class="verify-wrap">
    <h1 class="verify-title">{{ __('certifications.verify.title') }}</h1>
    <p class="verify-lead">{{ __('certifications.verify.lead') }}</p>

    <form class="verify-form" method="get" action="{{ url('/h/verifica.html') }}">
        <label for="hash">{{ __('certifications.verify.hash_label') }}</label>
        <input type="text" id="hash" name="hash" value="{{ $hash }}" placeholder="0x…" autocomplete="off">
        <div class="verify-actions">
            <button type="submit" class="morButton morButton2">
                <span class="morButtonTxt">{{ __('certifications.verify.submit') }}</span>
            </button>
            <a class="morButton" href="{{ $yliumVerifyUrl }}" target="_blank" rel="noopener">
                <span class="morButtonTxt">{{ __('certifications.verify.open_ylium') }}</span>
            </a>
        </div>
    </form>

    @if($hash !== '')
        @if($certificate)
            <div class="verify-result ok">
                <p><strong>{{ __('certifications.verify.found') }}</strong></p>
                <div class="verify-meta">
                    <div>{{ __('certifications.verify.access_code') }}: {{ $certificate->access_code }}</div>
                    @if($certificate->displaySku())
                        <div>{{ __('certifications.product_certificate.sku_label') }}: {{ $certificate->displaySku() }}</div>
                    @endif
                    @if($certificate->displayName())
                        <div>{{ $certificate->displayName() }}</div>
                    @endif
                    <div>{{ __('certifications.verify.document_hash') }}: {{ $certificate->notarizationHashPrefixed() }}</div>
                    @if($certificate->isNotarized())
                        <div>{{ __('certifications.verify.notarized_at') }}: {{ $certificate->notarized_at?->format('d/m/Y H:i') }}</div>
                        <div>
                            Tx:
                            @if($certificate->polygonscanUrl())
                                <a href="{{ $certificate->polygonscanUrl() }}" target="_blank" rel="noopener">{{ $certificate->notarization_tx_hash }}</a>
                            @else
                                {{ $certificate->notarization_tx_hash }}
                            @endif
                        </div>
                    @else
                        <div>{{ __('certifications.verify.pdf_ready_not_notarized') }}</div>
                    @endif
                </div>
                <div class="verify-actions">
                    <a class="morButton morButton2" href="{{ $certificate->publicUrl() }}">
                        <span class="morButtonTxt">{{ __('certifications.verify.open_certificate') }}</span>
                    </a>
                    @if($certificate->pdfUrl())
                        <a class="morButton" href="{{ route('product_certificate.pdf', ['code' => $certificate->access_code]) }}" target="_blank" rel="noopener">
                            <span class="morButtonTxt">{{ __('certifications.verify.download_pdf') }}</span>
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="verify-result ko">
                <p><strong>{{ __('certifications.verify.not_found') }}</strong></p>
                <p class="verify-meta">{{ __('certifications.verify.not_found_hint') }}</p>
            </div>
        @endif
    @endif
</div>
@endsection
