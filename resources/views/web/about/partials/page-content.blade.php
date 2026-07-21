@php
    $aboutPage = __('about.' . $aboutKey);
    $blocks = $aboutPage['blocks'] ?? [];
    $aboutFallbackAlt = image_alt($aboutPage['title'] ?? ($aboutPage['lead'] ?? ($aboutPage['intro'] ?? '')));
@endphp

<div class="cert-page about-page">
    @if(!empty($aboutPage['lead']))
        <p class="cert-lead cert-reveal">{{ $aboutPage['lead'] }}</p>
    @elseif(!empty($aboutPage['intro']))
        <p class="cert-lead cert-reveal">{{ $aboutPage['intro'] }}</p>
    @endif

    @foreach($blocks as $block)
        @php $type = $block['type'] ?? 'text'; @endphp

        @if($type === 'text')
            <div class="cert-block cert-reveal">
                @foreach(($block['paragraphs'] ?? []) as $paragraph)
                    <p>{!! resolve_guide_html($paragraph, $aboutFallbackAlt) !!}</p>
                @endforeach
            </div>

        @elseif($type === 'media_text')
            @php
                $image = $block['image'] ?? [];
                $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                $imgAlt = content_image_alt($image, $aboutFallbackAlt);
                $isWhatsapp = ($image['file'] ?? '') === 'WhatsApp.jpg';
                $mediaClass = 'cert-split__media cert-frame about-portrait';
                if ($isWhatsapp) {
                    $mediaClass .= ' cert-split__media--compact';
                }
            @endphp
            <div class="cert-block cert-reveal{{ $isWhatsapp ? ' cert-whatsapp-box' : '' }}">
                <div class="cert-split">
                    <figure class="{{ $mediaClass }}">
                        <a
                            href="{{ $imgUrl }}"
                            class="cert-frame__link"
                            data-fancybox="about-gallery"
                            data-caption="{{ image_alt($image['caption'] ?? '', $imgAlt) }}"
                        >
                            <img src="{{ $imgUrl }}" alt="{{ $imgAlt }}" loading="lazy">
                        </a>
                    </figure>
                    <div class="cert-split__body">
                        @foreach(($block['paragraphs'] ?? []) as $paragraph)
                            <p>{!! resolve_guide_html($paragraph, $aboutFallbackAlt) !!}</p>
                        @endforeach
                    </div>
                </div>
            </div>

        @elseif($type === 'cta')
            <div class="cert-block cert-reveal about-cta-block">
                @if(!empty($block['text']))
                    <p class="about-cta-block__text">{!! $block['text'] !!}</p>
                @endif
                <a
                    href="{{ $block['url'] }}"
                    class="about-cta-btn"
                    target="_blank"
                    rel="noopener noreferrer"
                    @if(!empty($block['title'])) title="{{ $block['title'] }}" @endif
                >
                    {{ $block['label'] }}
                </a>
            </div>

        @elseif($type === 'images')
            @php
                $gridClass = ($block['layout'] ?? '') === 'full' ? 'cert-media-grid--full' : 'cert-media-grid--2';
            @endphp
            <div class="cert-block cert-reveal">
                <div class="cert-media-grid {{ $gridClass }}">
                    @foreach(($block['items'] ?? []) as $image)
                        @php
                            $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                            $imgAlt = content_image_alt($image, $aboutFallbackAlt);
                        @endphp
                        <figure class="cert-frame">
                            <a
                                href="{{ $imgUrl }}"
                                class="cert-frame__link"
                                data-fancybox="about-gallery"
                                data-caption="{{ image_alt($image['caption'] ?? '', $imgAlt) }}"
                            >
                                <img src="{{ $imgUrl }}" alt="{{ $imgAlt }}" loading="lazy">
                            </a>
                            @if(!empty($image['caption']))
                                <figcaption class="cert-frame__caption">{{ $image['caption'] }}</figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'masonry')
            <div class="cert-block cert-reveal">
                <div class="about-masonry">
                    @foreach(($block['items'] ?? []) as $image)
                        @php
                            $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                            $imgAlt = content_image_alt($image, $aboutFallbackAlt);
                        @endphp
                        <figure class="about-masonry__item cert-frame">
                            <a
                                href="{{ $imgUrl }}"
                                class="cert-frame__link"
                                data-fancybox="about-gallery"
                                data-caption="{{ image_alt($image['caption'] ?? '', $imgAlt) }}"
                            >
                                <img src="{{ $imgUrl }}" alt="{{ $imgAlt }}" loading="lazy">
                            </a>
                        </figure>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'staff_grid')
            <div class="cert-block cert-reveal">
                <div class="about-staff-grid">
                    @foreach(($block['items'] ?? []) as $member)
                        @php $imgUrl = moruzzi_asset('images/' . ($member['file'] ?? '')); @endphp
                        <article class="about-staff-card">
                            @if(!empty($member['route']))
                                <a href="{{ locale_route($member['route']) }}">
                            @endif
                            <figure class="about-staff-card__photo cert-frame">
                                <img src="{{ $imgUrl }}" alt="{{ image_alt($member['alt'] ?? '', $member['name'] ?? '') }}" loading="lazy">
                            </figure>
                            <h3 class="about-staff-card__name">{{ $member['name'] }}</h3>
                            <p class="about-staff-card__role">{!! $member['role'] !!}</p>
                            @if(!empty($member['route']))
                                </a>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'split_panel')
            @php $carousel = $block['carousel'] ?? []; @endphp
            <div class="about-panel cert-reveal">
                <div class="cert-split">
                    <div class="cert-split__body">
                        @foreach(($block['paragraphs'] ?? []) as $paragraph)
                            <p>{!! resolve_guide_html($paragraph, $aboutFallbackAlt) !!}</p>
                        @endforeach
                    </div>
                    @if(!empty($carousel['items']))
                        <div class="about-shop-carousel cert-split__media" style="max-width:320px;">
                            <div class="carousel-wrapper" data-slides="1" data-interval="2000">
                                <div class="carousel">
                                    <div class="carousel-track">
                                        @foreach($carousel['items'] as $slide)
                                            @php
                                                $slideUrl = moruzzi_asset('images/' . ($slide['file'] ?? ''));
                                                $slideAlt = content_image_alt($slide, $aboutFallbackAlt);
                                            @endphp
                                            <div class="slide">
                                                <div class="slideImgContainer">
                                                    <a href="{{ $slideUrl }}" data-fancybox="about-gallery">
                                                        <img src="{{ $slideUrl }}" alt="{{ $slideAlt }}" loading="lazy">
                                                    </a>
                                                </div>
                                                @if(!empty($slide['caption']))
                                                    <p class="cert-frame__caption">{{ $slide['caption'] }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="carousel-controls">
                                        <button type="button" class="arrow prev" aria-label="{{ $carousel['prev_label'] ?? '' }}">
                                            <x-icon name="freccia-sinistra" class="freccia-sinistra"/>
                                        </button>
                                        <button type="button" class="arrow next" aria-label="{{ $carousel['next_label'] ?? '' }}">
                                            <x-icon name="freccia-destra" class="freccia-destra"/>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        @elseif($type === 'split_item')
            @php
                $image = $block['image'] ?? [];
                $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                $imgAlt = content_image_alt($image, strip_tags($block['title'] ?? ''), $aboutFallbackAlt);
            @endphp
            <article class="about-split-item cert-reveal"@if(!empty($block['anchor'])) id="{{ $block['anchor'] }}"@endif>
                <figure class="about-split-item__media cert-frame">
                    <a
                        href="{{ $imgUrl }}"
                        class="cert-frame__link"
                        data-fancybox="about-gallery"
                        data-caption="{{ $imgAlt }}"
                    >
                        <img src="{{ $imgUrl }}" alt="{{ $imgAlt }}" loading="lazy">
                    </a>
                </figure>
                <div class="about-split-item__body">
                    <h2 class="about-split-item__title">{!! $block['title'] !!}</h2>
                    @if(!empty($block['meta']))
                        <div class="about-split-item__meta">{{ $block['meta'] }}</div>
                    @endif
                    @foreach(($block['paragraphs'] ?? []) as $paragraph)
                        <p>{!! resolve_guide_html($paragraph, $aboutFallbackAlt) !!}</p>
                    @endforeach
                </div>
            </article>
        @endif
    @endforeach
</div>
