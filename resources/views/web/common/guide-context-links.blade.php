@if(! empty($guideLinks))
    <div class="guide-context-links">
        <h3 class="guide-context-links__title">{{ $title ?? __('guide_commerce.guide_links_title') }}</h3>
        @if(! empty($showLead))
            <p class="guide-context-links__lead">{{ __('guide_commerce.guide_links_lead') }}</p>
        @endif
        <ul class="guide-context-links__list">
            @foreach($guideLinks as $link)
                <li>
                    <a href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
