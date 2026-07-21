@php
    use App\Support\GuideRegistry;

    $sections = GuideRegistry::sectionKeys();
    $articlesBySection = collect(GuideRegistry::navItems())->groupBy('section');
@endphp

@foreach ($sections as $sectionKey)
    @php
        $sectionItems = $articlesBySection->get($sectionKey, collect());
    @endphp
    @if($sectionItems->isNotEmpty())
        <div class="guide-sidebar-section">
            <div class="guide-sidebar-section-title">{{ __("guide.sections.{$sectionKey}") }}</div>
            @foreach ($sectionItems as $item)
                @php
                    $isActive = locale_route_is($item['route']);
                @endphp
                <div class="catalog-sidebar-item">
                    <div class="catalog-sidebar-row {{ $isActive ? 'active' : '' }}">
                        <a href="{{ locale_route($item['route']) }}" class="catalog-sidebar-link-inner">
                            <span class="catalog-sidebar-name">{{ __("guide.articles.{$item['key']}.title") }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endforeach
