<style>
	.footer-top {
		background: var(--red);
		padding: 30px 0;
		color: #fff;
	}
	.footer-top-inner {
		margin: var(--generalMargin);
		display: flex;
		flex-wrap: wrap;
		gap: 30px;
	}
	.footer-col {
		flex: 1 1 220px;
		min-width: 220px;
	}
	.footer-logo img {
		width: 150px;
		height: auto;
		display: block;
	}
	.footer-social {
		display: flex;
		gap: 12px;
		margin-top: 14px;
	}
	.footer-social a {
		color: #fff;
		opacity: 0.9;
	}
	.footer-menu {
		display: flex;
		flex-direction: column;
		gap: 8px;
		font-family: 'DM Mono';
		font-size: 14px;
	}
	.footer-menu a {
		color: #fff;
		text-decoration: none;
		white-space: nowrap;
	}
	.footer-menu a:hover {
		text-decoration: underline;
	}
	.footer-contact-title {
		font-family: 'DM Mono';
		font-size: 14px;
		margin-bottom: 8px;
	}
	.footer-contact-block {
		margin-bottom: 6px;
	}
	.footer-contact-block span {
		display: block;
	}
	.footer-bottom {
		background: var(--black);
		padding: 10px 0;
		color: #fff;
	}
	.footer-bottom-inner {
		margin: var(--generalMargin);
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 20px;
		flex-wrap: wrap;
	}
	.footer-bottom-left a {
		color: #fff;
		text-decoration: none;
		white-space: nowrap;
	}
	.footer-bottom-left a:hover {
		text-decoration: underline;
	}
	.footer-bottom-right {
		display: flex;
		gap: 20px;
		flex-wrap: wrap;
	}
	.footer-bottom-right a {
		color: #fff;
		text-decoration: none;
		white-space: nowrap;
	}
	.footer-bottom-right a:hover {
		text-decoration: underline;
	}

	/* 4 colonne desktop, 2 tablet, 1 mobile */
	@media (min-width: 1200px) {
		.footer-col {
			flex: 1 1 calc(25% - 30px);
		}
	}
	/* Layout a 2 colonne: a sinistra logo + menu (3 blocchi uno sotto l'altro), a destra solo contatti */
	@media (max-width: 991px) and (min-width: 601px) {
		.footer-top-inner {
			gap: 24px 40px;
			display: grid;
			grid-template-columns: minmax(0, 2fr) minmax(0, 1.2fr);
		}
		.footer-col {
			flex: none;
			min-width: 0;
		}
		.footer-top-inner .footer-col:nth-child(-n+3) {
			grid-column: 1 / 2;
		}
		.footer-top-inner .footer-col:nth-child(4) {
			grid-column: 2 / 3;
			grid-row: 1 / span 3;
		}
	}
	@media (max-width: 600px) {
		.footer-top-inner {
			display: block;
		}
		.footer-col {
			flex: 1 1 100%;
			min-width: 0;
			text-align: center;
		}
		.footer-logo img {
			margin: 0 auto;
		}
		.footer-social {
			justify-content: center;
		}
		.footer-bottom-inner {
			flex-direction: column;
			align-items: center;
			text-align: center;
		}
	}
</style>

<div class="footer-top">
	<div class="footer-top-inner">
		<div class="footer-col footer-logo">
			<a href="{{ locale_route('home') }}" title="{{ config('app.name') }}">
				<img src="{{ asset('images/Logo_Moruzzi_Bianco.svg') }}" alt="Moruzzi Numismatica" width="200" height="60">
			</a>
			<div class="footer-social" style="padding-bottom:20px;">
				<a href="https://www.facebook.com/moruzzi.numismatica" target="_blank" rel="noopener" title="Facebook" style="color:#fff; opacity:0.9;">
				<x-icon name="facebook" class="footer-socialItem"/>
				</a>
				<a href="https://x.com/Moruzzi_Monete" target="_blank" rel="noopener" title="X" style="color:#fff; opacity:0.9;">
					<x-icon name="x-footer" class="footer-socialItem"/>
				</a>
				<a href="https://www.instagram.com/moruzzi_numismatica/?hl=it" target="_blank" rel="noopener" title="Instagram" style="color:#fff; opacity:0.9;">
					<x-icon name="instagram-footer" class="footer-socialItem"/>
				</a>
				<a href="https://whatsapp.com/channel/0029Vb67PHi8qIzvmq7jS93x" target="_blank" rel="noopener" title="WhatsApp" style="color:#fff; opacity:0.9;">
					<x-icon name="whatsapp" class="footer-socialItem"/>
				</a>
			</div>
		</div>

		<div class="footer-col">
			<div class="footer-menu">
				<a href="">{{ __('menu.chi-siamo') }}</a>
				<a href="">{{ __('menu.categorie') }}</a>
				<a href="" style="padding-bottom:10px;">{{ __('menu.offerte') }}</a>
			</div>
		</div>

		<div class="footer-col">
			<div class="footer-menu">
				<a href="">{{ __('menu.certificazione') }}</a>
				<a href="{{ locale_route('sell.how') }}">{{ __('menu.vendere') }}</a>
				<a href="{{ locale_route('contact.form') }}" style="padding-bottom:20px;">{{ __('menu.contatti') }}</a>
			</div>
		</div>

		<div class="footer-col">
			<div class="footer-contact-block">
				<span style="font-size:1.2em; padding-bottom:10px;">Moruzzi Numismatica</span>
				<span>Viale dei Salesiani, 12a</span>
				<span>00175 Roma</span>
			</div>
			<div class="footer-contact-block">
				<span>+39 0671510220</span>
				<span>+39 0671545937</span>
			</div>
			<div class="footer-contact-block">
				<span>P.IVA 01614081006</span>
			</div>
		</div>
	</div>
</div>

<div class="footer-bottom">
	<div class="footer-bottom-inner">
		<div class="footer-bottom-left">
			<a href="https://www.creativewebstudio.it" target="_blank" rel="noopener" title="Creative Web Studio - Web Agency Civitavecchia">
				Creative Web Studio 2026
			</a>
		</div>
		<div class="footer-bottom-right">
			<a href="{{ locale_route('legal.privacy') }}">{{ __('seo.privacy_policy') }}</a>
			<a href="{{ locale_route('legal.cookie_policy') }}">{{ __('seo.cookie_policy') }}</a>
			<a href="#" class="iubenda-cs-preferences-link">{{ __('seo.cookie_preferences') }}</a>
			<a href="{{ locale_route('sitemap') }}">{{ __('seo.sitemap') }}</a>
		</div>
	</div>
</div>