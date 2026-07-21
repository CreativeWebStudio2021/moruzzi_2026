@if($products->isNotEmpty())
    @php
        $carouselId = $carouselId ?? 'product-carousel-' . uniqid();
        $sectionClass = $sectionClass ?? 'product-carousel-section';
        $slides = $slides ?? 4;
        $slidesMd = $slidesMd ?? 2;
        $slidesSm = $slidesSm ?? 1;
    @endphp

    @once
        @push('styles')
            <style>
                .product-carousel-section { margin-top: 40px; margin-bottom: 20px; max-width: 100%; min-width: 0; }
                .product-carousel-section__title {
                    font-size: 28px;
                    font-style: italic;
                    color: var(--red);
                    margin-bottom: 24px;
                    font-family: 'Inria Serif', serif;
                }
                .product-carousel-section .carousel-wrapper { width: 100%; max-width: 100%; min-width: 0; }
                .product-carousel-section .carousel-track { display: flex; gap: 20px; transition: transform 0.4s ease; }
                .product-carousel-section .slide {
                    background: var(--background);
                    border-left: solid 1px var(--black);
                    padding: 0 10px 20px 30px;
                    box-sizing: border-box;
                    flex-shrink: 0;
                }
                .product-carousel-section .slideImgContainer {
                    position: relative;
                    width: 100%;
                    aspect-ratio: 1/1;
                    overflow: hidden;
                    background: #fff;
                }
                .product-carousel-section .slideImgContainer img {
                    position: absolute;
                    inset: 0;
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                    object-position: center;
                }
                .product-carousel-section .slideTestoContainer { margin-top: 20px; height: 110px; margin-bottom: 20px; }
                .product-carousel-section .slideTesto {
                    display: -webkit-box;
                    -webkit-line-clamp: 4;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-align: justify;
                    font-size: 15px;
                }
                .product-carousel-section .slidePrezzo { display: flex; flex-direction: column; gap: 0; }
                .product-carousel-section .slidePrezzoFinale {
                    font-weight: 600;
                    font-size: 25px;
                    line-height: 20px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 5px;
                }
                .product-carousel-section .slidePrezzoBarrato {
                    font-size: 15px;
                    text-decoration: line-through;
                    color: var(--blackLight);
                }
                .product-carousel-section .home-label {
                    position: absolute;
                    padding: 6px 10px;
                    font-size: 12px;
                    font-weight: 600;
                }
                .product-carousel-section .home-label-sale {
                    background: rgba(128,40,16,0.85);
                    color: #fff;
                    top: 8px;
                    left: 8px;
                }
                .product-carousel-section .agg-carrello {
                    width: 21px;
                    height: 24px;
                    color: var(--black);
                    cursor: pointer;
                    transition: color 0.4s ease;
                }
                .product-carousel-section .agg-carrello:hover { color: var(--red); }
                .product-carousel-section .carousel { overflow: hidden; }
                .product-carousel-section .carousel-controls {
                    margin-top: 24px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 16px;
                }
                .product-carousel-section .arrow {
                    border: none;
                    background: none;
                    cursor: pointer;
                    padding: 0;
                }
                .product-carousel-section .arrow .freccia-sinistra,
                .product-carousel-section .arrow .freccia-destra {
                    width: 24px;
                    height: 24px;
                    color: var(--black);
                    transition: color 0.3s ease;
                }
                .product-carousel-section .arrow:hover .freccia-sinistra,
                .product-carousel-section .arrow:hover .freccia-destra { color: var(--red); }
                .product-carousel-section__catalog-link {
                    margin-top: 24px;
                    text-align: center;
                }
                .product-carousel-section__catalog-link .morButton {
                    display: inline-flex;
                    margin: 0 auto;
                    width: auto;
                }
            </style>
        @endpush
        @include('web.common.product-carousel-script')
    @endonce

    <section class="{{ $sectionClass }}">
        @if(! empty($title))
            <h2 class="product-carousel-section__title">{{ $title }}</h2>
        @endif
        <div id="{{ $carouselId }}" class="carousel-wrapper"
             data-slides="{{ $slides }}"
             data-slides-md="{{ $slidesMd }}"
             data-slides-sm="{{ $slidesSm }}"
             data-interval="4000">
            <div class="carousel">
                <div class="carousel-track">
                    @foreach($products as $product)
                        @php
                            $isNew = $product->is_new;
                            $available = method_exists($product, 'availableQuantity')
                                ? $product->availableQuantity()
                                : (int) ($product->qty ?? 0);
                            $soldOut = $available <= 0;
                        @endphp
                        <div class="slide">
                            <a href="{{ $product->url }}" title="{{ $product->title }}">
                                <div class="slideImgContainer">
                                    <img src="{{ product_image_url($product->image, 'thumb') }}" alt="{{ image_alt($product->title) }}" loading="lazy">
                                    @if($isNew)
                                        <div class="home-label home-label-new">new</div>
                                    @endif
                                    @if($soldOut)
                                        <div class="home-label home-label-sale">{{ __('catalog.sold_out') }}</div>
                                    @endif
                                </div>
                            </a>
                            <div class="slideTestoContainer">
                                <div class="slideTesto">{!! $product->name !!}</div>
                            </div>
                            <div class="slidePrezzo">
                                <div class="slidePrezzoFinale">
                                    <span>{{ $product->formatted_final_price }}</span>
                                    @if(! $soldOut)
                                        <div class="add-to-cart-btn" data-id="{{ $product->entity_id }}">
                                            <x-icon name="icona-agg-carrello" class="agg-carrello"/>
                                        </div>
                                    @endif
                                </div>
                                @if($product->is_on_sale)
                                    <div class="slidePrezzoBarrato">{{ $product->formatted_original_price }}</div>
                                @endif
                            </div>
                            <a href="{{ $product->url }}" title="{{ $product->title }}">
                                <div class="morButton morButton2" style="margin-top:20px;">
                                    <span class="morButtonTxt">{{ __('general.scopri-di-piu') }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="carousel-controls">
                <button type="button" class="arrow prev" aria-label="Slide precedente">
                    <x-icon name="freccia-sinistra" class="freccia-sinistra"/>
                </button>
                <button type="button" class="arrow next" aria-label="Slide successiva">
                    <x-icon name="freccia-destra" class="freccia-destra"/>
                </button>
            </div>
        </div>
        @if(! empty($catalogUrl))
            <div class="product-carousel-section__catalog-link">
                <a href="{{ $catalogUrl }}" class="morButton morButton2 morButtonFit">
                    <span class="morButtonTxt">{{ __('guide_commerce.view_catalog') }}</span>
                </a>
            </div>
        @endif
    </section>
@endif
