@if(!empty($jsonLdGraphs))
	@foreach($jsonLdGraphs as $jsonLdGraph)
		<script type="application/ld+json">{!! \App\Services\Seo\JsonLd::encode($jsonLdGraph) !!}</script>
	@endforeach
@endif
