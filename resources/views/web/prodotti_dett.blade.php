@extends('web.layout')

@section('content')

@push('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

	<style>

	/* ===============================
	   WRAPPER GENERALE
	================================ */

	.product-wrapper {
		box-sizing: border-box;
	}

	.product-wrapper.generalMargin {
		margin-top: 60px;
		margin-bottom: 0;
	}

	/* ===============================
	   LAYOUT FLEX
	================================ */

	.product-page {
		display: grid;
		grid-template-columns: minmax(0, 35fr) minmax(0, 43fr) minmax(0, 22fr);
		gap: clamp(24px, 3vw, 48px);
		align-items: start;
		max-width: 100%;
		min-width: 0;
	}

	.product-gallery,
	.product-details,
	.product-sidebar {
		min-width: 0;
		max-width: 100%;
		overflow-wrap: anywhere;
	}

	.product-sidebar .sidebar-form .morButton,
	.product-sidebar .sidebar-form .morButton.morButton2 {
		width: 100%;
		max-width: 100%;
		margin-left: 0;
		margin-right: 0;
	}

	.product-sidebar-inner {
		position: sticky;
		top: 100px;
	}

	/* ===============================
	   GALLERY
	================================ */

	/* ===== ZOOM AMAZON ===== */

	.main-media {
		width:100%;
		aspect-ratio:1/1;
		position:relative;
		overflow:hidden;
		background:#fff;
		cursor:zoom-in;
	}

	.main-media-img {
		display:none;
		position:absolute;
		inset:0;
		width:100%;
		height:100%;
		object-fit:contain;
		object-position:center;
	}

	.zoom-image {
		position:absolute;
		inset:0;
		background-size:100%;
		background-position:center;
		background-repeat:no-repeat;
		transition:opacity .3s ease;
		opacity:0;
	}

	.zoom-image.active {
		opacity:1;
	}

	.video-preview {
		position:absolute;
		inset:0;
		display:flex;
		align-items:center;
		justify-content:center;
		font-size:50px;
		background:#000;
		color:#fff;
	}

	.thumbs {
		display:flex;
		gap:15px;
		margin-top:20px;
	}

	.thumb {
		width:80px;
		aspect-ratio:1/1;
		position:relative;
		overflow:hidden;
		cursor:pointer;
	}

	.thumb img {
		width:100%;
		height:100%;
		object-fit:cover;
		transition:.3s;
	}

	.thumb:hover img {
		transform:scale(1.05);
	}

	.play-icon {
		position:absolute;
		inset:0;
		display:flex;
		align-items:center;
		justify-content:center;
		background:rgba(0,0,0,.5);
		color:#fff;
		font-size:20px;
	}

	.thumb-video-fallback {
		width:100%;
		height:100%;
		background:#000;
		color:#fff;
		display:flex;
		align-items:center;
		justify-content:center;
		font-size:24px;
	}

	.product-video-link-wrap {
		margin-top: 20px;
	}

	.product-video-link {
		font-size: 1.2em;
		color: var(--black);
		text-decoration: none;
	}

	.product-video-link:hover {
		color: var(--red);
	}

	.product-video-link i {
		margin-left: 6px;
	}

	/* no zoom on mobile: show img, hide background layer */
	@media (max-width:768px){
		.main-media { cursor:pointer; }
		.main-media-img { display:block; }
		.zoom-image { display:none !important; }
	}


	/* ===============================
	   TITOLI E PREZZI
	================================ */

	.product-title {
		font-size: 28px;
		margin-bottom: 20px;
		line-height:1;
	}

	.price-box {
		margin-bottom: 20px;
	}

	.price-current {
		font-size: 25px;
		font-weight: bold;
		color:var(--red);
	}

	.price-old {
		text-decoration: line-through;
		color: var(--lightblack);
		margin-left: 10px;
	}

	/* ===============================
	   CATEGORIE
	================================ */

	.categories {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
		margin: 20px 0;
	}

	.category-tag {
		padding: 6px 12px;
		font-size: 14px;
		text-decoration: none;
		color: var(--black);
		border-radius:14px;
		box-shadow:4px 4px 8px 2px rgb(0 0 0 / 0.25);
	}

	.category-tag:hover {
		background:var(--background);
		box-shadow:0px 4px 4px 0px rgb(0 0 0 / 0.25);
	}

	/* ===============================
	   DISPONIBILITÀ
	================================ */

	.stock {
		margin-top: 15px;
		text-transform: uppercase;
	}

	.stock.available { color: green; }
	.stock.unavailable { color: red; }

	/* ===============================
	   DESCRIZIONE
	================================ */

	.description {
		margin-top: 10px;
	}
	.description p{
		margin: 0px !important;
		padding: 0px !important;
	}
	.boxDati{
		padding:20px;
		background:#fff
	}

	/* ===============================
	   CONDIVISIONE SOCIAL
	================================ */

	.product-share {
		margin-top: 30px;
	}

	.product-share__title {
		font-weight: 700;
		margin-bottom: 14px;
		text-transform: uppercase;
		font-size: 14px;
		letter-spacing: 0.04em;
	}

	.product-share__links {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		gap: 12px;
	}

	.product-share__link {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 44px;
		height: 44px;
		padding: 0;
		border: none;
		background: transparent;
		border-radius: 50%;
		cursor: pointer;
		text-decoration: none;
		transition: transform 0.2s ease, box-shadow 0.2s ease;
	}

	.product-share__link:hover,
	.product-share__link:focus-visible {
		transform: translateY(-2px);
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
		outline: none;
	}

	.product-share__icon {
		display: flex;
		align-items: center;
		justify-content: center;
		line-height: 0;
	}

	.product-share__icon svg {
		display: block;
		width: 40px;
		height: 40px;
	}

	.product-share__feedback {
		margin: 10px 0 0;
		font-size: 13px;
		color: var(--red, #963b3d);
	}

	/* ===============================
	   PROGRESS BARS
	================================ */

	.score-bar {
		margin-top: 10px;
	}

	.score-track {
		height: 28px;
		background: rgba(0,0,0,0.1);
		position: relative;
	}

	.score-fill {
		height: 100%;
		position: absolute;
		left: 0;
		top: 0;
		width: 0;
		transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
	}

	.score-label {
		position: absolute;
		width: 100%;
		text-align: center;
		line-height: 28px;
		color: white;
		font-weight: bold;
		font-size: 14px;
	}

	/* ===============================
	   SIDEBAR (allineato al carrello: qty-box + morButton)
	================================ */

	.sidebar-form .cart-card-qty {
		display: flex;
		align-items: center;
		gap: 8px;
		margin: 10px 0 16px;
	}

	.sidebar-form .cart-card-qty-label {
		font-size: 14px;
	}

	.sidebar-form .qty-box {
		display: inline-flex;
		align-items: center;
		border: 1px solid #ddd;
		border-radius: 4px;
		overflow: hidden;
	}

	.sidebar-form .qty-box input[type="number"] {
		width: 55px;
		border: none;
		text-align: center;
		font-size: 14px;
		padding: 4px 2px;
	}

	.sidebar-form .qty-box button[type="button"] {
		background: #f1f1f1;
		border: none;
		width: 28px;
		height: 28px;
		cursor: pointer;
		font-size: 16px;
		line-height: 1;
	}

	.sidebar-form .qty-box button[type="button"]:hover {
		background: #e0e0e0;
	}

	.sidebar-form .morButton {
		width: 100%;
		max-width: 100%;
		margin-top: 4px;
		box-sizing: border-box;
	}

	.product-purchase--inline {
		display: none;
	}

	.product-purchase--sidebar {
		display: block;
	}

	/* ===============================
	   LINK INFORMATIVI
	================================ */

	.product-guide-links {
		margin-top: 20px;
		padding: 16px 14px 12px;
		background: rgba(128, 40, 16, 0.06);
		border-left: 3px solid var(--red);
		border-top: 1px solid #ccc;
	}

	.product-guide-links__title {
		margin: 0 0 10px;
		font-family: 'Inria Serif', serif;
		font-style: italic;
		font-size: 20px;
		line-height: 1.3;
		color: var(--red);
	}

	.product-guide-links__list {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.product-guide-links__list li + li {
		margin-top: 8px;
	}

	.product-guide-links__list a {
		display: block;
		font-size: 14px;
		line-height: 1.45;
		color: var(--black);
		text-decoration: none;
	}

	.product-guide-links__list a:hover {
		color: var(--red);
		text-decoration: underline;
	}

	.info-links {
		margin-top: 40px;
		border-top: 1px solid #ccc;
		padding-left: 14px;
	}

	.info-link {
		display: block;
		width: 100%;
		text-align: left;
		padding: 12px 0 12px 4px;
		border: none;
		border-bottom: 1px solid #ccc;
		border-radius: 0;
		background: transparent;
		text-decoration: none;
		color: #000;
		font: inherit;
		cursor: pointer;
		transition: 0.3s;
	}

	.info-link:hover {
		background: #000;
		color: #fff;
	}

	/* Pannello laterale info (stile carrello/login) */
	.info-panel-overlay {
		position: fixed;
		inset: 0;
		background: rgba(0,0,0,0);
		opacity: 0;
		visibility: hidden;
		transition: opacity 0.3s ease, background 0.3s ease;
		display: flex;
		justify-content: flex-end;
		z-index: 9999;
	}
	.info-panel-overlay.show {
		opacity: 1;
		visibility: visible;
		background: rgba(0,0,0,0.4);
	}
	.info-panel {
		width: 100%;
		max-width: min(480px, 92vw);
		height: 100%;
		background: #fff;
		display: flex;
		flex-direction: column;
		transform: translateX(100%);
		opacity: 0;
		transition: transform 0.35s cubic-bezier(.4,0,.2,1), opacity 0.3s ease;
	}
	.info-panel-overlay.show .info-panel {
		transform: translateX(0);
		opacity: 1;
	}
	.info-panel-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-weight: bold;
		background: var(--red);
		padding: 20px;
		color: #fff;
		flex-shrink: 0;
	}
	.info-panel-header .info-panel-title {
		font-family: 'Inria Serif', serif;
		font-size: 22px;
		font-style: italic;
	}
	.info-panel-close {
		font-size: 28px;
		line-height: 1;
		cursor: pointer;
		opacity: 0.9;
	}
	.info-panel-close:hover {
		opacity: 1;
	}
	.info-panel-body {
		padding: 20px;
		overflow-y: auto;
		scrollbar-width: none;
		-ms-overflow-style: none;
		flex: 1;
		text-align: justify;
		font-size: 15px;
		line-height: 1.5;
	}
	.info-panel-body::-webkit-scrollbar {
		display: none;
	}
	.info-panel-body p { margin: 0 0 0.8em; }
	.info-panel-body b { font-weight: 700; }

	.info-panel-body .cert-reveal {
		opacity: 1;
		transform: none;
	}

	.info-panel-body .cert-page {
		font-size: 14px;
		line-height: 1.65;
	}

	.info-panel-body .cert-lead {
		font-family: 'Inria Serif', serif;
		font-size: 1.05rem;
		font-style: italic;
		margin: 0 0 16px;
	}

	.info-panel-body .cert-block {
		margin-bottom: 20px;
	}

	.info-panel-body .cert-block p {
		margin: 0 0 12px;
	}

	.info-panel-body .cert-callout {
		background: #f7f3ec;
		border-left: 4px solid var(--red);
		padding: 14px 16px;
		margin-bottom: 4px;
	}

	.info-panel-body .cert-callout__title {
		font-weight: 700;
		margin-bottom: 8px;
	}

	.info-panel-body .cert-list {
		margin: 0;
		padding-left: 1.1rem;
	}

	.info-panel-body .cert-list li {
		margin-bottom: 10px;
	}

	.info-panel-body .cert-table-title {
		font-family: 'Inria Serif', serif;
		font-style: italic;
		font-size: 1rem;
		margin: 20px 0 10px;
	}

	.info-panel-body .cert-table-wrap {
		overflow-x: auto;
		margin-bottom: 8px;
	}

	.info-panel-body .cert-table {
		width: 100%;
		border-collapse: collapse;
		font-size: 0.82rem;
	}

	.info-panel-body .cert-table th,
	.info-panel-body .cert-table td {
		border: 1px solid rgba(0, 0, 0, 0.12);
		padding: 8px 10px;
		text-align: left;
		vertical-align: top;
	}

	.info-panel-body .cert-table th {
		background: rgba(0, 0, 0, 0.05);
		font-family: 'DM Mono', monospace;
		font-size: 0.72rem;
		text-transform: uppercase;
	}

	.info-panel-body .cert-features {
		display: grid;
		gap: 12px;
	}

	.info-panel-body .cert-feature__title {
		font-weight: 700;
		margin: 0 0 4px;
		font-size: 0.95rem;
	}

	.info-panel-body .cert-frame {
		margin: 12px 0;
	}

	.info-panel-body .cert-frame img {
		max-width: 100%;
		height: auto;
	}

	.info-panel-footer {
		flex-shrink: 0;
		padding: 14px 20px 18px;
		border-top: 1px solid rgba(0, 0, 0, 0.08);
		background: #fafafa;
		text-align: center;
	}

	.info-panel-footer[hidden] {
		display: none;
	}

	.info-panel-fullpage {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-family: 'DM Mono', monospace;
		font-size: 13px;
		color: var(--blackLight);
		text-decoration: underline;
		text-underline-offset: 2px;
	}

	.info-panel-fullpage:hover {
		color: var(--red);
	}

	/* ===============================
	   RESPONSIVE
	================================ */

	@media (max-width: 1024px) {

		.product-page {
			display: flex;
			flex-wrap: wrap;
			gap: 32px;
		}

		.product-gallery,
		.product-details {
			flex: 1 1 48%;
			min-width: 0;
			max-width: 100%;
		}

		.product-sidebar {
			flex: 1 1 100%;
			margin-top: 40px;
		}

		.product-sidebar-inner {
			position: relative;
			top: auto;
		}

		.product-purchase--inline {
			display: block;
		}

		.product-purchase--sidebar {
			display: none;
		}

		.product-purchase--inline .sidebar-form {
			text-align: center;
			margin: 8px 0 24px;
		}

		.product-purchase--inline .cart-card-qty {
			flex-direction: column;
			align-items: center;
			justify-content: center;
			gap: 14px;
			margin: 0 0 20px;
		}

		.product-purchase--inline .cart-card-qty-label {
			font-size: 17px;
			font-weight: 600;
		}

		.product-purchase--inline .qty-box {
			border-width: 2px;
			border-color: rgba(45, 45, 45, 0.2);
			border-radius: 8px;
		}

		.product-purchase--inline .qty-box input[type="number"] {
			width: 72px;
			font-size: 20px;
			padding: 10px 4px;
		}

		.product-purchase--inline .qty-box button[type="button"] {
			width: 48px;
			height: 48px;
			font-size: 24px;
		}

		.product-purchase--inline .morButton {
			width: min(100%, 340px);
			margin: 0 auto;
		}
	}

	@media (max-width: 768px) {

		.product-wrapper.generalMargin {
			margin-top: 24px;
			margin-bottom: 0;
		}

		.product-page {
			flex-direction: column;
			gap: 28px;
		}

		.product-gallery,
		.product-details,
		.product-sidebar {
			flex: none;
			width: 100%;
			max-width: 100%;
			min-width: 0;
		}

		.product-sidebar {
			margin-top: 0;
		}

		.thumbs {
			flex-wrap: wrap;
		}
	}

	</style>
@endpush

<div class="product-wrapper generalMargin">

    <div class="product-page">

        {{-- ================= GALLERY ================= --}}
        @php
			$media = collect();
			$productVideo = product_video_media($product->video);

			// immagine principale
			if($product->image){
				$media->push([
					'type' => 'image',
					'src'  => product_image_url($product->image, 'full'),
					'thumb'=> product_image_url($product->image, 'thumb'),
					'fancybox_type' => 'image',
				]);
			}

			// gallery immagini
			foreach($product->gallery as $img){
				$media->push([
					'type' => 'image',
					'src'  => product_image_url($img->image, 'full'),
					'thumb'=> product_image_url($img->image, 'thumb'),
					'fancybox_type' => 'image',
				]);
			}

			if ($productVideo) {
				$media->push($productVideo);
			}
		@endphp

		
		<div class="product-gallery">

			{{-- MAIN --}}
			<div class="main-media" id="mainMedia"
				 data-type="{{ $media[0]['type'] }}"
				 data-src="{{ $media[0]['src'] }}"
				 data-fancybox-type="{{ $media[0]['fancybox_type'] ?? 'image' }}">

				@if($media[0]['type'] === 'image')
					<img
						class="main-media-img"
						id="mainMediaImg"
						src="{{ $media[0]['src'] }}"
						alt="{{ image_alt($product->{'name_'.app()->getLocale()} ?? $product->name) }}"
					>
					<div class="zoom-image active"
						 style="background-image:url('{{ $media[0]['src'] }}')">
					</div>
				@else
					<div class="video-preview">▶</div>
				@endif

			</div>

			{{-- THUMBS --}}
			@if($media->count() > 1)
				<div class="thumbs">
					@foreach($media as $item)
						<div class="thumb"
							 data-type="{{ $item['type'] }}"
							 data-src="{{ $item['src'] }}"
							 data-fancybox-type="{{ $item['fancybox_type'] ?? 'iframe' }}">
							@if(!empty($item['thumb']))
								<img src="{{ $item['thumb'] }}" alt="{{ image_alt($product->{'name_'.app()->getLocale()} ?? $product->name, __('seo.img_product_gallery')) }}">
							@else
								<div class="thumb-video-fallback" aria-hidden="true">▶</div>
							@endif
							@if($item['type'] === 'video')
								<div class="play-icon">▶</div>
							@endif
						</div>
					@endforeach
				</div>
			@endif

			@if($productVideo)
				<p class="product-video-link-wrap">
					<a href="{{ $productVideo['src'] }}"
					   class="product-video-link"
					   data-fancybox="product-video"
					   data-type="{{ $productVideo['fancybox_type'] }}">
						<strong>{{ __('general.guarda_il_video') }}</strong>
						<i class="fa fa-play" aria-hidden="true"></i>
					</a>
				</p>
			@endif

		</div>





        {{-- ================= DETAILS ================= --}}
        <div class="product-details">

            <div class="product-title">
                {{ $product->{'name_'.app()->getLocale()} ?? $product->name }}
            </div>

            <div class="price-box">
                <span class="price-current">
                    {{ $product->formatted_final_price }}
                </span>

                @if($product->special_price)
                    <span class="price-old">
                        {{ $product->formatted_original_price }}
                    </span>
                @endif
            </div>

			@include('web.prodotti.partials.purchase-form', ['purchaseClass' => 'product-purchase product-purchase--inline'])
			
			<hr style="margin:20px 0;">
			
            {{-- Categorie --}}
            <div class="categories">
                @php $baseCat = app()->getLocale() === config('app.locale') ? '' : app()->getLocale().'/'; @endphp
                @foreach($categories as $category)
                    <a href="{{ url($baseCat.$category->translated_link) }}"
                       class="category-tag">
                        {{ $category->translated_name }}
                    </a>
                @endforeach
            </div>
			
			<hr style="margin:20px 0;">
			
            {{-- Disponibilità (stock effettivo: qty − ordini − carrelli) --}}
            <div class="stock">
                {{ __('general.disponibilita') }}:
                <span class="stock {{ $availableQuantity > 0 ? 'available' : 'unavailable' }}">
					{{ $availableQuantity > 0 ? __('general.disponibile') : __('general.non_disponibile') }}
				</span>
            </div>
			
			{{-- SKU --}}
			@if($product->sku)
				<div class="stock" style="margin-top:0;">
					SKU#:&nbsp;
					<span class="stock">
						{!! $product->sku !!}
					</span>
				</div>
            @endif

            {{-- Descrizione --}}
            @if($product->short_description)
				<div style="margin-top:30px;"><b>{{ __('general.descrizione') }}</b>:    </div>
				<div class="description boxDati">
                    {!! $product->short_description !!}
                </div>
            @endif
			
            {{-- BARRE --}}
			@php
				$bars = [
					'conservazione' => ['label' => __('product_panels.conservazione_title'), 'total' => 70, 'color' => '150,59,61'],
					'rarita' => ['label' => __('product_panels.rarita_title'), 'total' => 100, 'color' => '0,0,255'],
					'metallo' => ['label' => __('product_panels.metallo_title'), 'total' => 100, 'color' => '102,102,102'],
					'stile' => ['label' => __('product_panels.stile_title'), 'total' => 100, 'color' => '255,102,0'],
					'coniazione' => ['label' => __('product_panels.coniazione_title'), 'total' => 100, 'color' => '255,204,51'],
					'provenienza' => ['label' => __('product_panels.provenienza_title'), 'total' => 100, 'color' => '0,153,255'],
				];

				// Controllo se almeno una barra ha valore
				$hasBars = collect($bars)->contains(function($config, $field) use ($product) {
					return !empty($product->$field);
				});
			@endphp

			@if($hasBars)
				<div id="product-score-bars" class="description boxDati" style="padding-top:10px !important; margin-top:30px;">

					@foreach($bars as $field => $config)
						@if(!empty($product->$field))

							@php
								$val = $product->$field;
								$perc = ($val / $config['total']) * 100;
							@endphp

							<div class="score-bar" data-val="{{ $val }}" data-tot="{{ $config['total'] }}" data-perc="{{ round($perc, 1) }}">
								<strong>{{ $config['label'] }}</strong>
								<i class="fa-solid fa-circle-info info-panel-trigger" style="cursor:pointer; margin-left:6px; font-size:1rem; color:var(--red);" data-panel="{{ $field }}" title="{{ __('general.info') }}" aria-hidden="true"></i>

								<div class="score-track">
									<div class="score-fill" style="background: rgba({{ $config['color'] }},1);"></div>
									<div class="score-label">0/{{ $config['total'] }}</div>
								</div>
							</div>

						@endif
					@endforeach

				</div>
			@endif

			
			{{-- Dettagli --}}
            @if($product->description)
                <div class="description boxDati" style="margin-top:30px;">
                    {!! $product->description !!}
                </div>
            @endif

            @include('web.prodotti.partials.product-share', ['product' => $product])


        </div>


        {{-- ================= SIDEBAR ================= --}}
        <div class="product-sidebar">
            <div class="product-sidebar-inner">

                @include('web.prodotti.partials.purchase-form', ['purchaseClass' => 'product-purchase product-purchase--sidebar'])


                <div class="info-links">

                    <button type="button" class="info-link info-panel-trigger" data-panel="shop-terms">{{ __('shop_info.links.terms') }}</button>
                    <button type="button" class="info-link info-panel-trigger" data-panel="shop-attestati">{{ __('shop_info.links.attestati') }}</button>
                    <button type="button" class="info-link info-panel-trigger" data-panel="shop-abbreviations">{{ __('shop_info.links.abbreviations') }}</button>
                    <button type="button" class="info-link info-panel-trigger" data-panel="shop-guarantee">{{ __('shop_info.links.guarantee') }}</button>
                    <button type="button" class="info-link info-panel-trigger" data-panel="shop-collecting">{{ __('shop_info.links.collecting') }}</button>

                    @if(! empty($guideLinks))
                        <div class="product-guide-links">
                            <h3 class="product-guide-links__title">{{ __('guide_commerce.product_sidebar_title') }}</h3>
                            <ul class="product-guide-links__list">
                                @foreach($guideLinks as $link)
                                    <li><a href="{{ $link['url'] }}">{{ $link['title'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

            </div>
        </div>

    </div>

</div>

{{-- Prodotti correlati (carousel come in_offerta, tutta larghezza generalMargin) --}}
@if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
@push('styles')
<style>
	.product-related-section { margin-top: 50px; margin-bottom: 60px; padding-bottom:40px; }
	.product-related-section h2 { font-size: 28px; font-style: italic; color: var(--red); margin-bottom: 24px; font-family: 'Inria Serif', serif; }
	.product-related-section .carousel-wrapper { width: 100%; }
	.product-related-section .carousel-track { display: flex; gap: 20px; transition: transform 0.4s ease; }
	.product-related-section .slide { background: var(--background); border-left: solid 1px var(--black); padding: 0px 10px 20px 30px; box-sizing: border-box; flex-shrink: 0; }
	/* Riquadro quadrato come immagine principale prodotto */
	.product-related-section .slideImgContainer {
		position: relative;
		width: 100%;
		aspect-ratio: 1/1;
		overflow: hidden;
		background: #fff;
	}
	.product-related-section .slideImgContainer img {
		position: absolute;
		inset: 0;
		width: 100%;
		height: 100%;
		object-fit: contain;
		object-position: center;
	}
	.product-related-section .slideTestoContainer { margin-top: 20px; height: 110px; margin-bottom: 20px; }
	.product-related-section .slideTesto { display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-align: justify; font-size: 15px; }
	.product-related-section .slidePrezzo { display: flex; flex-direction: column; gap: 0; }
	.product-related-section .slidePrezzoFinale { font-weight: 600; font-size: 25px; line-height: 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
	.product-related-section .slidePrezzoBarrato { font-size: 15px; text-decoration: line-through; color: var(--blackLight); }
	.product-related-section .home-label { position: absolute; padding: 6px 10px; font-size: 12px; font-weight: 600; }
	.product-related-section .home-label-sale { background: rgba(128,40,16,0.85); color: #fff; top: 8px; left: 8px; }
	.product-related-section .agg-carrello { width: 21px; height: 24px; color: var(--black); cursor: pointer; transition: color 0.4s ease; }
	.product-related-section .agg-carrello:hover { color: var(--red); }
	.product-related-section .carousel { overflow: hidden; }
	.product-related-section .carousel-controls {
		margin-top: 24px;
		display: flex;
		justify-content: center;
		align-items: center;
		gap: 16px;
	}
	.product-related-section .carousel-dots-area {
		flex: 1 1 auto;
		min-width: 0;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.product-related-section .dots-scroll {
		max-width: 100%;
		overflow-x: auto;
		overflow-y: hidden;
		scrollbar-width: none;
		-ms-overflow-style: none;
		-webkit-overflow-scrolling: touch;
	}
	.product-related-section .dots-scroll::-webkit-scrollbar {
		display: none;
	}
	.product-related-section .arrow { cursor: pointer; background: none; border: none; flex-shrink: 0; }
	.product-related-section .dots {
		display: flex;
		gap: 5px;
		flex-wrap: nowrap;
		padding: 4px 2px;
		justify-content: flex-start;
	}
	.product-related-section .dots span {
		flex-shrink: 0;
		width: 8px;
		height: 8px;
		border: solid 1px var(--black);
		background: none;
		border-radius: 50%;
		cursor: pointer;
	}
	.product-related-section .dots span.active {
		width: 10px;
		height: 10px;
		border: none;
		background: var(--red);
		opacity: 1;
	}
	.product-related-section .carousel-counter {
		display: none;
		font-size: 14px;
		font-weight: 600;
		white-space: nowrap;
		color: var(--blackLight);
	}
	.product-related-section .carousel-dots-area.is-counter .dots-scroll {
		display: none;
	}
	.product-related-section .carousel-dots-area.is-counter .carousel-counter {
		display: block;
	}
	.product-related-section .freccia-sinistra, .product-related-section .freccia-destra { color: var(--black); width: 40px; }
	.product-related-section .arrow:hover .freccia-sinistra, .product-related-section .arrow:hover .freccia-destra { color: var(--red); }
</style>
@endpush
<div class="generalMargin">
	<section class="product-related-section">
		<h2>{{ __('catalog.related_products') }}</h2>
		<div style="position:relative; width:100%; display:flex; justify-content:space-between; gap:60px;">
			<div id="product-related-carousel" class="carousel-wrapper" data-slides="5" data-slides-md="2" data-slides-sm="1" data-interval="3000" style="width:100%;">
				<div class="carousel">
					<div class="carousel-track">
						@foreach($relatedProducts as $rel)
							@php
								$isNew = $rel->is_new;
								$available = $rel->availableQuantity();
								$soldOut = $available <= 0;
							@endphp
							<div class="slide slide3">
								<a href="{{ $rel->url }}" title="{{ $rel->title }}">
									<div class="slideImgContainer">
										<img src="{{ product_image_url($rel->image, 'thumb') }}" alt="{{ image_alt($rel->title) }}" loading="lazy">
										@if($isNew)
											<div class="home-label home-label-new">new</div>
										@endif
										@if($soldOut)
											<div class="home-label home-label-sale">{{ __('catalog.sold_out') }}</div>
										@endif
									</div>
								</a>
								<div class="slideTestoContainer slideTestoContainer3">
									<div class="slideTesto">
										{!! $rel->name !!}
									</div>
								</div>
								<div class="slidePrezzo">
									<div class="slidePrezzoFinale">
										<span>{{ $rel->formatted_final_price }}</span>
										@if(!$soldOut)
											<div class="add-to-cart-btn" data-id="{{ $rel->entity_id }}">
												<x-icon name="icona-agg-carrello" class="agg-carrello"/>
											</div>
										@endif
									</div>
									@if($rel->is_on_sale)
										<div class="slidePrezzoBarrato">{{ $rel->formatted_original_price }}</div>
									@endif
								</div>
								<a href="{{ $rel->url }}" title="{{ $rel->title }}">
									<div class="morButton morButton2" style="margin-top:20px;">
										<span class="morButtonTxt">{{ __('general.scopri-di-piu') }}</span>
									</div>
								</a>
							</div>
						@endforeach
					</div>
				</div>
				<div class="carousel-controls">
					<button type="button" class="arrow prev" aria-label="Slide precedente"><x-icon name="freccia-sinistra" class="freccia-sinistra"/></button>
					<div class="carousel-dots-area">
						<div class="dots-scroll">
							<div class="dots"></div>
						</div>
						<span class="carousel-counter" aria-live="polite"></span>
					</div>
					<button type="button" class="arrow next" aria-label="Slide successiva"><x-icon name="freccia-destra" class="freccia-destra"/></button>
				</div>
			</div>
		</div>
	</section>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
	var wrapper = document.getElementById('product-related-carousel');
	if (!wrapper) return;
	var track = wrapper.querySelector('.carousel-track');
	var carousel = wrapper.querySelector('.carousel');
	var slides = wrapper.querySelectorAll('.slide');
	var prevBtn = wrapper.querySelector('.prev');
	var nextBtn = wrapper.querySelector('.next');
	var dotsArea = wrapper.querySelector('.carousel-dots-area');
	var dotsScroll = wrapper.querySelector('.dots-scroll');
	var dotsContainer = wrapper.querySelector('.dots');
	var counterEl = wrapper.querySelector('.carousel-counter');
	var gap = 20;
	var index = 0;
	var slidesToShow = 1;
	var maxIndex = 0;
	var resizeTimer;
	var autoplayTimer = null;
	var autoplayDelay = parseInt(wrapper.dataset.interval, 10) || 3000;

	function startAutoplay() {
		stopAutoplay();
		if (maxIndex <= 0) return;
		autoplayTimer = setInterval(nextSlide, autoplayDelay);
	}

	function stopAutoplay() {
		if (autoplayTimer) {
			clearInterval(autoplayTimer);
			autoplayTimer = null;
		}
	}

	function resetAutoplay() {
		stopAutoplay();
		startAutoplay();
	}

	function getSlidesToShow() {
		var lg = parseInt(wrapper.dataset.slides, 10) || 5;
		var md = parseInt(wrapper.dataset.slidesMd, 10) || 2;
		var sm = parseInt(wrapper.dataset.slidesSm, 10) || 1;
		var count = lg;

		if (window.innerWidth <= 768) {
			count = sm;
		} else if (window.innerWidth <= 1024) {
			count = md;
		} else if (window.innerWidth <= 1300) {
			count = Math.min(3, lg);
		}

		return Math.max(1, count);
	}

	function setControlsVisible(visible) {
		var display = visible ? '' : 'none';
		if (prevBtn) prevBtn.style.display = display;
		if (nextBtn) nextBtn.style.display = display;
		if (dotsArea) dotsArea.style.display = display;
	}

	function rebuildDots() {
		if (!dotsContainer) return;
		dotsContainer.innerHTML = '';
		for (var i = 0; i <= maxIndex; i++) {
			var dot = document.createElement('span');
			if (i === index) dot.classList.add('active');
			dot.addEventListener('click', (function(j) {
				return function() {
					index = j;
					updateCarousel();
					resetAutoplay();
				};
			})(i));
			dotsContainer.appendChild(dot);
		}
	}

	function updateDotsMode() {
		if (!dotsArea) return;
		var pageCount = maxIndex + 1;
		var overflow = dotsScroll && dotsScroll.scrollWidth > dotsScroll.clientWidth + 2;
		var useCounter = pageCount > 12 || overflow;

		dotsArea.classList.toggle('is-counter', useCounter);
		if (counterEl) {
			counterEl.textContent = (index + 1) + ' / ' + pageCount;
		}
	}

	function scrollActiveDot() {
		if (!dotsScroll || dotsArea.classList.contains('is-counter')) return;
		var active = dotsContainer.querySelector('span.active');
		if (!active) return;
		var targetLeft = active.offsetLeft - (dotsScroll.clientWidth / 2) + (active.offsetWidth / 2);
		dotsScroll.scrollTo({
			left: Math.max(0, targetLeft),
			behavior: 'smooth'
		});
	}

	function applySlideWidths() {
		var totalGap = gap * (slidesToShow - 1);
		slides.forEach(function(slide) {
			slide.style.flex = '0 0 calc((100% - ' + totalGap + 'px) / ' + slidesToShow + ')';
		});
	}

	function rebuildCarousel() {
		slidesToShow = getSlidesToShow();
		maxIndex = Math.max(0, slides.length - slidesToShow);
		if (index > maxIndex) index = maxIndex;

		if (slidesToShow >= slides.length) {
			setControlsVisible(false);
			stopAutoplay();
		} else {
			setControlsVisible(true);
			rebuildDots();
		}

		applySlideWidths();
		updateCarousel();
		startAutoplay();
	}

	function updateCarousel() {
		if (slides[0]) {
			var slideWidth = slides[0].getBoundingClientRect().width + gap;
			track.style.transform = 'translateX(-' + (index * slideWidth) + 'px)';
		}

		var dots = dotsContainer ? dotsContainer.querySelectorAll('span') : [];
		dots.forEach(function(dot) { dot.classList.remove('active'); });
		if (dots[index]) dots[index].classList.add('active');

		updateDotsMode();
		scrollActiveDot();
	}

	function nextSlide() {
		index = index >= maxIndex ? 0 : index + 1;
		updateCarousel();
	}

	function prevSlide() {
		index = index <= 0 ? maxIndex : index - 1;
		updateCarousel();
	}

	if (prevBtn) prevBtn.addEventListener('click', function() { prevSlide(); resetAutoplay(); });
	if (nextBtn) nextBtn.addEventListener('click', function() { nextSlide(); resetAutoplay(); });

	if (carousel) {
		carousel.addEventListener('mouseenter', stopAutoplay);
		carousel.addEventListener('mouseleave', startAutoplay);

		var touchStartX = 0;
		var touchDragging = false;
		carousel.addEventListener('touchstart', function(e) {
			stopAutoplay();
			touchStartX = e.touches[0].clientX;
			touchDragging = true;
		}, { passive: true });
		carousel.addEventListener('touchmove', function(e) {
			if (!touchDragging) return;
			var diff = touchStartX - e.touches[0].clientX;
			if (Math.abs(diff) > 50) {
				if (diff > 0) nextSlide();
				else prevSlide();
				touchDragging = false;
				resetAutoplay();
			}
		}, { passive: true });
		carousel.addEventListener('touchend', function() {
			touchDragging = false;
			startAutoplay();
		}, { passive: true });
	}

	window.addEventListener('resize', function() {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function() {
			stopAutoplay();
			rebuildCarousel();
		}, 150);
	});

	rebuildCarousel();
});
</script>
@endpush
@endif

{{-- Pannello laterale informazioni (conservazione, rarità, ecc.) --}}
<div id="infoPanelOverlay" class="info-panel-overlay" aria-hidden="true">
	<div class="info-panel">
		<div class="info-panel-header">
			<span id="infoPanelTitle" class="info-panel-title"></span>
			<span id="infoPanelClose" class="info-panel-close" aria-label="{{ __('general.chiudi') }}">&times;</span>
		</div>
		<div id="infoPanelBody" class="info-panel-body"></div>
		<div id="infoPanelFooter" class="info-panel-footer" hidden>
			<a id="infoPanelFullPage" class="info-panel-fullpage" href="#" target="_blank" rel="noopener">
				{{ __('shop_info.open_full_page') }}
				<i class="fa fa-external-link" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</div>
<div class="info-panel-sources" style="display:none;" aria-hidden="true">
	@foreach(['conservazione','rarita','metallo','stile','coniazione','provenienza'] as $key)
		<div id="info-panel-src-{{ $key }}" data-title="{{ __("product_panels.{$key}_title") }}">{!! __("product_panels.panel_{$key}") !!}</div>
	@endforeach
	@include('web.prodotti.partials.shop-info-panel-sources')
</div>

@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

	<script>
        function addProductDetailToCart(form) {
            if (typeof addToCart !== 'function') return;

            var quantityInput = form.querySelector('input[name="quantity"]');
            var qty = 1;

            if (quantityInput) {
                var parsed = parseInt(quantityInput.value, 10);
                qty = isNaN(parsed) || parsed < 1 ? 1 : parsed;
            }

            addToCart({{ $product->entity_id }}, qty);
        }

		document.addEventListener("DOMContentLoaded", function(){
			var maxAvailable = {{ (int) $availableQuantity }};
			var msgNoMore = @json(__('cart.no_more_available'));
			var msgOnlyN = @json(__('cart.only_n_available', ['n' => '__COUNT__']));

			document.querySelectorAll(".sidebar-form").forEach(function(form) {
				var qtyInput = form.querySelector(".product-detail-qty");
				if (!qtyInput) return;

				form.querySelector(".sidebar-qty-minus")?.addEventListener("click", function() {
					var v = parseInt(qtyInput.value, 10) || 1;
					if (v > 1) qtyInput.value = v - 1;
				});
				form.querySelector(".sidebar-qty-plus")?.addEventListener("click", function() {
					var v = parseInt(qtyInput.value, 10) || 0;
					if (maxAvailable <= 0 || v + 1 > maxAvailable) {
						alert(maxAvailable <= 0 ? msgNoMore : msgOnlyN.replace('__COUNT__', String(maxAvailable)));
						return;
					}
					qtyInput.value = v + 1;
				});
			});
			// Pannello info (conservazione, rarità, ecc.)
			var infoOverlay = document.getElementById("infoPanelOverlay");
			var infoTitle = document.getElementById("infoPanelTitle");
			var infoBody = document.getElementById("infoPanelBody");
			var infoClose = document.getElementById("infoPanelClose");
			var infoFooter = document.getElementById("infoPanelFooter");
			var infoFullPage = document.getElementById("infoPanelFullPage");
			document.querySelectorAll(".info-panel-trigger").forEach(function(btn) {
				btn.addEventListener("click", function() {
					var panel = this.getAttribute("data-panel");
					var src = document.getElementById("info-panel-src-" + panel);
					if (!src || !infoOverlay) return;
					infoTitle.textContent = src.getAttribute("data-title") || "";
					infoBody.innerHTML = src.innerHTML;
					var fullPageUrl = src.getAttribute("data-full-page-url");
					if (infoFooter && infoFullPage) {
						if (fullPageUrl) {
							infoFullPage.href = fullPageUrl;
							infoFooter.hidden = false;
						} else {
							infoFooter.hidden = true;
							infoFullPage.removeAttribute("href");
						}
					}
					infoOverlay.classList.add("show");
					infoOverlay.setAttribute("aria-hidden", "false");
					document.body.style.overflow = "hidden";
				});
			});
			function closeInfoPanel() {
				if (infoOverlay) {
					infoOverlay.classList.remove("show");
					infoOverlay.setAttribute("aria-hidden", "true");
					document.body.style.overflow = "";
				}
			}
			if (infoClose) infoClose.addEventListener("click", closeInfoPanel);
			if (infoOverlay) {
				infoOverlay.addEventListener("click", function(e) {
					if (e.target === infoOverlay) closeInfoPanel();
				});
			}
			document.addEventListener("keydown", function(e) {
				if (e.key === "Escape" && infoOverlay && infoOverlay.classList.contains("show")) {
					closeInfoPanel();
				}
			});

			// Animazione barre (conservazione, rarità, ecc.): ogni barra anima quando entra in vista
			var barsContainer = document.getElementById("product-score-bars");
			if (barsContainer) {
				var duration = 1500;
				function animateBar(bar) {
					if (bar.dataset.animated) return;
					bar.dataset.animated = "1";
					var val = parseInt(bar.dataset.val, 10) || 0;
					var tot = parseInt(bar.dataset.tot, 10) || 100;
					var perc = parseFloat(bar.dataset.perc, 10) || 0;
					var fill = bar.querySelector(".score-fill");
					var label = bar.querySelector(".score-label");
					if (fill) fill.style.width = perc + "%";
					if (!label) return;
					var start = 0;
					var startTime = null;
					function updateCount(now) {
						if (!startTime) startTime = now;
						var elapsed = now - startTime;
						var t = Math.min(elapsed / duration, 1);
						t = 1 - Math.pow(1 - t, 2);
						var current = Math.round(start + (val - start) * t);
						label.textContent = current + "/" + tot;
						if (t < 1) requestAnimationFrame(updateCount);
						else label.textContent = val + "/" + tot;
					}
					requestAnimationFrame(updateCount);
				}
				var observer = new IntersectionObserver(function(entries) {
					entries.forEach(function(entry) {
						if (!entry.isIntersecting) return;
						animateBar(entry.target);
					});
				}, { rootMargin: "80px 0px", threshold: 0 });
				barsContainer.querySelectorAll(".score-bar").forEach(function(bar) {
					observer.observe(bar);
				});
			}
		});

		document.addEventListener("DOMContentLoaded", function(){

			const main = document.getElementById("mainMedia");
			const mainImg = document.getElementById("mainMediaImg");
			const thumbs = document.querySelectorAll(".thumb");
			let currentZoom = main.querySelector(".zoom-image");

			/* =========================
			   PRELOAD IMAGES
			========================== */
			thumbs.forEach(t => {
				if(t.dataset.type === "image"){
					const img = new Image();
					img.src = t.dataset.src;
				}
			});

			/* =========================
			   ZOOM AMAZON (DESKTOP ONLY)
			========================== */
			function enableZoom(){

				if(window.innerWidth < 768) return;
				if(!currentZoom) return;

				main.addEventListener("mousemove", moveZoom);
				main.addEventListener("mouseleave", resetZoom);
			}

			function moveZoom(e){

				const rect = main.getBoundingClientRect();
				const x = ((e.clientX - rect.left) / rect.width) * 100;
				const y = ((e.clientY - rect.top) / rect.height) * 100;

				currentZoom.style.backgroundSize = "200%";
				currentZoom.style.backgroundPosition = x + "% " + y + "%";
			}

			function resetZoom(){
				if(!currentZoom) return;
				currentZoom.style.backgroundSize = "100%";
				currentZoom.style.backgroundPosition = "center";
			}

			enableZoom();

			function fancyboxTypeFromElement(el) {
				if (!el) return 'image';
				if (el.dataset.type === 'image') return 'image';
				return el.dataset.fancyboxType || 'iframe';
			}

			if (typeof Fancybox !== 'undefined') {
				Fancybox.bind('[data-fancybox="product-video"]');
			}

			/* =========================
			   CLICK THUMB
			========================== */
			thumbs.forEach(thumb => {

				thumb.addEventListener("click", function(){

					const type = this.dataset.type;
					const src = this.dataset.src;

					main.dataset.type = type;
					main.dataset.src = src;
					main.dataset.fancyboxType = this.dataset.fancyboxType || 'iframe';

					if(type === "image"){

						if (mainImg) {
							mainImg.src = src;
						}

						const newZoom = document.createElement("div");
						newZoom.className = "zoom-image";
						newZoom.style.backgroundImage = `url('${src}')`;

						main.innerHTML = "";
						main.appendChild(newZoom);

						setTimeout(() => newZoom.classList.add("active"), 50);

						currentZoom = newZoom;
						enableZoom();

					} else {

						Fancybox.show([{ src: src, type: fancyboxTypeFromElement(this) }]);

					}

				});

			});

			/* =========================
			   CLICK MAIN → SLIDESHOW
			========================== */
			main.addEventListener("click", function(){

				if(typeof Fancybox === "undefined") return;

				const items = [];

				if(thumbs.length > 0){

					thumbs.forEach(t => {
						items.push({
							src: t.dataset.src,
							type: fancyboxTypeFromElement(t)
						});
					});

				} else {

					items.push({
						src: main.dataset.src,
						type: fancyboxTypeFromElement(main)
					});

				}

				Fancybox.show(items);

			});

		});
	</script>
@endpush


@endsection
