@extends('web.guide.layout')

@section('guide-content')
    @php
        use App\Support\GuideRegistry;

        $sections = GuideRegistry::sectionKeys();
    @endphp

    <div class="guide-hub cert-page">
        @foreach ($sections as $sectionKey)
            @php
                $sectionArticles = collect(GuideRegistry::articles())
                    ->filter(fn (array $item) => $item['section'] === $sectionKey && ($item['nav'] ?? true))
                    ->filter(fn (array $item) => $item['route'] !== 'guide.index')
                    ->values();
            @endphp

            @if ($sectionArticles->isNotEmpty())
                <section class="guide-hub-section cert-block cert-reveal">
                    <h2 class="guide-hub-section__title">{{ __("guide.sections.{$sectionKey}") }}</h2>
                    <ul class="guide-hub-links">
                        @foreach ($sectionArticles as $item)
                            @php
                                $route = $item['redirect_route'] ?? $item['route'];
                                $key = $item['id'];
                            @endphp
                            <li>
                                <a href="{{ locale_route($route) }}">{{ __("guide.articles.{$key}.title") }}</a>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
        @endforeach
    </div>
@endsection
