@php
    $certPage = $certPage ?? __('certifications.' . $certKey);
    $blocks = $certPage['blocks'] ?? [];
    $certFallbackAlt = image_alt($certPage['title'] ?? ($certPage['lead'] ?? ''));
@endphp

<div class="cert-page">
    @if(!empty($certPage['appointment']))
        <div class="cert-notice cert-reveal">
            <div class="cert-notice__icon" aria-hidden="true">
                <i class="fa fa-phone"></i>
            </div>
            <div>
                <strong>{{ __('certifications.common.appointment_title') }}</strong>
                <div>{{ __('certifications.common.appointment_text') }}</div>
            </div>
        </div>
    @endif

    @if(!empty($certPage['lead']))
        <p class="cert-lead cert-reveal">{{ $certPage['lead'] }}</p>
    @endif

    @if(empty($blocks))
        <div class="cert-block cert-reveal">
            <p>{{ $certPage['intro'] ?? '' }}</p>
        </div>
    @else
    @foreach($blocks as $block)
        @php $type = $block['type'] ?? 'text'; @endphp

        @if($type === 'text')
            <div class="cert-block cert-reveal">
                @foreach(($block['paragraphs'] ?? []) as $paragraph)
                    <p>{!! resolve_guide_html($paragraph, $certFallbackAlt) !!}</p>
                @endforeach
            </div>

        @elseif($type === 'callout')
            <div class="cert-block cert-reveal">
                <div class="cert-callout">
                    @if(!empty($block['title']))
                        <div class="cert-callout__title">{{ $block['title'] }}</div>
                    @endif
                    @foreach(($block['paragraphs'] ?? []) as $paragraph)
                        <p>{!! resolve_guide_html($paragraph, $certFallbackAlt) !!}</p>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'media_text')
            @php
                $image = $block['image'] ?? [];
                $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                $imgAlt = content_image_alt($image, $certFallbackAlt);
                $isWhatsapp = ($image['file'] ?? '') === 'WhatsApp.jpg';
                $mediaClass = 'cert-split__media cert-frame';
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
                            data-fancybox="cert-gallery"
                            data-caption="{{ image_alt($image['caption'] ?? '', $imgAlt) }}"
                        >
                            <img
                                src="{{ $imgUrl }}"
                                alt="{{ $imgAlt }}"
                                loading="lazy"
                            >
                        </a>
                        @if(!empty($image['caption']))
                            <figcaption class="cert-frame__caption">{{ $image['caption'] }}</figcaption>
                        @endif
                    </figure>
                    <div class="cert-split__body">
                        @foreach(($block['paragraphs'] ?? []) as $paragraph)
                            <p>{!! resolve_guide_html($paragraph, $certFallbackAlt) !!}</p>
                        @endforeach
                    </div>
                </div>
            </div>

        @elseif($type === 'images')
            @php
                $cols = $block['columns'] ?? count($block['items'] ?? []);
                $gridClass = match(true) {
                    ($block['layout'] ?? '') === 'full' => 'cert-media-grid--full',
                    $cols >= 3 => 'cert-media-grid--3',
                    ($block['layout'] ?? '') === 'hero' => 'cert-media-grid--hero',
                    default => 'cert-media-grid--2',
                };
            @endphp
            <div class="cert-block cert-reveal">
                <div class="cert-media-grid {{ $gridClass }}">
                    @foreach(($block['items'] ?? []) as $image)
                        @php
                            $imgUrl = moruzzi_asset('images/' . ($image['file'] ?? ''));
                            $imgAlt = content_image_alt($image, $certFallbackAlt);
                        @endphp
                        <figure class="cert-frame">
                            <a
                                href="{{ $imgUrl }}"
                                class="cert-frame__link"
                                data-fancybox="cert-gallery"
                                data-caption="{{ image_alt($image['caption'] ?? '', $imgAlt) }}"
                            >
                                <img
                                    src="{{ $imgUrl }}"
                                    alt="{{ $imgAlt }}"
                                    loading="lazy"
                                >
                            </a>
                            @if(!empty($image['caption']))
                                <figcaption class="cert-frame__caption">{{ $image['caption'] }}</figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'features')
            <div class="cert-block cert-reveal">
                @if(!empty($block['title']))
                    <h2 style="font-family:'Inria Serif',serif;font-style:italic;font-size:1.35rem;margin:0 0 16px;">{{ $block['title'] }}</h2>
                @endif
                <div class="cert-features">
                    @foreach(($block['items'] ?? []) as $item)
                        <article class="cert-feature">
                            <h3 class="cert-feature__title">{{ $item['title'] }}</h3>
                            <p>{{ $item['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'meters')
            <div class="cert-block cert-reveal">
                @if(!empty($block['title']))
                    <h2 style="font-family:'Inria Serif',serif;font-style:italic;font-size:1.35rem;margin:0 0 16px;">{{ $block['title'] }}</h2>
                @endif
                <div class="cert-meters">
                    @foreach(($block['items'] ?? []) as $meter)
                        <div class="cert-meter" style="--cert-meter-value: {{ $meter['value'] ?? '50%' }};">
                            <div class="cert-meter__head">
                                <strong>{{ $meter['label'] }}</strong>
                                @if(!empty($meter['hint']))
                                    <span style="color:var(--blackLight);font-size:0.88rem;">{{ $meter['hint'] }}</span>
                                @endif
                            </div>
                            <div class="cert-meter__bar">
                                <span class="cert-meter__fill"></span>
                            </div>
                            <p style="margin:8px 0 0;font-size:0.92rem;color:var(--blackLight);">{{ $meter['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'pricing')
            <div class="cert-block cert-reveal">
                @if(!empty($block['title']))
                    <h2 style="font-family:'Inria Serif',serif;font-style:italic;font-size:1.35rem;margin:0 0 16px;">{{ $block['title'] }}</h2>
                @endif
                <div class="cert-pricing">
                    @foreach(($block['rows'] ?? []) as $row)
                        <div class="cert-pricing__row">
                            <div>{!! $row['label'] !!}</div>
                            <div class="cert-pricing__price">{{ $row['price'] }}</div>
                        </div>
                    @endforeach
                    @if(!empty($block['note']))
                        <div class="cert-pricing__note">{{ $block['note'] }}</div>
                    @endif
                </div>
            </div>

        @elseif($type === 'upgrade_flow')
            <div class="cert-block cert-reveal">
                <div class="cert-upgrade-flow">
                    @foreach(($block['steps'] ?? []) as $index => $step)
                        @if($index > 0)
                            <span class="cert-upgrade-flow__arrow" aria-hidden="true">→</span>
                        @endif
                        @php
                            $stepUrl = moruzzi_asset('images/' . ($step['file'] ?? ''));
                            $stepAlt = content_image_alt($step, $step['caption'] ?? '', $certFallbackAlt);
                        @endphp
                        <figure class="cert-frame cert-frame--upgrade">
                            <a
                                href="{{ $stepUrl }}"
                                class="cert-frame__link"
                                data-fancybox="cert-gallery"
                                data-caption="{{ image_alt($step['caption'] ?? '', $stepAlt) }}"
                            >
                                <img src="{{ $stepUrl }}" alt="{{ $stepAlt }}" loading="lazy">
                            </a>
                            @if(!empty($step['caption']))
                                <figcaption class="cert-frame__caption">{{ $step['caption'] }}</figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'links')
            <div class="cert-block cert-reveal">
                @if(!empty($block['title']))
                    <h2 style="font-family:'Inria Serif',serif;font-style:italic;font-size:1.35rem;margin:0 0 12px;">{{ $block['title'] }}</h2>
                @endif
                <div class="cert-links">
                    @foreach(($block['items'] ?? []) as $link)
                        <a href="{{ !empty($link['route']) ? locale_route($link['route']) : ($link['url'] ?? '#') }}">
                            {{ $link['label'] }}
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>
            </div>

        @elseif($type === 'list')
            <div class="cert-block cert-reveal">
                <ul class="cert-list">
                    @foreach(($block['items'] ?? []) as $item)
                        <li>{!! $item !!}</li>
                    @endforeach
                </ul>
            </div>

        @elseif($type === 'tables')
            <div class="cert-block cert-reveal">
                @foreach(($block['tables'] ?? []) as $table)
                    @if(!empty($table['title']))
                        <h2 class="cert-table-title">{{ $table['title'] }}</h2>
                    @endif
                    <div class="cert-table-wrap">
                        <table class="cert-table">
                            @if(!empty($table['headers']))
                                <thead>
                                    <tr>
                                        @foreach($table['headers'] as $header)
                                            <th>{{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @foreach(($table['rows'] ?? []) as $row)
                                    <tr>
                                        @foreach($row as $cell)
                                            <td>{!! $cell !!}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
    @endif

    @if(!empty($certPage['footnote']))
        <div class="cert-block cert-reveal" style="margin-top:36px;font-size:0.9rem;color:var(--blackLight);">
            <p>{{ $certPage['footnote'] }}</p>
        </div>
    @endif
</div>
