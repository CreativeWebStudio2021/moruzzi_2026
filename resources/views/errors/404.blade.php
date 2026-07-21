@include('errors.partials.setup', ['errorCode' => '404'])

@extends('web.layout')

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

@push('styles')
    @include('errors.partials.styles')
@endpush

@section('content')
<section class="error-page">
    <div class="error-page__code" aria-hidden="true">404</div>
    <h1>{{ __('errors.404.heading') }}</h1>
    <p>{{ __('errors.404.message') }}</p>
    <div class="error-page__actions">
        <a href="{{ locale_route('home') }}" class="morButton morButton2 morButtonFit">
            <span class="morButtonTxt">{{ __('errors.404.home') }}</span>
        </a>
        <a href="{{ locale_route('catalog.index') }}" class="morButton morButtonFit">
            <span class="morButtonTxt">{{ __('errors.404.catalog') }}</span>
        </a>
    </div>
</section>
@endsection
