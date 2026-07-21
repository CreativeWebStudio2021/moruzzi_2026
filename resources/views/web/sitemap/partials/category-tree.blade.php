@foreach($nodes as $node)
	@php
		$link = $node->translated_link;
		$hasChildren = $node->childrenRecursive && $node->childrenRecursive->count() > 0;
	@endphp
	<li>
		<a href="{{ url($base . $link) }}">{{ $node->translated_name }}</a>
		@if($hasChildren)
			<ul>
				@include('web.sitemap.partials.category-tree', [
					'nodes' => $node->childrenRecursive,
					'base' => $base,
				])
			</ul>
		@endif
	</li>
@endforeach
