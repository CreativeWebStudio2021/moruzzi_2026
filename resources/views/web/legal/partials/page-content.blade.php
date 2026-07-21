@php
    $page = $page ?? [];
@endphp

<div class="legal-page">
    @if(!empty($page['lead']))
        <p class="legal-lead">{!! $page['lead'] !!}</p>
    @endif

    @foreach($page['sections'] ?? [] as $section)
        @if(!empty($section['title']))
            <h2 class="legal-heading">{{ $section['title'] }}</h2>
        @endif

        @foreach($section['paragraphs'] ?? [] as $paragraph)
            <p>{!! $paragraph !!}</p>
        @endforeach

        @if(!empty($section['items']))
            <ul class="legal-list">
                @foreach($section['items'] as $item)
                    <li>{!! $item !!}</li>
                @endforeach
            </ul>
        @endif

        @foreach($section['subsections'] ?? [] as $subsection)
            @if(!empty($subsection['title']))
                <h3 class="legal-subheading">{{ $subsection['title'] }}</h3>
            @endif

            @foreach($subsection['paragraphs'] ?? [] as $paragraph)
                <p>{!! $paragraph !!}</p>
            @endforeach

            @if(!empty($subsection['items']))
                <ul class="legal-list">
                    @foreach($subsection['items'] as $item)
                        <li>{!! $item !!}</li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    @endforeach

    @if(!empty($page['footnote']))
        <p class="legal-footnote">{!! $page['footnote'] !!}</p>
    @endif
</div>
