@extends('web.layout')

@section('content')
<section class="catalog-section section-big-pt-space b-g-light">
    <div class="catalog-wrapper generalMargin">
        <div class="catalog-layout">
            {{-- Sidebar categorie (sinistra) --}}
            <aside class="catalog-sidebar-wrap">
                <div class="catalog-sidebar">
                    <div class="catalog-sidebar-header">
                        <h3 class="pt-sans-bold" style="margin:0; font-family:'Inria Serif'; font-style:italic; font-size:30px;">{{ __('catalog.categories') }}</h3>
                    </div>
                    <div class="catalog-sidebar-body">
                        @php
                            $locale = app()->getLocale();
                            $base = app()->getLocale() === 'it' ? '' : app()->getLocale().'/';
                            $openIds = $openCategoryIds ?? [];

                            $renderCategoryTree = function($nodes, $level = 0) use (&$renderCategoryTree, $base, $openIds) {
                                foreach ($nodes as $node) {
                                    $hasChildren = $node->childrenRecursive && $node->childrenRecursive->count() > 0;
                                    $isOpen = in_array($node->entity_id, $openIds, true);
                                    $isActive = $openIds && $openIds[0] === $node->entity_id;
                                    $margin = 10 * max(0, $node->level - 2);
                                    $link = $node->translated_link;
                                    $id = $node->entity_id;
                        @endphp
                            <div class="catalog-sidebar-item" style="margin-left: {{ $margin }}px;">
                                <div class="catalog-sidebar-row {{ $isActive ? 'active' : '' }}">
                                    <a href="{{ url($base . $link) }}" class="catalog-sidebar-link-inner">
                                        <span class="catalog-sidebar-name">{{ $node->translated_name }}</span>
                                    </a>
                                    @if($hasChildren)
                                        <button type="button"
                                                class="catalog-sidebar-toggle"
                                                data-target="cat-{{ $id }}">
                                            <i class="fa-regular {{ $isOpen ? 'fa-square-minus' : 'fa-square-plus' }}"></i>
                                        </button>
                                    @endif
                                </div>
                                @if($hasChildren)
                                    <div id="cat-{{ $id }}" class="catalog-sidebar-children {{ $isOpen ? 'open' : '' }}">
                                        @php
                                            $renderCategoryTree($node->childrenRecursive, $level + 1);
                                        @endphp
                                    </div>
                                @endif
                            </div>
                        @php
                                }
                            };

                            $renderCategoryTree($sidebarCategories);
                        @endphp
                    </div>
                </div>
            </aside>

            <div class="catalog-main">
                {{-- Titolo / Breadcrumb --}}
                @if($category)
                    @php
                        $categoryBannerImage = $category->effective_image;
                        $categoryHasVisibleImage = category_has_visible_image($categoryBannerImage);
                    @endphp
                    <div class="catalog-banner{{ $categoryHasVisibleImage ? '' : ' catalog-banner--no-image' }}">
                        <div class="catalog-banner-image-wrap">
                            @if($categoryHasVisibleImage)
                                <img src="{{ category_image_url($categoryBannerImage, 'thumb') }}"
                                     class="catalog-banner-image"
                                     alt="{{ image_alt($category->translated_name, __('seo.img_category')) }}"
                                     loading="lazy"
                                     width="200"
                                     height="200">
                            @endif
                            <div class="catalog-banner-title-overlay">
                                <h1 class="catalog-page-title" style="font-size:50px;">{{ $category->translated_name }}</h1>
                                @if($category)
                                    <div class="catalog-breadcrumb">                       
                                        <ul class="breadcrumb-list">
                                            <li><a href="{{ locale_route('home') }}" title="{{ config('app.name') }}">{{ __('catalog.home') }}</a></li>
                                            @foreach($breadcrumb as $item)
                                                @if($item['url'])
                                                    <li><i class="fa fa-angle-double-right" style="color:var(--black);" aria-hidden="true"></i></li>
                                                    <li><a href="{{ $item['url'] }}" class="pt-sans">{{ $item['name'] }}</a></li>
                                                @else
                                                    <li><i class="fa fa-angle-double-right" style="color:var(--black);" aria-hidden="true"></i></li>
                                                    <li><span class="pt-sans" style="color:var(--black);">{{ $item['name'] }}</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="catalog-breadcrumb">
                                        <h2 class="catalog-page-title pt-sans-bold">{{ __('catalog.products') }}</h2>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
               
                @if($category && ($category->description ?? $category->description_categoria ?? null))
                    <div class="catalog-description small-section">
                        @php
                            $categoryDescription = $category->description ?? $category->description_categoria ?? null;
                            if (app()->getLocale() !== 'it') {
                                $localeField = 'description_' . app()->getLocale();
                                if (!empty($category->{$localeField})) {
                                    $categoryDescription = $category->{$localeField};
                                }
                            }
                        @endphp
                        {!! $categoryDescription !!}
                    </div>
                @endif

                @if($category)
                    @include('web.common.guide-context-links', [
                        'guideLinks' => $guideLinks ?? [],
                        'showLead' => true,
                    ])

                    <div class="catalog-perizie-cta">
                        <p class="catalog-perizie-cta__text">{!! __('catalog.perizie_cta_text') !!}</p>
                        <a
                            href="https://www.umbertomoruzzi.it/perizie-numismatiche.html"
                            class="catalog-perizie-cta__btn"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="{{ __('catalog.perizie_cta_btn_title') }}"
                        >
                            {{ __('catalog.perizie_cta_btn') }}
                        </a>
                    </div>
                @endif

                {{-- Toolbar: conteggio, vista griglia/lista, per pagina, ordine --}}
                <div class="catalog-toolbar-wrap">
                    <div class="catalog-toolbar">
                        <div class="catalog-toolbar-count search-count">
                            <h5 class="pt-sans-bold">
                                {{ __('catalog.products_from') }} <span id="catalog-from">1</span> {{ __('catalog.to') }} <span id="catalog-to">{{ min($perPage, $total) }}</span> {{ __('catalog.of') }} {{ $total }} {{ __('catalog.results') }}
                            </h5>
                        </div>
                        <div class="catalog-toolbar-views">
                            <button type="button" id="catalog-view-grid" class="catalog-view-btn active" title="{{ __('catalog.view_grid') }}" aria-label="{{ __('catalog.view_grid') }}">
                                <i class="fa fa-th" aria-hidden="true"></i>
                            </button>
                            <button type="button" id="catalog-view-list" class="catalog-view-btn" title="{{ __('catalog.view_list') }}" aria-label="{{ __('catalog.view_list') }}">
                                <i class="fa fa-list-ul" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="catalog-toolbar-per-page product-page-per-view">
                            <select id="catalog-per-page" class="pt-sans-bold">
                                <option value="24" {{ $perPage == 24 ? 'selected' : '' }}>24 {{ __('catalog.per_page') }}</option>
                                <option value="48" {{ $perPage == 48 ? 'selected' : '' }}>48 {{ __('catalog.per_page') }}</option>
                                <option value="96" {{ $perPage == 96 ? 'selected' : '' }}>96 {{ __('catalog.per_page') }}</option>
                            </select>
                        </div>
                        <div class="catalog-toolbar-order product-page-filter">
                            <select id="catalog-order" class="pt-sans-bold">
                                <option value="data" {{ $orderBy == 'data' ? 'selected' : '' }}>{{ __('catalog.sort_by') }} {{ __('catalog.date') }}</option>
                                <option value="prezzo" {{ $orderBy == 'prezzo' ? 'selected' : '' }}>{{ __('catalog.sort_by') }} {{ __('catalog.price') }}</option>
                                <option value="nome" {{ $orderBy == 'nome' ? 'selected' : '' }}>{{ __('catalog.sort_by') }} {{ __('catalog.name') }}</option>
                            </select>
                            <button type="button" id="catalog-direction" class="catalog-direction-btn" title="{{ $direction === 'asc' ? __('catalog.desc') : __('catalog.asc') }}" data-direction="{{ $direction }}" aria-label="{{ $direction === 'asc' ? __('catalog.desc') : __('catalog.asc') }}">
                                @if($direction === 'asc')
                                    <i class="fa-solid fa-arrow-down-short-wide fa-2x" aria-hidden="true"></i>
                                @else
                                    <i class="fa-solid fa-arrow-down-wide-short fa-2x" aria-hidden="true"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Lista prodotti (griglia 3 col / lista a righe) --}}
                <div id="catalog-product-list" class="catalog-product-list catalog-view-grid">
                                        @if($products->isEmpty())
                                            <div class="product-wrapper-grid product">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="catalog-no-results">
                                                            {{ __('catalog.no_results') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @include('web.catalog.partials.product-grid', [
                                                'products' => $products,
                                                'cartProductIds' => $cartProductIds,
                                                'searchKeywords' => $searchQuery !== '' ? preg_split('/\s+/', $searchQuery, -1, PREG_SPLIT_NO_EMPTY) : [],
                                            ])
                                        @endif
                                    </div>

                                    {{-- Sentinel per infinite scroll + pulsante Carica altro --}}
                @if($hasMore)
                    <div id="catalog-load-more-wrap">
                        <div id="catalog-sentinel"></div>
                        <div class="catalog-load-more-btn-wrap">
                            <button type="button" class="morButton morButton2 catalog-load-more-btn" id="catalog-load-more-btn">
                                <span class="morButtonTxt">{{ __('catalog.load_more') }}</span>
                            </button>
                        </div>
                        <div id="catalog-loading" class="catalog-loading" style="display:none;">
                            <i class="fa fa-spinner fa-spin fa-3x fa-fw" aria-hidden="true"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    
    .catalog-title-image {
        height: 1.1em;
        width: auto;
        object-fit: contain;
        display: block;
    }
    
    .catalog-banner { margin-bottom: 20px; }
    .catalog-banner-image-wrap { display:flex; gap:20px; align-items:center; }
    .catalog-banner--no-image .catalog-banner-image-wrap {
        justify-content: flex-start;
        align-items: flex-start;
    }
    .catalog-banner--no-image .catalog-banner-title-overlay {
        text-align: left;
        width: 100%;
    }
    .catalog-banner--no-image .catalog-page-title {
        color: var(--red);
    }
    .catalog-banner-image {
        width: 200px;
        height: 200px;
        max-width: 200px;
        max-height: 200px;
        flex-shrink: 0;
        object-fit: contain;
        object-position: center;
        display: block;
        background: transparent;
    }
    .catalog-banner-title-overlay {  color: var(--red); }
    .catalog-description {
        background: #fff;
        padding: 20px;
        margin-bottom: 20px;
        text-align: justify;
    }
    .guide-context-links {
        background: #fff;
        border-left: 4px solid var(--red);
        padding: 18px 20px;
        margin: 0 0 24px;
        box-shadow: 0 4px 16px rgba(45, 45, 45, 0.06);
    }
    .guide-context-links__title {
        margin: 0 0 8px;
        font-family: 'Inria Serif', serif;
        font-style: italic;
        font-size: 24px;
        color: var(--red);
    }
    .guide-context-links__lead {
        margin: 0 0 12px;
        font-size: 15px;
        line-height: 1.6;
        color: var(--blackLight);
    }
    .guide-context-links__list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .guide-context-links__list li + li {
        margin-top: 8px;
    }
    .guide-context-links__list a {
        color: var(--black);
        text-decoration: none;
        font-size: 15px;
        line-height: 1.5;
    }
    .guide-context-links__list a:hover {
        color: var(--red);
        text-decoration: underline;
    }
    .catalog-perizie-cta {
        margin: 0 0 28px;
        text-align: right;
    }
    .catalog-perizie-cta__text {
        margin: 0 0 16px;
        line-height: 1.75;
        text-align: right;
    }
    .catalog-perizie-cta__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 24px;
        border-radius: 999px;
        background: var(--red);
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .catalog-perizie-cta__btn:hover {
        background: #a01830;
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }
    .titleCat { font-size: 3.7vw; line-height: 1.2; text-transform: uppercase; font-family: 'Inria Serif', serif; }
    .catalog-toolbar-wrap {
        position: sticky;
        top: var(--header-height, 220px);
        z-index: 900;
        background: var(--background);
    }
    .catalog-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px 20px;
        margin-bottom: 24px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    .catalog-toolbar-count { flex: 1; min-width: 180px; margin: 0; }
    .catalog-toolbar-count h5 { margin: 0; font-size: 1rem; }
    .catalog-toolbar-views { display: flex; gap: 4px; }
    .catalog-view-btn { background: none; border: 1px solid var(--blackLight); padding: 8px 12px; cursor: pointer; color: var(--black); transition: background 0.2s, color 0.2s; }
    .catalog-view-btn:hover { background: var(--background); color: var(--red); }
    .catalog-view-btn.active { background: var(--red); color: #fff; border-color: var(--red); }
    .catalog-direction-btn { background: none; border: none; cursor: pointer; padding: 5px; margin-left: 4px; vertical-align: middle; color: var(--black); }
    .catalog-direction-btn:hover { color: var(--red); }
    .catalog-product-list { display: block; }
    .catalog-product-list .catalog-product-grid { display: block; }
    .catalog-product-list .row { display: flex; flex-wrap: wrap;}
    .catalog-product-list .row > .catalog-product-col { padding: 0 10px; margin-bottom: 24px; }
    /* Griglia 3 colonne (override Bootstrap col-6) */
    .catalog-product-list.catalog-view-grid .row > .catalog-product-col { flex: 0 0 calc(33.33333% - 20px) !important; max-width: 33.333% !important; width: 33.333%; }
    /* Vista lista: 1 prodotto per riga, immagine a sinistra, dati a destra */
    .catalog-view-list .row { flex-direction: column; }
    .catalog-view-list .row > .catalog-product-col { flex: 0 0 100%; max-width: 100%; margin-bottom: 20px; }
    .catalog-view-list .catalog-product-box { display: flex; flex-direction: row; gap: 24px; padding: 20px; background: #fff; border: 1px solid rgba(0,0,0,0.08); align-items: flex-start; }
    .catalog-view-list .catalog-product-imgbox { flex: 0 0 200px; width: 200px; max-width: 200px; position: relative; }
    .catalog-view-list .catalog-product-detail { flex: 1; min-width: 0; }
    .catalog-view-list .catalog-product-front { height: 200px; }
    .catalog-view-list .catalog-product-img-wrap { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #fff; display: flex; align-items: center; justify-content: center; }
    .catalog-view-list .catalog-product-icon { display: none; }
    .catalog-view-list .catalog-label { top: 8px; }
    .catalog-product-img { width: 100%; height: 100%; object-fit: contain; object-position: center; }
    .catalog-product-front { position: relative; aspect-ratio: 1; overflow: hidden; }
    .catalog-view-list .catalog-product-front { aspect-ratio: auto; }
    .catalog-product-img-wrap { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #fff; display: flex; align-items: center; justify-content: center; }
    .catalog-product-img-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }
    .catalog-product-imgbox { position: relative; }
    .catalog-product-icon { position: absolute; bottom: 10px; right: 10px; z-index: 3; }
    .catalog-cart-btn {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--black);
        transition: color 0.2s;
    }
    .catalog-cart-btn:hover:not(.in-cart) {
        color: var(--red);
    }
    .catalog-cart-btn.in-cart {
        cursor: default;
        opacity: 0.5;
    }
    .catalog-cart-btn .agg-carrello {
        width: 21px;
        height: 24px;
        color: var(--black);
        transition: color 0.4s ease;
    }
    .catalog-cart-btn:hover:not(.in-cart) .agg-carrello {
        color: var(--red);
    }
    .catalog-label { position: absolute; top: 10px; padding: 4px 8px; font-size: 12px; font-weight: bold; z-index: 2; pointer-events: none; }
    .catalog-label-new { left: 10px; background: var(--red); color: #fff; }
    .catalog-label-sale,
    .catalog-label-soldout { right: 10px; background: var(--black); color: #fff; }
    .catalog-product-detail { padding: 12px 0 0; }
    .catalog-product-name {
        line-height: 1.3;
        margin: 0 0 6px;
        font-size: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .catalog-product-sku { margin-top: 4px; font-size: 0.9rem; color: var(--blackLight); }
    .catalog-slidePrezzo { display: flex; flex-direction: column; gap: 2px; margin-bottom: 12px; }
    .catalog-slidePrezzoFinale { font-weight: 600; font-size: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
    .catalog-product-price { color: var(--red); }
    .catalog-slidePrezzoBarrato { font-size: 0.95rem; text-decoration: line-through; color: var(--blackLight); }
    .catalog-cart-btn-inline { flex-shrink: 0; }
    .catalog-morButton { margin-top: 8px; }
    .catalog-product-link-more { display: inline-block; text-decoration: none; }
    .catalog-no-results { padding: 50px 20px; text-align: center; font-weight: 600; color: #111; }
    .catalog-load-more-btn-wrap { text-align: center; margin: 40px 0; display:flex; justify-content: center; }
    .catalog-loading { text-align: center; padding: 40px; color: var(--red); }
    .search-highlight { background-color: #ffeb3b; }
    @media (max-width: 991px) {
        .catalog-product-list.catalog-view-grid .row > .catalog-product-col { flex: 0 0 33.333% !important; max-width: 33.333% !important; width: 33.333%; }
        .titleCat { font-size: 5vw; }
    }
    @media (max-width: 767px) {
        .catalog-product-list.catalog-view-grid .row > .catalog-product-col { flex: 0 0 100% !important; max-width: 100% !important; width: 100%; }
        .catalog-view-list .catalog-product-box { flex-direction: column; }
        .catalog-view-list .catalog-product-imgbox { flex: 0 0 auto; width: 100%; max-width: 100%; height: 220px; }
        .catalog-view-list .catalog-product-front { height: 220px; }
        .catalog-toolbar-wrap {
            width: calc(100% + 2 * var(--generalMarginLat));
            margin-left: calc(-1 * var(--generalMarginLat));
            margin-right: calc(-1 * var(--generalMarginLat));
            padding-left: var(--generalMarginLat);
            padding-right: var(--generalMarginLat);
            box-sizing: border-box;
        }
        .catalog-toolbar { gap: 10px; }
        .titleCat { font-size: 6vw; }
        .catalog-banner-image {
            width: 140px;
            height: 140px;
            max-width: 140px;
            max-height: 140px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function() {
    document.querySelectorAll('.catalog-banner-image').forEach(function(img) {
        img.addEventListener('error', function() {
            const banner = this.closest('.catalog-banner');
            if (banner) {
                banner.classList.add('catalog-banner--no-image');
                this.remove();
            }
        });
    });

    const catalogFrom = document.getElementById('catalog-from');
    const catalogTo = document.getElementById('catalog-to');
    const productList = document.getElementById('catalog-product-list');
    const loadMoreWrap = document.getElementById('catalog-load-more-wrap');
    const loadMoreBtn = document.getElementById('catalog-load-more-btn');
    const loadingEl = document.getElementById('catalog-loading');
    const sentinel = document.getElementById('catalog-sentinel');
    const viewGridBtn = document.getElementById('catalog-view-grid');
    const viewListBtn = document.getElementById('catalog-view-list');

    const STORAGE_VIEW = 'catalog_view_mode';
    const baseUrl = '{{ locale_route("catalog.load") }}';
    const sessionUrl = '{{ locale_route("catalog.session") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const categoryId = @json(request()->query('category'));
    const searchQuery = @json(request()->query('q', ''));

    let currentPage = 1;
    let loading = false;
    let hasMore = {{ $hasMore ? 'true' : 'false' }};
    const perPage = {{ $perPage }};

    function setCatalogView(mode) {
        if (!productList) return;
        productList.classList.remove('catalog-view-grid', 'catalog-view-list');
        productList.classList.add(mode === 'list' ? 'catalog-view-list' : 'catalog-view-grid');
        try { localStorage.setItem(STORAGE_VIEW, mode); } catch (e) {}
        if (viewGridBtn) viewGridBtn.classList.toggle('active', mode !== 'list');
        if (viewListBtn) viewListBtn.classList.toggle('active', mode === 'list');
    }
    if (viewGridBtn) {
        viewGridBtn.addEventListener('click', function() { setCatalogView('grid'); });
    }
    if (viewListBtn) {
        viewListBtn.addEventListener('click', function() { setCatalogView('list'); });
    }
    try {
        var saved = localStorage.getItem(STORAGE_VIEW);
        if (saved === 'list') setCatalogView('list');
    } catch (e) {}

    function updateSession(name, value, thenReload) {
        const url = sessionUrl + '?name=' + encodeURIComponent(name) + '&value=' + encodeURIComponent(value);
        fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function() { if (thenReload) window.location.reload(); });
    }

    if (document.getElementById('catalog-per-page')) {
        document.getElementById('catalog-per-page').addEventListener('change', function() {
            updateSession('catalog_per_page', this.value, true);
        });
    }
    if (document.getElementById('catalog-order')) {
        document.getElementById('catalog-order').addEventListener('change', function() {
            updateSession('catalog_order', this.value, true);
        });
    }
    if (document.getElementById('catalog-direction')) {
        document.getElementById('catalog-direction').addEventListener('click', function() {
            const current = this.getAttribute('data-direction') || 'desc';
            const next = current === 'asc' ? 'desc' : 'asc';
            updateSession('catalog_direction', next, true);
        });
    }

    function loadNextPage() {
        if (loading || !hasMore) return;
        loading = true;
        if (loadMoreBtn) loadMoreBtn.style.display = 'none';
        if (loadingEl) loadingEl.style.display = 'block';

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('page', currentPage + 1);
        if (categoryId) formData.append('category', categoryId);
        if (searchQuery) formData.append('q', searchQuery);

        fetch(baseUrl, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.html && productList) {
                    const wrap = document.createElement('div');
                    wrap.innerHTML = data.html;
                    const grid = wrap.querySelector('.catalog-product-grid') || wrap.firstElementChild;
                    const sourceRow = grid && grid.querySelector('.row');
                    const targetRow = productList.querySelector('.row');
                    if (sourceRow && targetRow) {
                        const cols = sourceRow.querySelectorAll('.catalog-product-col');
                        cols.forEach(function(el) { targetRow.appendChild(el); });
                    }
                }
                currentPage = data.page || currentPage + 1;
                hasMore = data.has_more || false;
                if (catalogTo && data.shown_until) catalogTo.textContent = data.shown_until;
                if (!hasMore && loadMoreWrap) loadMoreWrap.style.display = 'none';
            })
            .finally(function() {
                loading = false;
                if (loadMoreBtn) loadMoreBtn.style.display = '';
                if (loadingEl) loadingEl.style.display = 'none';
            });
    }

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadNextPage);
    }

    // Infinite scroll: auto solo per le prime 3 volte, poi solo bottone
    let autoLoadCount = 0;
    let observer = null;
    if (sentinel) {
        observer = new IntersectionObserver(function(entries) {
            const entry = entries[0];
            if (!entry.isIntersecting) return;
            if (autoLoadCount >= 3) {
                observer.disconnect();
                return;
            }
            autoLoadCount++;
            loadNextPage();
        }, { rootMargin: '200px' });
        observer.observe(sentinel);
    }
})();

</script>
@endpush
@endsection
