@extends('web.layout')

@section('content')
<style>
    .certificate-wrapper {
        margin: var(--generalMargin);
        display: flex;
        gap: 40px;
        padding-top: 60px;
        padding-bottom: 60px;
    }

    .certificate-left {
        flex: 1;
        display: flex;
        background: url({{ moruzzi_asset('images/stime_prezzi.png') }}) no-repeat center center;
        background-size: cover;
        color: #fff;
        min-height: 420px;
    }

    .certificate-left-inner {
        width: calc(75% - 80px);
        align-self: flex-start;
        display: flex;
        background: var(--background);
        color: var(--black);
        flex-direction: column;
        padding: 40px 30px;
        margin: 50px;
        gap: 16px;
    }

    .certificate-left-title {
        font-family: 'Inria Serif', serif;
        font-size: 35px;
        font-style: italic;
        font-weight: 500;
        line-height: 1.15;
    }

    .certificate-left-code {
        font-family: 'Fira Mono', monospace;
        font-size: 14px;
        color: var(--blackLight, #5f5f5f);
    }

    .certificate-right {
        flex: 1;
        min-width: 0;
    }

    .certificate-content {
        font-size: 17px;
        line-height: 1.7;
        color: var(--blackLight, #333);
    }

    .certificate-body {
        text-align: justify;
        margin-bottom: 28px;
    }

    .certificate-image {
        text-align: center;
        margin: 24px 0 28px;
    }

    .certificate-image img {
        max-width: 100%;
        height: auto;
        border: 1px solid rgba(0,0,0,0.08);
        background: #fff;
    }

    .certificate-actions {
        margin: 24px 0;
    }

    .certificate-actions-primary {
        display: flex;
        width: 100%;
        justify-content: flex-start;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin: 24px 0 16px;
    }

    .certificate-actions-spacer {
        flex: 1 1 auto;
        min-width: 12px;
    }

    .certificate-actions-primary .morButton {
        min-width: 220px;
        text-align: center;
        flex: 0 0 auto;
    }

    .certificate-actions-primary .certificate-btn-verify {
        margin-left: 0;
        background: var(--red, #8b1a1a);
        border-color: var(--red, #8b1a1a);
        color: #fff;
        font-weight: 600;
    }

    .certificate-actions-primary--verify-only {
        justify-content: flex-end;
    }

    .certificate-actions-secondary {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .certificate-copyright {
        margin-top: 28px;
        font-size: 13px;
        color: #666;
        text-align: justify;
    }

    .certificate-meta {
        font-size: 14px;
        color: #666;
        margin-bottom: 18px;
        padding-top: 0;
    }

    .certificate-meta .certificate-product-name {
        display: block;
        font-family: 'Inria Serif', serif;
        font-size: 26px;
        line-height: 1.25;
        font-weight: 600;
        color: var(--black, #111);
        margin-bottom: 8px;
    }

    @media (max-width: 900px) {
        .certificate-wrapper {
            flex-direction: column;
            margin: 20px;
            padding-top: 30px;
        }

        .certificate-left {
            min-height: 280px;
        }
    }

    @media (max-width: 500px) {
        .certificate-left-inner {
            width: calc(100% - 60px);
            padding: 20px 10px;
            margin: 30px;
            gap: 10px;
        }

        .certificate-left-title {
            font-size: 28px;
        }
    }
</style>

<div class="certificate-wrapper">
    <div class="certificate-left">
        <div class="certificate-left-inner">
            <span class="certificate-left-title">
                {{ __('certifications.product_certificate.title') }}
            </span>
            <span>{{ __('certifications.product_certificate.lead') }}</span>
            <span class="certificate-left-code">{{ $certificate->access_code }}</span>
        </div>
    </div>

    <div class="certificate-right">
        <div class="certificate-content">
            @if($certificate->displaySku() !== '' || $certificate->displayName() !== '')
                <p class="certificate-meta">
                    @if($certificate->displayName() !== '')
                        <strong class="certificate-product-name">{{ $certificate->displayName() }}</strong>
                    @endif
                    @if($certificate->displaySku() !== '')
                        <br>{{ __('certifications.product_certificate.sku_label') }}: {{ $certificate->displaySku() }}
                    @endif
                </p>
            @endif

            <div class="certificate-body">
                {!! nl2br(e($certificate->body_text)) !!}
            </div>

            @php($imageUrl = $certificate->resolvedImageUrl())
            @if($imageUrl)
                <div class="certificate-image">
                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ __('certifications.product_certificate.image_alt', ['sku' => $certificate->displaySku() ?: $certificate->access_code]) }}"
                        loading="lazy"
                    >
                </div>
            @endif

            @if($certificate->pdf_filename || $certificate->hasVerifyAction())
                <div class="certificate-actions-primary{{ ($certificate->pdf_filename && $certificate->hasVerifyAction()) ? '' : ' certificate-actions-primary--verify-only' }}">
                    @if($certificate->pdf_filename)
                        <a href="{{ route('product_certificate.pdf', ['code' => $certificate->access_code]) }}" class="morButton morButton2" target="_blank" rel="noopener">
                            <span class="morButtonTxt">{{ __('certifications.product_certificate.download_pdf') }}</span>
                        </a>
                    @endif

                    @if($certificate->pdf_filename && $certificate->hasVerifyAction() && $certificate->verifyUrl())
                        <span class="certificate-actions-spacer" aria-hidden="true"></span>
                    @endif

                    @if($certificate->hasVerifyAction() && $certificate->verifyUrl())
                        <a
                            href="{{ $certificate->verifyUrl() }}"
                            class="morButton certificate-btn-verify"
                        >
                            <span class="morButtonTxt">{{ __('certifications.product_certificate.verify_blockchain') }}</span>
                        </a>
                    @endif
                </div>
            @endif

            @if($productAvailable && $product)
                <div class="certificate-actions-secondary">
                    <a href="{{ $product->url }}" class="morButton">
                        <span class="morButtonTxt">{{ __('certifications.product_certificate.view_product') }}</span>
                    </a>
                </div>
            @endif

            @if($certificate->isNotarized())
                <p class="certificate-meta">
                    {{ __('certifications.product_certificate.notarized_label') }}
                    <code>{{ $certificate->notarizationHashPrefixed() }}</code>
                    @if($certificate->polygonscanUrl())
                        — <a href="{{ $certificate->polygonscanUrl() }}" target="_blank" rel="noopener">Polygonscan</a>
                    @endif
                </p>
            @endif

            <p class="certificate-copyright">
                <em>{{ __('certifications.product_certificate.copyright', ['year' => date('Y')]) }}</em>
            </p>
        </div>
    </div>
</div>
@endsection
