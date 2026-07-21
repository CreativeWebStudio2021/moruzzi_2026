@php
    $sellNavKeys = ['how', 'to_moruzzi', 'today_buy'];
@endphp
@foreach ($sellNavKeys as $key)
    @php $routeName = 'sell.' . $key; @endphp
    <a href="{{ locale_route($routeName) }}" @class(['active' => request()->routeIs($routeName)])>
        {{ __("sell.{$key}.title") }}
    </a>
@endforeach
