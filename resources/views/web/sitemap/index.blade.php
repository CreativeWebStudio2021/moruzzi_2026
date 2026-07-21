@extends('web.layout')

@section('content')

@push('meta')
	<link rel="canonical" href="{{ $alternateUrls[app()->getLocale()] }}">
	@foreach($alternateUrls as $locale => $href)
		<link rel="alternate" hreflang="{{ $locale }}" href="{{ $href }}">
	@endforeach
	<link rel="alternate" hreflang="x-default" href="{{ $alternateUrls['it'] }}">
	@php
		$sitemapSchema = [
			'@context' => 'https://schema.org',
			'@type' => 'WebPage',
			'name' => __('sitemap.title'),
			'description' => __('sitemap.meta_description'),
			'url' => $alternateUrls[app()->getLocale()],
			'inLanguage' => app()->getLocale(),
			'isPartOf' => [
				'@type' => 'WebSite',
				'name' => config('app.name'),
				'url' => url('/'),
			],
		];
	@endphp
	<script type="application/ld+json">
		{!! json_encode($sitemapSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
	</script>
@endpush

@push('styles')
<style>
	.sitemap-page {
		margin: var(--generalMargin);
		margin-top: 40px;
		margin-bottom: 60px;
		max-width: 1100px;
	}
	.sitemap-page h1 {
		font-family: 'Inria Serif';
		font-size: clamp(2rem, 4vw, 2.6rem);
		font-weight: 400;
		margin: 0 0 12px;
		color: var(--red);
	}
	.sitemap-intro {
		max-width: 760px;
		margin-bottom: 36px;
		line-height: 1.6;
	}
	.sitemap-xml-links {
		margin-bottom: 40px;
	}
	.sitemap-xml-links h2 {
		font-family: 'Inria Serif';
		font-size: 1.1rem;
		font-weight: 400;
		margin: 0 0 10px;
		color: var(--black);
	}
	.sitemap-xml-links ul {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.sitemap-xml-links li {
		margin: 0 0 6px;
	}
	.sitemap-xml-link {
		display: inline-block;
		font-family: 'DM Mono';
		font-size: 14px;
		text-decoration: underline;
	}
	.sitemap-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 32px 48px;
	}
	.sitemap-section {
		min-width: 0;
	}
	.sitemap-section--full {
		grid-column: 1 / -1;
	}
	.sitemap-section h2 {
		font-family: 'Inria Serif';
		font-size: 1.35rem;
		font-weight: 400;
		margin: 0 0 14px;
		padding-bottom: 8px;
		border-bottom: 1px solid rgba(45, 45, 45, 0.15);
		color: var(--black);
	}
	.sitemap-list,
	.sitemap-tree {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.sitemap-list li,
	.sitemap-tree li {
		margin: 0 0 8px;
		line-height: 1.45;
	}
	.sitemap-list a,
	.sitemap-tree a {
		text-decoration: underline;
		text-underline-offset: 2px;
	}
	.sitemap-list a:hover,
	.sitemap-tree a:hover {
		color: var(--red);
	}
	.sitemap-tree ul {
		list-style: none;
		margin: 8px 0 0;
		padding: 0 0 0 18px;
		border-left: 1px solid rgba(45, 45, 45, 0.12);
	}
	@media (max-width: 768px) {
		.sitemap-grid {
			grid-template-columns: 1fr;
		}
	}
</style>
@endpush

<main class="sitemap-page" id="contenuto-principale">
	<h1>{{ __('sitemap.title') }}</h1>
	<p class="sitemap-intro">{{ __('sitemap.intro') }}</p>
	<nav class="sitemap-xml-links" aria-label="{{ __('sitemap.xml_nav_label') }}">
		<h2>{{ __('sitemap.xml_nav_title') }}</h2>
		<ul>
			@foreach($xmlSitemaps as $xmlSitemap)
				<li>
					<a class="sitemap-xml-link" href="{{ $xmlSitemap['url'] }}">{{ $xmlSitemap['label'] }}</a>
				</li>
			@endforeach
		</ul>
	</nav>

	<div class="sitemap-grid">
		@foreach($sections as $section)
			<section class="sitemap-section" aria-labelledby="sitemap-{{ $section['id'] }}">
				<h2 id="sitemap-{{ $section['id'] }}">{{ $section['title'] }}</h2>
				<ul class="sitemap-list">
					@foreach($section['links'] as $link)
						<li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
					@endforeach
				</ul>
			</section>
		@endforeach

		<section class="sitemap-section sitemap-section--full" aria-labelledby="sitemap-catalog">
			<h2 id="sitemap-catalog">{{ __('sitemap.sections.catalog') }}</h2>
			<ul class="sitemap-tree">
				@include('web.sitemap.partials.category-tree', [
					'nodes' => $categoryTree,
					'base' => current_locale_prefix(),
				])
			</ul>
		</section>
	</div>
</main>

@endsection
