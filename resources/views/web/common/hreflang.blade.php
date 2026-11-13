{{-- Canonical/hreflang emessi dal layout via PageSeoService.
     Questo partial resta per compatibilità: popola seoAlternates se il composer
     non li ha ancora visti (stack meta dopo il composer). --}}
@if(!empty($alternateUrls) && is_array($alternateUrls) && empty($seoAlternates))
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
