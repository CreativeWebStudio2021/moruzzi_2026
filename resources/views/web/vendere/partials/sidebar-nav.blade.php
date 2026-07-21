@php
    $sellNavKeys = $sellNavKeys ?? ['how', 'to_moruzzi', 'today_buy'];
@endphp
@foreach ($sellNavKeys as $key)
    @php $routeName = 'sell.' . $key; @endphp
    <div class="catalog-sidebar-item">
        <div class="catalog-sidebar-row {{ request()->routeIs($routeName) ? 'active' : '' }}">
            <a href="{{ locale_route($routeName) }}" class="catalog-sidebar-link-inner">
                <span class="catalog-sidebar-name">{{ __("sell.{$key}.title") }}</span>
            </a>
        </div>
    </div>
@endforeach
