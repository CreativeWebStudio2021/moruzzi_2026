@include('errors.partials.setup', ['errorCode' => '500'])

@extends('web.layout')

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

@push('styles')
    @include('errors.partials.styles')
@endpush

@section('content')
<section class="error-page">
    <div class="error-page__code" aria-hidden="true">500</div>
    <h1>{{ __('errors.500.heading') }}</h1>
    <p>{{ __('errors.500.message') }}</p>
    <div class="error-page__actions">
        <a href="{{ locale_route('home') }}" class="morButton morButton2 morButtonFit">
            <span class="morButtonTxt">{{ __('errors.500.home') }}</span>
        </a>
        <a href="{{ locale_route('contact.form') }}" class="morButton morButtonFit">
            <span class="morButtonTxt">{{ __('errors.500.contact') }}</span>
        </a>
    </div>
</section>
@endsection
