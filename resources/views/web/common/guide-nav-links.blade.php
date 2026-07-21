@php
    $menuItems = \App\Support\GuideRegistry::menuHubItems();
@endphp
<a href="{{ locale_route('guide.index') }}" @class(['active' => locale_route_is('guide.index')])>
    {{ __('guide.sections.overview') }}
</a>
@foreach ($menuItems as $item)
    <a href="{{ locale_route($item['route']) }}" @class(['active' => locale_route_is($item['route'])])>
        {{ __("guide.articles.{$item['key']}.title") }}
    </a>
@endforeach
