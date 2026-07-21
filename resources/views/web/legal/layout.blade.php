@extends('web.layout')

@php
    $legalPage = array_replace_recursive(
        trans('legal.' . $legalKey, [], 'it'),
        trans('legal.' . $legalKey)
    );

    $resolveLegalUrls = function (mixed $value) use (&$resolveLegalUrls): mixed {
        if (is_string($value)) {
            return str_replace(
                [':cookie_url', ':privacy_url'],
                [locale_route('legal.cookie_policy'), locale_route('legal.privacy')],
                $value
            );
        }

        if (is_array($value)) {
            return array_map($resolveLegalUrls, $value);
        }

        return $value;
    };

    $legalPage = $resolveLegalUrls($legalPage);
    $metaTitle = ($legalPage['meta_title'] ?? $legalPage['title'] ?? '') . ' | ' . config('app.name');
    $metaDescription = $legalPage['meta_description'] ?? '';
@endphp

@push('styles')
    @include('web.legal.partials.page-styles')
@endpush

@section('content')
<section class="catalog-section section-big-pt-space b-g-light">
    <div class="catalog-wrapper generalMargin">
        <div class="catalog-main" style="max-width:100%;">
            <div class="catalog-breadcrumb">
                <h1 class="catalog-page-title" style="font-size:50px;">
                    {{ $legalPage['title'] ?? '' }}
                </h1>
                <ul class="breadcrumb-list">
                    <li><a href="{{ locale_route('home') }}" title="{{ config('app.name') }}">{{ __('catalog.home') }}</a></li>
                    <li><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                    <li><span class="pt-sans">{{ $legalPage['title'] ?? '' }}</span></li>
                </ul>
            </div>

            <div class="catalog-description small-section">
                @include('web.legal.partials.page-content', ['page' => $legalPage])
            </div>
        </div>
    </div>
</section>
@endsection
