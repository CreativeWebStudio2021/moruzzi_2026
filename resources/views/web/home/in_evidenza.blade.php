<style>
	.in-evidenza-container{
		position:relative;
		width:100%;
		display:flex;
		justify-content:space-between;
		gap:60px;
	}
	@media (max-width: 900px) {
		.in-evidenza-container{
			flex-direction:column;
		}
	}
</style>
<div style="padding:20px 0px; background:var(--red);">
	<div id="carousel2" class="generalMargin">
		<div class="title-paragraph" style="color:white;">
			{{ __('home.prodotti-in-evidenza') }}
		</div>
		<div class="in-evidenza-container">
			<div class="carousel-wrapper">
					<div class="carousel">
					<div class="carousel-track">
						@foreach($featuredProducts as $product)
							@php
								$isNew = $product->is_new;
								$available = method_exists($product, 'availableQuantity')
									? $product->availableQuantity()
									: (int) ($product->qty ?? 0);
								$soldOut = $available <= 0;
								$productNameLower = mb_strtolower(strip_tags((string) $product->name));
								$productImagePath = mb_strtolower((string) $product->image);
								$productIsWideThumb = str_contains($productImagePath, '_2.')
									|| preg_match('/\b(fronte|retro|recto|verso)\b/u', $productNameLower);
								$productThumbWidth = 329;
								$productThumbHeight = $productIsWideThumb ? 165 : 329;
							@endphp
							<div class="slide">
								<a href="{{ $product->url }}" title="{{ $product->title }}">
									<div class="slideImgContainer">
										<img src="{{ product_image_url($product->image, 'thumb') }}" alt="{{ image_alt($product->title) }}" loading="lazy" width="{{ $productThumbWidth }}" height="{{ $productThumbHeight }}">
										@if($isNew)
											<div class="home-label home-label-new">new</div>
										@endif
										@if($soldOut)
											<div class="home-label home-label-sale">{{ __('catalog.sold_out') }}</div>
										@endif
									</div>
								</a>
								<div class="slideTestoContainer">
									<div class="slideTesto">
										{!! $product->name !!}
									</div>
								</div>
								<a href="{{ $product->url }}">
									<div class="morButton">
										<span class="morButtonTxt">{{ __('general.approfondisci') }}</span>
									</div>
								</a>
							</div>
						@endforeach						
					</div>

				</div>
				<div class="carousel-controls">
					<button class="arrow prev"><x-icon name="freccia-sinistra" class="freccia-sinistra2"/></button>
					<div class="dots dots2"></div>
					<button class="arrow next"><x-icon name="freccia-destra" class="freccia-destra2"/></button>
				</div>
			</div>
			
			<style>
				.freccia-guarda-nuovi{
					transform:rotate(45deg);
					transition:transform 0.4s ease;
				}
				.guarda-nuovi{
					font-family:'Fira Mono'
					font-size:16px;
				}
				
				.guarda-nuovi-container:hover .freccia-guarda-nuovi{
					transform:rotate(0deg);
				}
				.in-evidenza-text-container{
					width:40%;
					display:flex;
					flex-direction:column;
					justify-content:space-between;
					padding:10px 0 68px;
					color:white;
				}
				@media (max-width: 900px) {
					.in-evidenza-text-container{
						width:100%;
						justify-content:start;
						gap:20px;
					}
				}
			</style>
			<div class="in-evidenza-text-container">
				<div style="text-align:justify">
					{!! __('home.testo-prodotti-in-evidenza') !!}
				</div>
				@php
					$featuredCategory = \App\Models\Category::find(1435);
					$categoryLink = $featuredCategory ? $featuredCategory->translated_link : 'catalogo';
				@endphp
				<a href="{{ url(current_locale_prefix() . $categoryLink) }}" style="text-decoration:none; color:inherit;">
					<div style="display:flex; gap:7px; align-items:center;" class="guarda-nuovi-container">
						<x-icon name="freccia-destra" class="freccia-guarda-nuovi"/>
						<div class="guarda-nuovi">
							{!! __('home.guarda-tutti-i-prodotti') !!}
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>