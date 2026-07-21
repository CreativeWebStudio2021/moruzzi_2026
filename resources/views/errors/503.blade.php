@include('errors.partials.setup', ['errorCode' => '503'])

@extends('web.layout')

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

@push('styles')
    @include('errors.partials.styles')
@endpush

@section('content')
<section class="error-page">
    <div class="error-page__code" aria-hidden="true">503</div>
    <h1>{{ __('errors.503.heading') }}</h1>
    <p>{{ __('errors.503.message') }}</p>
    <div class="error-page__actions">
        <a href="{{ url()->current() }}" class="morButton morButton2 morButtonFit">
            <span class="morButtonTxt">{{ __('errors.503.retry') }}</span>
        </a>
        <a href="{{ locale_route('home') }}" class="morButton morButtonFit">
            <span class="morButtonTxt">{{ __('errors.503.home') }}</span>
        </a>
    </div>
</section>
@endsection
