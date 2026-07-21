@php
    $certNavKeys = [
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
    <a href="{{ locale_route($routeName) }}" @class(['active' => request()->routeIs($routeName)])>
        {{ __("certifications.{$key}.title") }}
    </a>
@endforeach
