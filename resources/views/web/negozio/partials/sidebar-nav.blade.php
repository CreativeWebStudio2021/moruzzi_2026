@php
    $shopInfoNav = [
        ['route' => 'shop.terms', 'key' => 'terms'],
        ['route' => 'certifications.attestati', 'key' => 'attestati'],
        ['route' => 'shop.abbreviations', 'key' => 'abbreviations'],
        ['route' => 'certifications.guarantee', 'key' => 'guarantee'],
        ['route' => 'shop.collecting', 'key' => 'collecting'],
    ];
@endphp
@foreach ($shopInfoNav as $item)
    <div class="catalog-sidebar-item">
        <div class="catalog-sidebar-row {{ locale_route_is($item['route']) ? 'active' : '' }}">
            <a href="{{ locale_route($item['route']) }}" class="catalog-sidebar-link-inner">
                <span class="catalog-sidebar-name">{{ __('shop_info.links.' . $item['key']) }}</span>
            </a>
        </div>
    </div>
@endforeach
