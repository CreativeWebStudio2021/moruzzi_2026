@push('styles')
	<style>
		.monete-wrapper{
			width:45%;
			text-align:center;
			overflow:hidden;  
			position:relative;
		}

		.monete-img{
			width:85%;
			max-width:100%;
			height:auto;
			object-fit:contain;
			margin-left:10%;
			transform: translateY(-120px); 
			transition: transform 0.8s ease;
		}

		.monete-img.active{
			transform: translateY(0);
		}
		.in-offerta-container{
			display:flex;
			gap:20px;
		}
		.in-offerta-text-container{
			width:55%;
			height:auto;
			display:flex;
			gap:20px;
		}
		.in-offerta-text-container-inner{
			width:50%;
			position:relative;
		}
		.in-offerta-text-container-inner-arrow{
			position:absolute;
			right:-210px;
			bottom:0;
			width:200px;
		}
		.in-offerta-text-container-inner-title{
			position:relative;
			text-align:justify;
			font-size:50px; 
			margin-top:70px; 
			margin-bottom:10px;
			font-style:italic; 
			font-weight:300; 
			color:var(--red); 
			line-height:40px; 
			font-family:'Inria Serif';
		}
		.in-offerta-text-container-inner-text{
			position:relative;
			text-align:justify;
		}
		@media (max-width: 900px) {
			.monete-wrapper{
				width:80%;
			}
			.in-offerta-container{
				flex-direction:column;
			}
			.in-offerta-text-container{
				width:100%;
				justify-content:start;
				flex-direction:column;
				gap:20px;
			}
			.in-offerta-text-container-inner-title{
				margin:var(--generalMargin);
				margin-top:0px;				
			}
			.in-offerta-text-container-inner{
				width:100%;
			}
			.in-offerta-text-container-inner-arrow{
				left:0; 
				bottom:0;
			}
			.guarda-nuovi-container{
				display:flex;
				justify-content:start;
			}
			.in-offerta-text-container-inner-text{
				margin:var(--generalMargin);
				margin-top:0px;
				margin-bottom:0px;
				padding-bottom:60px;
			}
		}
	</style>
@endpush

<div class="in-offerta-container">
	<div class="monete-wrapper">
        <picture>
            <source srcset="/images/monete2.webp" type="image/webp">
            <img class="monete-img" src="/images/monete2.png"
                alt="Monete da collezione"
                loading="lazy" decoding="async" width="561" height="371">
        </picture>
    </div> 
	<div class="in-offerta-text-container ">
		<div class="in-offerta-text-container-inner">
			<div class="in-offerta-text-container-inner-title">
				{{ __('home.in-offerta') }}
			</div>
			<div class="in-offerta-text-container-inner-text">
				{!! __('home.in-offerta-testo') !!}

				<div class="in-offerta-text-container-inner-arrow">
					@php
						$offersCategory = \App\Models\Category::find(969);
						$categoryLink = $offersCategory ? $offersCategory->translated_link : 'catalogo';
					@endphp
					<a href="{{ url(current_locale_prefix() . $categoryLink) }}" style="text-decoration:none; color:inherit;">
						<div style="display:flex; gap:7px; align-items:center;" class="guarda-nuovi-container">
							<x-icon name="freccia-destra" class="freccia-guarda-nuovi"/>
							<div class="guarda-nuovi">
								{!! __('home.guarda-tutte-le-offerte') !!}
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div style="width:50%;"></div>
	</div>
</div>

@push('scripts')
	<script>
		document.addEventListener("DOMContentLoaded", function() {

			const image = document.querySelector(".monete-img");

			const observer = new IntersectionObserver(entries => {
				entries.forEach(entry => {
					if(entry.isIntersecting){
						setTimeout(() => {
							image.classList.add("active");
						}, 400);
					}
				});
			}, {
				threshold: 0.3
			});

			observer.observe(image);

		});
	</script>
@endpush

@push('styles')
	<style>
		.slidePrezzo{
			display:flex;
			flex-direction:column;
			gap:0px;
		}
		.slidePrezzoFinale{
			font-weight:600;
			font-size:25px;
			line-height:20px;
			display:flex;
			justify-content:space-between;
			align-items:center;
			margin-bottom:5px;
		}
		.slidePrezzoBarrato{
			font-size:15px;
			text-decoration: line-through;
			color:var(--blackLight);
		}
		.agg-carrello{
			width:21px;
			height:24px;
			color:var(--black);
			cursor:pointer;
			transition:color 0.4s ease;
		}
		.agg-carrello:hover{
			color:var(--red);
		}
	</style>
@endpush

<div id="carousel3" class="generalMargin">
	<div style="position:relative; width:100%; display:flex; justify-content:space-between; gap:60px">
		<div class="carousel-wrapper"  data-slides="5" style="width:100%;">
			<div class="carousel">
				<div class="carousel-track">
					@foreach($offertProducts as $product)
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
						<div class="slide slide3">
							<a href="{{ $product->url }}" title="{{ $product->title }} - {{ __('home.in-offerta') }}">
								<div class="slideImgContainer">
									<img src="{{ product_image_url($product->image, 'thumb') }}" alt="{{ image_alt($product->title, __('home.in-offerta')) }}" loading="lazy" width="{{ $productThumbWidth }}" height="{{ $productThumbHeight }}">
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
									{!! $product->name !!}
								</div>
							</div>							
							<div class="slidePrezzo">
								<div class="slidePrezzoFinale">
									<span>{{ $product->formatted_final_price }}</span>
									<div class="add-to-cart-btn" data-id="{{ $product->entity_id }}">
										<x-icon name="icona-agg-carrello" class="agg-carrello"/>
									</div>
								</div>
								<div class="slidePrezzoBarrato">
									 {{ $product->formatted_original_price }}
								</div>
							</div>
							<a href="{{ $product->url }}" title="{{ $product->title }} - {{ __('home.in-offerta') }}">
								<div class="morButton morButton2" style="margin-top:20px;">
									<span class="morButtonTxt">{{ __('general.scopri-di-piu') }}</span>
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
	</div>
</div>