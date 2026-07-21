@php
    $guidePage = $guidePage ?? __('guide.articles.' . $guideKey);
    $blocks = $guidePage['blocks'] ?? [];
    $guideFallbackAlt = image_alt($guidePage['title'] ?? ($guidePage['lead'] ?? ''));
@endphp

<div class="cert-page guide-page">
    @foreach ($blocks as $block)
        @php $type = $block['type'] ?? 'text'; @endphp

        @if ($type === 'faq_item')
            @php
                $image = $block['image'] ?? [];
                $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                $imgAlt = content_image_alt($image, $block['question'] ?? '', $guideFallbackAlt);
            @endphp
            <article class="guide-faq-item cert-block cert-reveal">
                <div class="cert-split">
                    <figure class="cert-split__media cert-frame guide-faq-item__media">
                        <a
                            href="{{ $imgUrl }}"
                            class="cert-frame__link"
                            data-fancybox="guide-faq-gallery"
                            data-caption="{{ $imgAlt }}"
                        >
                            <img
                                src="{{ $imgUrl }}"
                                alt="{{ $imgAlt }}"
                                loading="lazy"
                            >
                        </a>
                    </figure>
                    <div class="cert-split__body">
                        <h2 class="guide-faq-item__question">{{ $block['question'] ?? '' }}</h2>
                        <div class="guide-faq-item__answer">{!! resolve_guide_html($block['answer'] ?? '', $block['question'] ?? $guideFallbackAlt) !!}</div>
                    </div>
                </div>
            </article>
        @elseif ($type === 'split')
            @php
                $image = $block['image'] ?? [];
                $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                $imgAlt = content_image_alt($image, $guideFallbackAlt);
                $rawLink = $image['link'] ?? null;
                $imgLink = $imgUrl;
                $externalLink = false;

                if (is_string($rawLink) && str_starts_with($rawLink, '__ROUTE:')) {
                    $routeToken = substr($rawLink, 8);
                    $anchor = '';
                    if (($hashPos = strpos($routeToken, '#')) !== false) {
                        $anchor = substr($routeToken, $hashPos);
                        $routeToken = substr($routeToken, 0, $hashPos);
                    }
                    try {
                        $imgLink = locale_route($routeToken) . $anchor;
                    } catch (\Throwable) {
                        $imgLink = $imgUrl;
                    }
                } elseif (is_string($rawLink) && str_starts_with($rawLink, 'http')) {
                    $imgLink = $rawLink;
                    $externalLink = true;
                }
            @endphp
            <article class="guide-split cert-block cert-reveal">
                <div class="cert-split">
                    <figure class="cert-split__media cert-frame guide-split__media">
                        @if ($externalLink || ($rawLink && ! str_starts_with((string) $rawLink, '__ROUTE:')))
                            <a
                                href="{{ $imgLink }}"
                                class="cert-frame__link"
                                @if ($externalLink) target="_blank" rel="noopener" @endif
                            >
                                <img
                                    src="{{ $imgUrl }}"
                                    alt="{{ $imgAlt }}"
                                    loading="lazy"
                                >
                            </a>
                        @else
                            <a
                                href="{{ $imgUrl }}"
                                class="cert-frame__link"
                                data-fancybox="guide-gallery"
                                data-caption="{{ $imgAlt }}"
                            >
                                <img
                                    src="{{ $imgUrl }}"
                                    alt="{{ $imgAlt }}"
                                    loading="lazy"
                                >
                            </a>
                        @endif
                    </figure>
                    <div class="cert-split__body guide-split__body">
                        @if (str_contains($block['body'] ?? '', '<table'))
                            <div class="guide-table-wrap">{!! resolve_guide_html($block['body'] ?? '', $guideFallbackAlt) !!}</div>
                        @else
                            @foreach (preg_split('/\n\n+/', $block['body'] ?? '') as $paragraph)
                                @if (trim($paragraph) !== '')
                                    <p>{!! resolve_guide_html(trim($paragraph), $guideFallbackAlt) !!}</p>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </article>
        @elseif ($type === 'figure')
            @php
                $image = $block['image'] ?? [];
                $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                $imgAlt = content_image_alt($image, $guideFallbackAlt);
            @endphp
            <figure class="guide-figure cert-block cert-reveal cert-frame">
                <a
                    href="{{ $imgUrl }}"
                    class="cert-frame__link"
                    data-fancybox="guide-gallery"
                    data-caption="{{ $imgAlt }}"
                >
                    <img
                        src="{{ $imgUrl }}"
                        alt="{{ $imgAlt }}"
                        loading="lazy"
                    >
                </a>
            </figure>
        @elseif ($type === 'html')
            <div class="guide-table-wrap cert-block cert-reveal">
                {!! resolve_guide_html($block['html'] ?? '', $guideFallbackAlt) !!}
            </div>
        @elseif ($type === 'text')
            <div class="cert-block cert-reveal">
                @foreach (($block['paragraphs'] ?? []) as $paragraph)
                    <p>{!! resolve_guide_html($paragraph, $guideFallbackAlt) !!}</p>
                @endforeach
            </div>
        @endif
    @endforeach
</div>
