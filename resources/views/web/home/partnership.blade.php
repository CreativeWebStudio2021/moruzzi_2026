@php
	$partnersRow1 = [
		['src' => 'images/loghi/ifsda3.png', 'label' => 'International Federation of Stamp Dealers Associations', 'width' => 400, 'height' => 400],
		['src' => 'images/loghi/nip3.png', 'label' => 'Numismatici Italiani Professionisti', 'width' => 400, 'height' => 400],
		['src' => 'images/loghi/confesercenti2.png', 'label' => 'Confesercenti', 'width' => 400, 'height' => 400],
		['src' => 'images/loghi/cinoa2.png', 'label' => "Confederazione Internazionale dei Mercanti d'Arte e d'Antiquariato", 'width' => 400, 'height' => 400],
	];
	$partnersRow2 = [
		['src' => 'images/loghi/IAPN.png', 'label' => 'International Association of Professional Numismatists', 'width' => 300, 'height' => 300],
		['src' => 'images/loghi/socnumit.png', 'label' => 'Società Numismatica Italiana', 'width' => 400, 'height' => 400],
		['src' => 'images/loghi/fenap2.png', 'label' => 'Federation of European Numismatic Trade Associations', 'width' => 141, 'height' => 141],
		['src' => 'images/loghi/Munzenverband.png', 'label' => 'Berufsverband des Deutschen Münzenfachhandels', 'width' => 260, 'height' => 260],
		['src' => 'images/loghi/The_Royal_Numismatic_Society.png', 'label' => 'The Royal Numismatic Society', 'width' => 300, 'height' => 300],
	];
@endphp

<style>
	.logoPartner-img{
		width:100%;
		height:auto;
		max-width:100%;
		object-fit:contain;
		display:block;
		transition: transform 0.28s ease, opacity 0.28s ease;
	}

	.partner-logo{
		position:relative;
		display:flex;
		justify-content:center;
		align-items:center;
		width:100%;
	}

	.partner-logo:hover .logoPartner-img,
	.partner-logo:focus-within .logoPartner-img{
		transform: scale(1.04);
		opacity: 0.82;
	}

	.partner-logo::after{
		content: attr(data-tooltip);
		position:absolute;
		left:50%;
		bottom:calc(100% + 10px);
		transform:translateX(-50%) translateY(6px);
		min-width:140px;
		max-width:220px;
		padding:8px 10px;
		border-radius:4px;
		background:rgba(0, 0, 0, 0.88);
		color:#fff;
		font-family:'Inria Sans', sans-serif;
		font-size:12px;
		font-weight:400;
		line-height:1.35;
		text-align:center;
		white-space:normal;
		pointer-events:none;
		opacity:0;
		visibility:hidden;
		transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease;
		z-index:3;
	}

	.partner-logo::before{
		content:'';
		position:absolute;
		left:50%;
		bottom:calc(100% + 4px);
		transform:translateX(-50%) translateY(6px);
		border:6px solid transparent;
		border-top-color:rgba(0, 0, 0, 0.88);
		pointer-events:none;
		opacity:0;
		visibility:hidden;
		transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease;
		z-index:3;
	}

	.partner-logo:hover::after,
	.partner-logo:hover::before,
	.partner-logo:focus-within::after,
	.partner-logo:focus-within::before{
		opacity:1;
		visibility:visible;
		transform:translateX(-50%) translateY(0);
	}

	.partnership-text-container{
		width:28%;
		display:flex;
		flex-direction:column;
		gap:35px;
	}
	.partnership-logo-container{
		width:60%;
		display:flex;
		flex-direction:column;
		gap:55px;
		margin-top:65px;
	}
	.partnership-container{
		display:flex;
		justify-content:space-between;
		padding-bottom:80px;
	}
	.partnership-logos-row{
		display:flex;
		justify-content:space-between;
	}
	.partnership-logos-row--top{
		gap:45px;
	}
	.partnership-logos-row--bottom{
		gap:65px;
	}
	.partnership-logo-slot--top{
		width:25%;
		display:flex;
		justify-content:center;
	}
	.partnership-logo-slot--bottom{
		width:20%;
		display:flex;
		justify-content:center;
	}
	@media (max-width: 900px) {
		.partnership-container{
			flex-direction:column;
			gap:20px;
		}
		.partnership-text-container{
			width:100%;
		}
		.partnership-logo-container{
			width:100%;
		}
	}
	@media (hover: none) {
		.partner-logo:active::after,
		.partner-logo:active::before{
			opacity:1;
			visibility:visible;
			transform:translateX(-50%) translateY(0);
		}
	}
</style>

<div class="generalMargin partnership-container">
	<div class="partnership-text-container">
		<span style="font-family:'Inria Serif'; font-size:50px; color:var(--red); font-weight:300; font-style:italic; line-height:45px;">
			{!! __('home.partnership-titolo') !!}
		</span>
		<span style="text-align:justify;">
			{{ __('home.partnership-testo') }}
		</span>
	</div>
	<div class="partnership-logo-container">
		<div class="partnership-logos-row partnership-logos-row--top">
			@foreach ($partnersRow1 as $logo)
				<div class="partnership-logo-slot--top">
					<div class="partner-logo" data-tooltip="{{ $logo['label'] }}" tabindex="0">
						<img src="{{ asset($logo['src']) }}" alt="{{ image_alt($logo['label']) }}" class="logoPartner-img" loading="lazy" width="{{ $logo['width'] }}" height="{{ $logo['height'] }}">
					</div>
				</div>
			@endforeach
		</div>
		<div class="partnership-logos-row partnership-logos-row--bottom">
			@foreach ($partnersRow2 as $logo)
				<div class="partnership-logo-slot--bottom">
					<div class="partner-logo" data-tooltip="{{ $logo['label'] }}" tabindex="0">
						<img src="{{ asset($logo['src']) }}" alt="{{ image_alt($logo['label']) }}" class="logoPartner-img" loading="lazy" width="{{ $logo['width'] }}" height="{{ $logo['height'] }}">
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
