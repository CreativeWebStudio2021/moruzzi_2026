@if(!empty($alternateUrls) && is_array($alternateUrls))
	@php
		$canonicalUrl = $alternateUrls[app()->getLocale()] ?? ($alternateUrls['it'] ?? reset($alternateUrls));
	@endphp
	@if($canonicalUrl)
		<link rel="canonical" href="{{ $canonicalUrl }}">
	@endif
	@foreach($alternateUrls as $hreflangLocale => $href)
		<link rel="alternate" hreflang="{{ $hreflangLocale }}" href="{{ $href }}">
	@endforeach
	@if(!empty($alternateUrls['it']))
		<link rel="alternate" hreflang="x-default" href="{{ $alternateUrls['it'] }}">
	@endif
@endif
