{{-- Solo alternate/hreflang di fallback. Il canonical è emesso esclusivamente
     da web/layout via PageSeoService ($seoCanonical), per evitare tag doppi. --}}
@if(!empty($alternateUrls) && is_array($alternateUrls) && empty($seoAlternates))
	@foreach($alternateUrls as $hreflangLocale => $href)
		<link rel="alternate" hreflang="{{ $hreflangLocale }}" href="{{ $href }}">
	@endforeach
	@if(!empty($alternateUrls['it']))
		<link rel="alternate" hreflang="x-default" href="{{ $alternateUrls['it'] }}">
	@endif
@endif
