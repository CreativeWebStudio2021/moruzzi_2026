@php
    $aboutNav = [
        ['route' => 'about.presentation', 'key' => 'presentation'],
        ['route' => 'about.staff', 'key' => 'staff'],
        ['route' => 'about.loredana', 'key' => 'loredana'],
        ['route' => 'about.umberto', 'key' => 'umberto'],
        ['route' => 'about.nicola', 'key' => 'nicola'],
        ['route' => 'about.francesca', 'key' => 'francesca'],
        ['route' => 'about.hiroko', 'key' => 'hiroko'],
        ['route' => 'about.publications', 'key' => 'publications'],
        ['route' => 'about.press', 'key' => 'press'],
        ['route' => 'about.memberships', 'key' => 'memberships'],
    ];
@endphp
@foreach ($aboutNav as $item)
    <a href="{{ locale_route($item['route']) }}" @class(['active' => request()->routeIs($item['route'])])>
        {{ __("about.{$item['key']}.title") }}
    </a>
@endforeach
