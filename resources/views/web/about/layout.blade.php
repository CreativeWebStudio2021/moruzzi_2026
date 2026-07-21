@extends('web.layout')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    @include('web.certificazioni.partials.page-styles')
    @include('web.about.partials.page-styles')
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
                            {{ __('menu.chi-siamo') }}
                        </h3>
                    </div>
                    <div class="catalog-sidebar-body">
                        @include('web.about.partials.sidebar-nav')
                    </div>
                </div>
                <div class="catalog-sidebar" style="margin-top:24px;">
                    <div class="catalog-sidebar-header">
                        <h3 class="pt-sans-bold" style="margin:0; font-family:'Inria Serif'; font-style:italic; font-size:30px;">
                            {{ __('catalog.categories') }}
                        </h3>
                    </div>
                    <div class="catalog-sidebar-body">
                        @php
                            $tagsMenu = $tags ?? collect();
                            $baseMenu = current_locale_prefix();
                        @endphp
                        @include('web.common.catalog-sidebar-tree', [
                            'nodes' => $tagsMenu,
                            'base' => $baseMenu,
                            'idPrefix' => 'about-cat',
                            'openIds' => [],
                        ])
                    </div>
                </div>
            </aside>

            <div class="catalog-main">
                <div class="catalog-breadcrumb">
                    <h1 class="catalog-page-title" style="font-size:50px;">
                        {{ __("about.{$aboutKey}.title") }}
                    </h1>
                    <ul class="breadcrumb-list">
                        <li><a href="{{ locale_route('home') }}" title="{{ config('app.name') }}">{{ __('catalog.home') }}</a></li>
                        <li><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                        <li><a href="{{ locale_route('about.presentation') }}">{{ __('menu.chi-siamo') }}</a></li>
                        <li><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                        <li><span class="pt-sans">{{ __("about.{$aboutKey}.title") }}</span></li>
                    </ul>
                </div>

                <div class="catalog-description small-section">
                    @hasSection('about-content')
                        @yield('about-content')
                    @else
                        @include('web.about.partials.page-content', ['aboutKey' => $aboutKey])
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
