<style>
	.iconContainer{
		margin-bottom:0;
		display:flex;
		gap:150px;
		justify-content:center;
		padding-bottom:15px;
	}
	.icona-scudo, .icona-carrello, .icona-spedizione{
		color:#fff;
	}
	.icona-scudo{
		width:36px; height:38px;
		margin-top:14px;
	}
	.icona-carrello{
		width:39px; height:40px;
		margin-top:13px;
	}
	.icona-spedizione{
		width:61px; height:36px;
		margin-top:15px;
	}
	@media (max-width: 1300px) {
		.iconContainer{
			gap:0px;
			justify-content:space-between;
		}
	}
</style>
<div style="width:100%;  background:var(--red);">
	<div class="generalMargin iconContainer">
		<div style="display:flex; gap:20px; ">			
			<x-icon name="scudo" class="icona-scudo"/>
			<div style="display:flex; flex-direction:column; gap:0px; margin-top:15px;">
				<span style="font-weight:600; font-size:15px; color:#fff;">
					{{ __('home.banner-pagamenti-sicuri-titolo') }}
				</span>
				<span style="font-size:15px; color:#fff;">
					{!! __('home.banner-pagamenti-sicuri-testo') !!}
				</span>
			</div>
		</div>
		<div style="display:flex; gap:20px;">			
			<x-icon name="cestino" class="icona-carrello"/>
			<div style="display:flex; flex-direction:column; gap:0px; margin-top:15px;">
				<span style="font-weight:600; font-size:15px; color:#fff;">
					{{ __('home.banner-spedizione-titolo') }}
				</span>
				<span style="font-size:15px; color:#fff;">
					{{ __('home.banner-spedizione-testo') }}
				</span>
			</div>
		</div>
		<div style="display:flex; gap:20px;">			
			<x-icon name="spedizione" class="icona-spedizione"/>
			<div style="display:flex; flex-direction:column; gap:0px; margin-top:15px;">
				<span style="font-weight:600; font-size:15px; color:#fff;">
					{{ __('home.banner-spedizione-veloce-titolo') }}
				</span>
				<span style="font-size:15px; font-weight:300; color:#fff;">
					{{ __('home.banner-spedizione-veloce-testo') }}
				</span>
			</div>
		</div>
	</div>
</div>