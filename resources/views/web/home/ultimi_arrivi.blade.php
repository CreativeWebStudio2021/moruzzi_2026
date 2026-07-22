<style>
	.afterIntro {
		width:100%;
		margin-top:50px;
		display:flex; 
		flex-direction:column;
		gap:25px;
		background:var(--background);
	}
	
	/* CAROUSEL */
	

	.carousel-track {
		display: flex;
		gap:20px;
		transition: transform 0.4s ease;
	}

	.slide {
		background:var(--dirtyWhite);
		padding:10px 10px 20px;
		margin-top:10px;
		box-sizing: border-box;
	}

	.slide3 {
		background:var(--background);
		border-left:solid 1px var(--black);
		padding-left:30px;
	}
	
	/* Riquadro quadrato come immagine principale prodotto */
	.slideImgContainer{
		position:relative;
		width:100%;
		aspect-ratio:1/1;
		overflow:hidden;
		background:var(--dirtyWhite);
	}
	.slideImgContainer img{
		position:absolute;
		inset:0;
		width:calc(100% - 12px);
		height:calc(100% - 12px);
		object-fit:contain;
		object-position:center;
		background:#fff;
		padding:5px;
		border:solid 1px rgba(var(--backgroundRGB), 0.4);
	}
	.slideTestoContainer{
		margin-top:10px;
		height:150px;
		border-bottom:solid 1px var(--black);
		margin-bottom:20px;
	}
	.slideTestoContainer3{
		height:110px;
		margin-bottom:20px;
	}
	.slideTesto{
		display: -webkit-box;
		-webkit-line-clamp: 4;       /* Numero di righe */
		-webkit-box-orient: vertical;
		overflow: hidden;
		text-align:justify;
	}

	
	.carousel-wrapper {
		width: 60%;
		margin: auto;
	}

	.carousel {
		overflow: hidden;
	}

	.carousel-controls {
		margin-top: 30px;
		display: flex;
		justify-content: center;
		align-items: center;
		gap: 30px;
	}

	.arrow {
		cursor: pointer;
		background:none;
		border:none;
	}
	
	.dots {
		display: flex;
		gap: 5px;
	}

	.dots span {
		width: 8px;
		height: 8px;
		border:solid 1px var(--black);
		background: none;
		border-radius: 50%;
		cursor: pointer;
	}

	.dots span.active {
		width: 10px;
		height: 10px;
		border: none;
		background: var(--red);
		opacity: 1;
	}

	.freccia-sinistra, .freccia-destra{
		color:var(--black);
		width:40px;
	}

	.arrow:hover .freccia-sinistra, .arrow:hover .freccia-destra{
		color:var(--red);
	}
	
	.dots2 span {
		border:solid 1px #fff;
	}

	.dots2 span.active {
		background: #fff;
	}
	
	.freccia-sinistra2, .freccia-destra2{
		color:white;
		width:40px;
	}

	.arrow:hover .freccia-sinistra2, .arrow:hover .freccia-destra2{
		color:white;
	}

	.home-label {
		position:absolute;
		top:10px;
		padding:4px 8px;
		font-size:12px;
		font-weight:bold;
		z-index:2;
	}
	.home-label-new {
		left:10px;
		background:var(--red);
		color:#fff;
	}
	.home-label-sale {
		right:10px;
		background:var(--black);
		color:#fff;
	}
	.ultimi-arrivi-text-container{
		width:40%;
		display:flex;
		flex-direction:column;
		justify-content:space-between;
		padding:10px 0 68px;
	}
	@media (max-width: 900px) {
		.ultimi-arrivi-container{
			flex-direction:column;
		}
		.carousel-wrapper{
			width:100%;
		}
		.ultimi-arrivi-text-container{
			width:100%;
			justify-content:start;
			gap:20px;
		}
	}
</style>


<div class="afterIntro">
	<div id="carousel1" class="generalMargin">
		<div class="title-paragraph" style="color:var(--red);">
			{{ __('home.ultimi-arrivi') }}
		</div>
		<div class="ultimi-arrivi-container" style="position:relative; width:100%; display:flex; justify-content:space-between; gap:60px">
			<div class="carousel-wrapper">
				<div class="carousel">
					<div class="carousel-track">
						@foreach($latestProducts as $product)

							@php
								$isNew = $product->is_new;
								$available = method_exists($product, 'availableQuantity')
									? $product->availableQuantity()
									: (int) ($product->qty ?? 0);
								$soldOut = $available <= 0;
								$thumbUrl = product_image_url($product->image, 'thumb');
								[$thumbSrcW, $thumbSrcH] = cache_remember_safe(
									'home_thumb_dims:' . md5((string) $product->image),
									now()->addDays(30),
									function () use ($thumbUrl) {
										try {
											$response = \Illuminate\Support\Facades\Http::timeout(5)->get($thumbUrl);
											if ($response->successful()) {
												$size = @getimagesizefromstring($response->body());
												if ($size) {
													return [$size[0], $size[1]];
												}
											}
										} catch (\Throwable $e) {
										}

										return [400, 400];
									}
								);
								$thumbWidth = 329;
								$thumbHeight = ($thumbSrcH > 0 && ($thumbSrcW / $thumbSrcH) >= 1.9) ? 165 : 329;
							@endphp

							<div class="slide">
								<a href="{{ $product->url }}" title="{{ $product->title }}">
									<div class="slideImgContainer">
										<img src="{{ $thumbUrl }}" alt="{{ image_alt($product->title) }}" loading="lazy" width="{{ $thumbWidth }}" height="{{ $thumbHeight }}">
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
										<span class="morButtonTxt">
											{{ __('general.approfondisci') }}
										</span>
									</div>
								</a>

							</div>

						@endforeach
					</div>

				</div>
				<div class="carousel-controls">
					<button class="arrow prev"><x-icon name="freccia-sinistra" class="freccia-sinistra"/></button>
					<div class="dots"></div>
					<button class="arrow next"><x-icon name="freccia-destra" class="freccia-destra"/></button>
				</div>
			</div>
			
			<style>
				.freccia-guarda-nuovi{
					transform:rotate(45deg);
					transition:transform 0.4s ease;
				}
				.guarda-nuovi{
					font-family:'Fira Mono';
					font-size:16px;
				}
				
				.guarda-nuovi-container:hover .freccia-guarda-nuovi{
					transform:rotate(0deg);
				}
			</style>
			<div class="ultimi-arrivi-text-container">
				<div style="text-align:justify">
					{!! __('home.testo-nuovi-arrivi') !!}
				</div>
				@php
					$categoryId = isset($newArrivals) && $newArrivals ? $newArrivals->entity_id : 1436;
					$categoryModel = isset($newArrivals) && $newArrivals ? $newArrivals : \App\Models\Category::find($categoryId);
					$categoryLink = $categoryModel ? $categoryModel->translated_link : 'catalogo';
				@endphp
				<a href="{{ url(current_locale_prefix() . $categoryLink) }}" style="text-decoration:none; color:inherit;">
					<div style="display:flex; gap:7px; align-items:center;" class="guarda-nuovi-container">
						<x-icon name="freccia-destra" class="freccia-guarda-nuovi"/>
						<div class="guarda-nuovi">
							{!! __('home.guarda-nuovi-arrivi') !!}
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	
</div>	