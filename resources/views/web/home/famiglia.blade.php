<style>
	.famiglia-panel{
		position:relative;
		min-height:420px;
		padding:115px 30px 48px;
		display:flex;
		flex-direction:column;
		gap:30px;
	}

	.famiglia-titolo{
		font-family:'DM Mono';
		font-size:50px;
		color:#fff;
		font-weight:300;
		font-style:italic;
		line-height:45px;
	}

	.famiglia-text-container{
		width:600px;
		max-width:100%;
		color:#fff;
		font-family:Commissioner;
		font-weight:300;
		text-align:justify;
		flex:1;
	}

	.famiglia-text-container-button{
		display:flex;
		width:600px;
		max-width:100%;
		justify-content:flex-end;
		margin-top:auto;
	}
	@media (max-width: 1400px) {
		.famiglia-text-container-inner{
			top:80px;
		}
	}
	@media (max-width: 1200px) {
		.famiglia-text-container,
		.famiglia-text-container-button{
			width:100%;
		}
	}
	@media (max-width: 700px) {
		.famiglia-titolo{
			font-size:32px;
			line-height:30px;
		}
		.famiglia-panel{
			padding-top:80px;
			padding-bottom:40px;
		}
	}
</style>
<div style="padding:80px 0px 60px;">
	<div class="generalMargin">
		<div style="position:relative; width:100%;">
			<img src="{{ asset('images/pantheon.png') }}" alt="{{ __('seo.img_home_pantheon') }}" loading="lazy" decoding="async" width="1255" height="602" style="position:absolute; z-index:-1; width:100%; height:100%; object-fit:cover;"/>
			<div class="famiglia-text-container-inner">
				<div class="famiglia-panel">
					<span class="famiglia-titolo">
						{!! __('home.famiglia-titolo') !!}
					</span>
					<span class="famiglia-text-container">
						{!! __('home.famiglia-testo') !!}
					</span>
					<div class="famiglia-text-container-button">
						<a href="{{ locale_route('about.presentation') }}">
							<div class="morButton morButton2 morButtonWhite">
								<span class="morButtonTxt">{{ __('general.scopri-di-piu') }}</span>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>