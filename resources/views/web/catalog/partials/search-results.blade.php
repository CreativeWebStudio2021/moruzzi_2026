<div class="search-results-list">
    @if($products->isEmpty())
        <div class="catalog-no-results">
            {{ __('catalog.no_results') }}
        </div>
    @else
        @foreach($products as $product)
            @php
                $displayName = $product->name;
                $displaySku = $product->sku ?? '';
                if (!empty($searchKeywords)) {
                    $displayName = highlight_search($displayName, $searchKeywords);
                    $displaySku = highlight_search($displaySku, $searchKeywords);
                } else {
                    $displayName = e($displayName);
                    $displaySku = e($displaySku);
                }
                $catIds = [];
                $rawCats = trim((string) $product->categorie, '@');
                if ($rawCats !== '') {
                    $catIds = collect(preg_split('/@+/', $rawCats, -1, PREG_SPLIT_NO_EMPTY))
                        ->map(fn ($v) => (int) $v)
                        ->filter()
                        ->values()
                        ->all();
                }
                $productCategories = collect($catIds)
                    ->map(fn ($id) => $categoriesById[$id] ?? null)
                    ->filter()
                    ->values();
            @endphp
            <div class="search-result-item">
                <div class="search-result-img">
                    <a href="{{ $product->url }}" class="search-result-link">
                        <img src="{{ product_image_url($product->image, 'thumb') }}"
                             alt="{{ image_alt($product->title) }}"
                             loading="lazy">
                    </a>
                </div>
                <div class="search-result-info">
                    <a href="{{ $product->url }}" class="search-result-link">
                        <h6 class="search-result-title">{!! $displayName !!}</h6>
                    </a>
                    @if($displaySku !== '')
                        <div class="search-result-sku">SKU: {!! $displaySku !!}</div>
                    @endif
                    @if($productCategories->isNotEmpty())
                        <div class="search-result-categories">
                            @foreach($productCategories as $category)
                                <a href="{{ url(current_locale_prefix() . $category->translated_link) }}"
                                   class="search-result-category">
                                    {{ $category->translated_name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                    @if(!empty($product->formatted_final_price))
                        <div class="search-result-price pt-sans-bold">
                            {{ $product->formatted_final_price }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

@if(!empty($total) && $total > $products->count())
    @php
        $query = request()->query('q', '');
        $params = ['q' => $query];
        if ($family = request()->query('family')) {
            $params['family'] = $family;
        }
    @endphp
    <div class="search-results-see-all">
        <a href="{{ locale_route('catalog.index', $params) }}" class="morButton morButton2" style="width:270px;margin-bottom:20px;  ">
            <span class="morButtonTxt">{{ __('catalog.see_all_results') }}</span>
        </a>
    </div>
@endif

