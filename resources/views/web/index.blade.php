@extends('web.layout')

@push('meta')
	@php
		$homeJsonLd = app(\App\Services\Seo\OrganizationJsonLdBuilder::class)->websiteWithOrganization();
		$homeAlternateUrls = [];
		foreach (['it', 'en', 'es', 'fr', 'de'] as $homeLocale) {
			$homeAlternateUrls[$homeLocale] = $homeLocale === 'it' ? url('/') : url('/'.$homeLocale);
		}
	@endphp
	@include('web.common.hreflang', ['alternateUrls' => $homeAlternateUrls])
	@include('web.common.json-ld', ['jsonLdGraphs' => [$homeJsonLd]])
@endpush

@section('content')
	
	@include('web.home.ultimi_arrivi')
	@include('web.home.in_evidenza')
	@include('web.home.in_offerta')
	@include('web.home.banner_info')
	@include('web.home.categorie')
	@include('web.home.ticker')
	@include('web.home.stime')
	@include('web.home.ticker')
	@include('web.home.accedi')
	@include('web.home.banner_info')
	@include('web.home.investimento')
	@include('web.home.famiglia')
	@include('web.home.partnership')
	@include('web.home.script')
	
@endsection