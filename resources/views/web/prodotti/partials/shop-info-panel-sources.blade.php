@php
    $shopInfoPanels = [
        ['id' => 'shop-terms', 'route' => 'shop.terms', 'title' => __('shop_info.links.terms'), 'page' => array_replace_recursive(trans('shop_info.terms', [], 'it'), trans('shop_info.terms'))],
        ['id' => 'shop-attestati', 'route' => 'certifications.attestati', 'title' => __('shop_info.links.attestati'), 'page' => __('certifications.attestati')],
        ['id' => 'shop-abbreviations', 'route' => 'shop.abbreviations', 'title' => __('shop_info.links.abbreviations'), 'page' => array_replace_recursive(trans('shop_info.abbreviations', [], 'it'), trans('shop_info.abbreviations'))],
        ['id' => 'shop-guarantee', 'route' => 'certifications.guarantee', 'title' => __('shop_info.links.guarantee'), 'page' => __('certifications.guarantee')],
        ['id' => 'shop-collecting', 'route' => 'shop.collecting', 'title' => __('shop_info.links.collecting'), 'page' => array_replace_recursive(trans('shop_info.collecting', [], 'it'), trans('shop_info.collecting'))],
    ];
@endphp
@foreach ($shopInfoPanels as $panel)
    <div
        id="info-panel-src-{{ $panel['id'] }}"
        data-title="{{ $panel['title'] }}"
        data-full-page-url="{{ locale_route($panel['route']) }}"
    >
        <div class="info-panel-content">
            @include('web.certificazioni.partials.page-content', [
                'certKey' => $panel['id'],
                'certPage' => $panel['page'],
            ])
        </div>
    </div>
@endforeach
