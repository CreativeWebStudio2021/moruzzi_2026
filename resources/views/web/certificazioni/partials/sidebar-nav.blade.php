@php
    $certNavKeys = $certNavKeys ?? [
        'online',
        'quality',
        'guarantee',
        'attestati',
        'standard',
        'upgrade',
        'estimates_coins',
        'estimates_banknotes',
        'expertise_coins',
        'valuation',
        'expertise_banknotes',
        'cataloguing',
    ];
@endphp
@foreach ($certNavKeys as $key)
    @php $routeName = 'certifications.' . $key; @endphp
    <div class="catalog-sidebar-item">
        <div class="catalog-sidebar-row {{ request()->routeIs($routeName) ? 'active' : '' }}">
            <a href="{{ locale_route($routeName) }}" class="catalog-sidebar-link-inner">
                <span class="catalog-sidebar-name">{{ __("certifications.{$key}.title") }}</span>
            </a>
        </div>
    </div>
@endforeach
