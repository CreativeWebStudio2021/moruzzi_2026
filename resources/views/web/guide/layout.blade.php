@extends('web.layout')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    @include('web.certificazioni.partials.page-styles')
    @include('web.guide.partials.page-styles')
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    @include('web.about.partials.page-scripts')
@endpush

@section('content')
<section class="catalog-section section-big-pt-space b-g-light">
    <div class="catalog-wrapper generalMargin">
        <div class="catalog-layout">
            <aside class="catalog-sidebar-wrap">
                <div class="catalog-sidebar">
                    <div class="catalog-sidebar-header">
                        <h3 class="pt-sans-bold" style="margin:0; font-family:'Inria Serif'; font-style:italic; font-size:30px;">
                            {{ __('guide.sidebar_title') }}
                        </h3>
                    </div>
                    <div class="catalog-sidebar-body">
                        @include('web.guide.partials.sidebar-nav')
                    </div>
                </div>
            </aside>

            <div class="catalog-main">
                <div class="catalog-breadcrumb">
                    <h1 class="catalog-page-title guide-page-title">
                        {{ __("guide.articles.{$guideKey}.title") }}
                    </h1>
                    <ul class="breadcrumb-list">
                        <li><a href="{{ locale_route('home') }}" title="{{ config('app.name') }}">{{ __('catalog.home') }}</a></li>
                        <li><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                        <li><a href="{{ locale_route('guide.index') }}">{{ __('guide.menu') }}</a></li>
                        @if($sectionKey !== 'overview')
                            <li><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                            <li><span class="pt-sans">{{ __("guide.sections.{$sectionKey}") }}</span></li>
                        @endif
                        <li><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                        <li><span class="pt-sans">{{ __("guide.articles.{$guideKey}.title") }}</span></li>
                    </ul>
                </div>

                <div class="catalog-description small-section">
                    @if(! empty(__("guide.articles.{$guideKey}.lead")))
                        <p class="guide-lead">{{ __("guide.articles.{$guideKey}.lead") }}</p>
                    @endif

                    @hasSection('guide-content')
                        @yield('guide-content')
                    @else
                        @include('web.guide.partials.article-content', ['guideKey' => $guideKey])
                    @endif

                    @if(! empty($guideProducts ?? null) && $guideProducts->isNotEmpty())
                        @include('web.common.product-carousel', [
                            'products' => $guideProducts,
                            'title' => __('guide_commerce.related_products'),
                            'carouselId' => 'guide-products-carousel',
                            'slides' => 3,
                            'slidesMd' => 2,
                            'slidesSm' => 1,
                            'catalogUrl' => $guideCatalogUrl ?? null,
                        ])
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
