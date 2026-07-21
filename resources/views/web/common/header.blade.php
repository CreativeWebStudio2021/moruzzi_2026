<style>
	/* HEADER */
	.header{
		position: relative;
		z-index: 1000;
		background:var(--background);
		transition: all 0.4s ease;
		overflow: visible;
	}
	.header.sticky {
		position: fixed;
		width:100%;
		top: 0;
		left: 0;
		box-shadow: 0 5px 15px rgba(0,0,0,0.05);
	}
	/* Sfondo lievemente trasparente quando header è sticky ridotto (scrolled) */
	.header.sticky.scrolled {
		background: rgba(231, 224, 212, 0.95);
	}
	
	.headerInner,
	.menu,
	.menuBox,
	.logoHeader,
	.socialBox {
		transition: all 0.4s ease;
	}

	.headerInner{
		display:flex;
		justify-content: space-between;		
	}
	.logoHeader{
		width:280px;
	}
	.socialBox{
		display:flex;
		flex:1;
		gap:5px;
		align-items: flex-end;
	}
	.socialBoxLeft{	
		justify-content: start;
	}
	.socialBoxCenter{
		justify-content: center;
	}
	.socialBoxRight{
		justify-content: end;
	}
	.socialItem{
		width:25px; 
		height:25px;
		color:var(--black);
		transition:color 0.3s ease;
	}
	.socialItem:hover{
		color:var(--red);
	}
	
	.footer-socialItem{
		width:25px; 
		height:25px;
		color:#fff;
		transition:opacity 0.3s ease;
	}
	.footer-socialItem:hover{
		opacity:0.7;
	}
	.chevron-down{
		margin-left:5px; 
		width:8px
	}
	.user-icon{
		width:17px;
		height:20px;
		color:var(--black);
		transition:color 0.3s ease;
	}
	.user-icon:hover{
		color:var(--red);
	}
	.cestino-icon{
		width:20px;
		height:20px;
		color:var(--black);
		transition:color 0.3s ease;
	}
	.cestino-icon:hover{
		color:var(--red);
	}
	
	/* STATO SCROLL */

	.header.scrolled .logoHeader{
		width:180px;
	}
	.header.scrolled .headerInner{
		align-items:center
	}

	.header-desktop-wrap,
	.headerInner,
	.socialBox,
	.socialBoxRight,
	.cambioLingua {
		overflow: visible;
	}

	.header-desktop-wrap {
		position: relative;
		z-index: 1200;
	}

	.cambioLingua {
		z-index: 1400;
	}

</style>
<div class="header-spacer" style="width:100%; height:220px;"></div>
<div class="header sticky">
	<div class="generalMargin header-desktop-wrap">
		<div class="headerInner">
			<div class="socialBox socialBoxLeft">			
				<a href="https://www.facebook.com/moruzzi.numismatica" target="_blank" title="">
					<x-icon name="facebook" class="socialItem"/>
				</a>
				<a href="https://x.com/Moruzzi_Monete" target="_blank" title="">
					<x-icon name="x" class="socialItem"/>
				</a>
				<a href="https://www.instagram.com/moruzzi_numismatica/?hl=it" target="_blank" title="">
					<x-icon name="instagram" class="socialItem"/>			
				</a>
				<a href="https://whatsapp.com/channel/0029Vb67PHi8qIzvmq7jS93x" target="_blank" title="">
					<x-icon name="whatsapp" class="socialItem"/>
				</a>
			</div>
			<a href="{{ locale_route('home') }}" class="socialBox socialBoxCenter">
				<img src="{{ asset('images/Logo_Moruzzi_Orizz.svg') }}" alt="Moruzzi Numismatica" class="logoHeader" width="200" height="60">
			</a>
			<div class="socialBox socialBoxRight">			
				<div class="cambioLingua" style="position:relative; width:45px; height:20px; display:flex; margin-top:-5px; cursor:pointer;">
					@php
						$languages = [
							'it' => ['label' => 'Italiano',  'flag' => 'it.svg'],
							'en' => ['label' => 'English',   'flag' => 'gb.svg'],
							'fr' => ['label' => 'Français',  'flag' => 'fr.svg'],
							'es' => ['label' => 'Español',   'flag' => 'es.svg'],
							'de' => ['label' => 'Deutsch',   'flag' => 'de.svg'],
						];
					@endphp
					<img src="{{ asset('images/flags/'.$languages[app()->getLocale()]['flag']) }}" width="28" height="20" style="height:20px;" alt="{{ image_alt($languages[app()->getLocale()]['label'] ?? '', __('seo.img_flag')) }}"/>
					<x-icon name="chevron-down" class="chevron-down"/>
					
					<style>
						.lingueBox{
							position:absolute;
							top:calc(100% + 10px);
							bottom:auto;
							left:0;
							width:130px;
							background:white;
							box-shadow:0 4px 12px rgba(0,0,0,0.12);
							border-radius:4px;
							visibility:hidden;
							opacity:0;
							transform:translateY(-6px);
							transition:opacity 0.25s ease, transform 0.25s ease, visibility 0.25s ease;
							z-index:1400;
							pointer-events:none;
						}
						.lingueBox.active{
							visibility:visible;
							opacity:1;
							transform:translateY(0);
							pointer-events:auto;
						}
						.lingueBoxMobile {
							position: absolute;
							top: 100%;
							left: 0;
							margin-top: 6px;
							width: 130px;
							background: white;
							box-shadow: 0 4px 12px rgba(0,0,0,0.15);
							border-radius: 4px;
							visibility: hidden;
							opacity: 0;
							transition: all 0.25s ease;
							z-index: 1400;
							pointer-events: none;
						}
						.lingueBoxMobile.active {
							visibility: visible;
							opacity: 1;
							pointer-events: auto;
						}
						@media (min-width: 993px) {
							.lingueBoxMobile { display: none !important; }
						}
					</style>
					<div class="lingueBox">
						<div style="width:100%;">
							<div style="padding:10px;">
								@foreach($languages as $code => $lang)

									<a href="{{ localized_url($code) }}"
									   style="text-decoration:none; color:inherit;">

										<div style="display:flex; gap:15px; align-items:center; 
													{{ app()->getLocale() === $code ? 'opacity:0.4;' : '' }}">

											<img src="{{ asset('images/flags/'.$lang['flag']) }}"
												 width="28"
												 height="20"
												 style="height:20px;"
												 alt="{{ image_alt($lang['label']) }}"/>

											<span style="font-style:italic; font-size:14px;">
												{{ $lang['label'] }}
											</span>

										</div>

									</a>
									@if($lang['label'] != "Deutsch")
										<div style="height:10px;"></div>
									@endif

								@endforeach							
							</div>
						</div>
					</div>
					<script>
						document.addEventListener('DOMContentLoaded', function() {

							const cambioLingua = document.querySelector('.header-desktop-wrap .cambioLingua:not(.cambioLinguaMobile)');
							const lingueBox = document.querySelector('.header-desktop-wrap .lingueBox:not(.lingueBoxMobile)');

							if (!cambioLingua || !lingueBox) return;

							cambioLingua.addEventListener('click', function(e) {
								if (e.target.closest('a[href]')) {
									return;
								}
								e.stopPropagation();
								e.preventDefault();
								lingueBox.classList.toggle('active');
							});
							
							document.addEventListener('click', function(e) {
								if (!lingueBox.contains(e.target) && !cambioLingua.contains(e.target)) {
									lingueBox.classList.remove('active');
								}
							});

						});
					</script>
				</div>
				
				<div id="userIcon" class="headerUserIcon" style="transform:translateY(5px); cursor:pointer;">
					<x-icon name="user" class="user-icon"/>
				</div>
				
				<div id="cartIcon" class="headerCartIcon" style="transform:translateY(5px); position:relative; cursor:pointer;">
					<x-icon name="cestino" class="cestino-icon"/>

					<div id="cartCount" class="cartCount">
						<span class="spinner"></span>
					</div>
				</div>		
			</div>
		</div>
	</div>
	
	<style>	
		.cartCount{
			position:absolute; 
			width:15px; 
			height:15px; 
			top:-7px; 
			right:-8px; 
			border-radius:8px; 
			background:var(--red); 
			color:#fff; 
			display:flex; 
			justify-content:center; 
			align-items:center;
			font-size:10px;
		}
		.spinner {
			width: 10px;
			height: 10px;
			border: 2px solid white;
			border-top: 2px solid transparent;
			border-radius: 50%;
			animation: spin 0.8s linear infinite;
		}

		@keyframes spin {
			to { transform: rotate(360deg); }
		}
		
		.add-to-cart-btn.loading {
			opacity: 0.5;
			pointer-events: none;
		}
		/* MENU */
		.menu{
			display:flex;
			justify-content: space-between;	
			align-items:center;	
			padding-top:10px; 
			font-family:'Inria Serif';
			position:relative;
			z-index:1100;
		}
		.menuBox{
			flex:1;
			display:flex;
			align-items:center;
			gap:28px;
			font-size:15px;
		}
		.menuBox a{
			font-weight: 400;
			font-style: normal;
			white-space:nowrap;
		}
		.menuBox a:hover{
			font-weight: 700;
			font-style: italic;
		}
		.menuBoxLeft{	
			justify-content:flex-start;
		}
		.menuBoxLeft > .menu-about-wrapper,
		.menuBoxLeft > a,
		.menuBoxRight > .menu-cert-wrapper,
		.menuBoxRight > .menu-sell-wrapper,
		.menuBoxRight > .menu-guide-wrapper,
		.menuBoxRight > a{
			flex:0 0 auto;
		}
		.menu-about-toggle,
		.menu-cert-toggle,
		.menu-sell-toggle,
		.menu-guide-toggle{
			white-space:nowrap;
		}
		/* Sottomenu "Chi siamo" */
		.menu-about-wrapper{
			position:relative;
		}
		.menu-about-toggle{
			display:flex;
			align-items:center;
			gap:4px;
			background:none;
			border:none;
			padding:0;
			font:inherit;
			cursor:pointer;
		}
		.menu-about-toggle:hover{
			font-weight:700;
			font-style:italic;
		}
		.menu-about-submenu{
			position:absolute;
			top:120%;
			left:0;
			min-width:220px;
			background:#fff;
			box-shadow:0 4px 12px rgba(0,0,0,0.15);
			border-radius:4px;
			padding:8px 0;
			visibility:hidden;
			opacity:0;
			transform:translateY(6px);
			transition:all 0.25s ease;
			z-index:1200;
		}
		.menu-about-submenu.active{
			visibility:visible;
			opacity:1;
			transform:translateY(0);
		}
		.menu-about-submenu a{
			display:block;
			padding:8px 14px;
			white-space:nowrap;
			text-decoration:none;
			color:var(--black);
			font-family:'Inria Sans', sans-serif;
			font-size:14px;
		}
		.menu-about-submenu a:hover{
			background:var(--background);
			color:var(--red);
		}
		.menu-about-submenu a.active{
			background:var(--background);
			color:var(--red);
			font-weight:600;
		}
		/* Sottomenu "Guida al collezionismo" */
		.menu-guide-wrapper{
			position:relative;
		}
		.menu-guide-toggle{
			display:flex;
			align-items:center;
			gap:4px;
			background:none;
			border:none;
			padding:0;
			font:inherit;
			cursor:pointer;
			text-align:left;
		}
		.menu-guide-toggle:hover{
			font-weight:700;
			font-style:italic;
		}
		.menu-guide-submenu{
			position:absolute;
			top:120%;
			right:0;
			left:auto;
			min-width:300px;
			max-height:70vh;
			overflow-y:auto;
			background:#fff;
			box-shadow:0 4px 12px rgba(0,0,0,0.15);
			border-radius:4px;
			padding:8px 0;
			visibility:hidden;
			opacity:0;
			transform:translateY(6px);
			transition:all 0.25s ease;
			z-index:1200;
		}
		.menu-guide-submenu.active{
			visibility:visible;
			opacity:1;
			transform:translateY(0);
		}
		.menu-guide-submenu a{
			display:block;
			padding:8px 14px;
			white-space:normal;
			text-decoration:none;
			color:var(--black);
			font-family:'Inria Sans', sans-serif;
			font-size:14px;
			line-height:1.35;
		}
		.menu-guide-submenu a:hover{
			background:var(--background);
			color:var(--red);
		}
		.menu-guide-submenu a.active{
			background:var(--background);
			color:var(--red);
			font-weight:600;
		}
		/* Sottomenu "Certificazioni" */
		.menu-cert-wrapper{
			position:relative;
		}
		.menu-cert-toggle{
			display:flex;
			align-items:center;
			gap:4px;
			background:none;
			border:none;
			padding:0;
			font:inherit;
			cursor:pointer;
		}
		.menu-cert-toggle:hover{
			font-weight:700;
			font-style:italic;
		}
		.menu-cert-submenu{
			position:absolute;
			top:120%;
			right:0;
			min-width:260px;
			background:#fff;
			box-shadow:0 4px 12px rgba(0,0,0,0.15);
			border-radius:4px;
			padding:8px 0;
			visibility:hidden;
			opacity:0;
			transform:translateY(6px);
			transition:all 0.25s ease;
			z-index:1200;
		}
		.menu-cert-submenu.active{
			visibility:visible;
			opacity:1;
			transform:translateY(0);
		}
		.menu-cert-submenu a{
			display:block;
			padding:8px 14px;
			white-space:nowrap;
			text-decoration:none;
			color:var(--black);
			font-family:'Inria Sans', sans-serif;
			font-size:14px;
		}
		.menu-cert-submenu a:hover{
			background:var(--background);
			color:var(--red);
		}
		.menu-cert-submenu a.active{
			background:var(--background);
			color:var(--red);
			font-weight:600;
		}
		/* Sottomenu "Vendere" */
		.menu-sell-wrapper{
			position:relative;
		}
		.menu-sell-toggle{
			display:flex;
			align-items:center;
			gap:4px;
			background:none;
			border:none;
			padding:0;
			font:inherit;
			cursor:pointer;
		}
		.menu-sell-toggle:hover{
			font-weight:700;
			font-style:italic;
		}
		.menu-sell-submenu{
			position:absolute;
			top:120%;
			right:0;
			min-width:240px;
			background:#fff;
			box-shadow:0 4px 12px rgba(0,0,0,0.15);
			border-radius:4px;
			padding:8px 0;
			visibility:hidden;
			opacity:0;
			transform:translateY(6px);
			transition:all 0.25s ease;
			z-index:1200;
		}
		.menu-sell-submenu.active{
			visibility:visible;
			opacity:1;
			transform:translateY(0);
		}
		.menu-sell-submenu a{
			display:block;
			padding:8px 14px;
			white-space:nowrap;
			text-decoration:none;
			color:var(--black);
			font-family:'Inria Sans', sans-serif;
			font-size:14px;
		}
		.menu-sell-submenu a:hover{
			background:var(--background);
			color:var(--red);
		}
		.menu-sell-submenu a.active{
			color:var(--red);
			font-weight:600;
		}
		.menuBoxCenter{
			justify-content: center;
		}
		.menuBoxCenter.searchContainer{
			position:absolute;
			left:50%;
			transform:translateX(-50%);
			flex:0 0 auto;
			z-index:1101;
		}
		.menuBoxRight{
			justify-content:flex-end;
		}
		.lente-icon{
			width:20px;
			height:20px;
			color:var(--black);
			cursor:pointer;
		}
		.cercaInput{
			width:calc(231px - 36px);
			padding:6px 32px 6px 6px; 
			border:none; 
			border-radius:20px;
			background:none; 
			font-family:"Fira Mono"; 
			font-size:14px; 
			font-weight:400;
			color:var(--black);
			cursor:pointer;
			transition:all 0.3s ease;
		}
		.searchWrapper {
			position:relative;
			cursor:pointer;
		}
		.searchWrapper:hover .cercaInput{
			background:var(--red); 
			border-radius:20px;
			color:#fff;
		}
		.searchWrapper:hover .cercaInput::placeholder {
			color: #fff;
		}
		.searchWrapper:hover .lente-icon {
			color: #fff;
		}
		
		.searchBox{
			width:235px; 
			border:solid 1px var(--black); 
			border-radius:20px;
			padding:2px; 
			display:none;
		}
		.searchBox.active{
			display:block;
		}
		
		.closeButton{
			width:28px; 
			border:solid 1px var(--black); 
			border-radius:16px;
			padding:1px; 
			cursor:pointer;
			display:none;
			transform:translateY(-10px);
		}
		.closeButton.active{
			display:block;
		}
		
		.searchContainer {
			/*transition: all 0.4s ease;*/
		}

		.header.scrolled .menu {
			padding-top:0px;
		}

	.header.scrolled .generalHeader {
		padding-top:10px;
	}

	/* ========== RESPONSIVE: sotto 1200px già gestito da layout (generalMargin) ========== */
	/* ========== MOBILE HEADER (max-width 992px) ========== */
	.header-desktop-wrap,
	.header-desktop.generalHeader {
		display: block;
	}
	.header-mobile {
		display: none;
	}
	@media (max-width: 992px) {
		.header-desktop-wrap,
		.header-desktop.generalHeader {
			display: none !important;
		}
		.header-mobile {
			display: block;
		}
		.header-mobile-row1 {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 0;
			gap: 12px;
		}
		.header-mobile .logo-mobile-link {
			flex-shrink: 0;
		}
		.header-mobile .logo-mobile-link img {
			width: 130px;
			object-fit: contain;
		}
		.header-mobile-right {
			display: flex;
			align-items: center;
			gap: 10px;
			overflow: visible;
			position: relative;
			z-index: 1400;
		}
		.header-mobile-right .cambioLingua {
			margin-top: 0;
			z-index: 1400;
		}
		.header-mobile-right .user-icon,
		.header-mobile-right .cestino-icon {
			width: 22px;
			height: 22px;
		}
		.hamburger-btn {
			background: none;
			border: none;
			padding: 8px;
			cursor: pointer;
			display: flex;
			flex-direction: column;
			justify-content: center;
			gap: 5px;
		}
		.hamburger-btn span {
			display: block;
			width: 22px;
			height: 2px;
			background: var(--black);
			transition: background 0.2s;
		}
		.hamburger-btn:hover span {
			background: var(--red);
		}
		
		.header.scrolled .header-mobile-row1 .logo-mobile-link img {
			width: 130px;
		}
	}

	</style>
	
	<div class="generalMargin generalHeader header-desktop">
		<div class="menu">
			<div class="menuBox menuBoxLeft">
				<div class="menu-about-wrapper">
					<button type="button" class="menu-about-toggle">
						<span>{{ __('menu.chi-siamo') }}</span>
						<x-icon name="chevron-down" class="chevron-down"/>
					</button>
					<div class="menu-about-submenu">
						@include('web.common.about-nav-links')
					</div>
				</div>
				<a href="#" class="openCategoriePanel">
					{{ __('menu.categorie') }}
				</a>
				@php
					$offersCategory = \App\Models\Category::find(969);
					$categoryLink = $offersCategory ? $offersCategory->translated_link : 'catalogo';
				@endphp
				<a href="{{ url(current_locale_prefix() . $categoryLink) }}">
					{{ __('menu.offerte') }}
				</a>
			</div>
			<div class="menuBox menuBoxCenter searchContainer">
				<div class="searchBox active">
					<div style="margin:1px">
						<div class="searchWrapper">
							<input type="text" class="cercaInput" placeholder="{{ __('menu.cerca-un-prodotto') }}" value="{{ request()->query('q', '') }}"/>
							<div style="position:absolute; top:4px; right:10px;width:20px; height:20px;">
								<x-icon name="lente" class="lente-icon"/>
							</div>
						</div>
					</div>
				</div>
				<div class="closeButton">
					<div style="margin:1px">
						<div style="position:relative; width:26px; height:26px; border-radius:13px; background:var(--red);">						
							<div style="position:absolute; left:5px; top:5px; color:#fff; width:16px; height:16px;cursor:pointer;">
								<x-icon name="close" class="close-icon"/>
							</div>				
							<div style="position:absolute; left:50%; transform:translateX(-50%); top:30px; font-size:18px;cursor:pointer; text-transform: uppercase;  font-family:'Inria Sans'">
								{{ __('menu.chiudi') }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="menuBox menuBoxRight">
				<div class="menu-cert-wrapper">
					<button type="button" class="menu-cert-toggle">
						<span>{{ __('menu.certificazione') }}</span>
						<x-icon name="chevron-down" class="chevron-down"/>
					</button>
					<div class="menu-cert-submenu">
						@include('web.common.certifications-nav-links')
					</div>
				</div>
				<div class="menu-sell-wrapper">
					<button type="button" class="menu-sell-toggle">
						<span>{{ __('menu.vendere') }}</span>
						<x-icon name="chevron-down" class="chevron-down"/>
					</button>
					<div class="menu-sell-submenu">
						@include('web.common.sell-nav-links')
					</div>
				</div>
				<div class="menu-guide-wrapper">
					<button type="button" class="menu-guide-toggle">
						<span>{{ __('guide.menu') }}</span>
						<x-icon name="chevron-down" class="chevron-down"/>
					</button>
					<div class="menu-guide-submenu">
						@include('web.common.guide-nav-links')
					</div>
				</div>
				<a href="{{ locale_route('contact.form') }}">
					{{ __('menu.contatti') }}
				</a>
			</div>
		</div>
	</div>

	{{-- Versione mobile: logo | lingue account carrello hamburger; poi riga ricerca --}}
	<div class="header-mobile">
		<div class="generalMargin header-mobile-row1">
			<a href="{{ locale_route('home') }}" class="logo-mobile-link">
				<img src="{{ asset('images/Logo_Moruzzi_Orizz.svg') }}" alt="Moruzzi Numismatica" width="200" height="60"/>
			</a>
			<div class="header-mobile-right">
				<div  class="searchWrapperMobile"style="position:relative; width:20px; height:20px; cursor:pointer; padding-right:5px;">	
					<x-icon name="lente" class="lente-icon-mobile"/>
				</div>
				<div class="cambioLingua cambioLinguaMobile" style="position:relative; width:45px; height:20px; display:flex; cursor:pointer;">
					<img src="{{ asset('images/flags/'.$languages[app()->getLocale()]['flag']) }}" width="28" height="20" style="height:20px;" alt="{{ image_alt($languages[app()->getLocale()]['label'] ?? '', __('seo.img_flag')) }}"/>
					<x-icon name="chevron-down" class="chevron-down"/>
					<div class="lingueBox lingueBoxMobile">
						<div style="padding:10px;">
							@foreach($languages as $code => $lang)
								<a href="{{ localized_url($code) }}" style="text-decoration:none; color:inherit;">
									<div style="display:flex; gap:15px; align-items:center; {{ app()->getLocale() === $code ? 'opacity:0.4;' : '' }}">
										<img src="{{ asset('images/flags/'.$lang['flag']) }}" width="28" height="20" style="height:20px;" alt="{{ image_alt($lang['label']) }}"/>
										<span style="font-style:italic; font-size:14px;">{{ $lang['label'] }}</span>
									</div>
								</a>
								@if($lang['label'] != "Deutsch")<div style="height:10px;"></div>@endif
							@endforeach
						</div>
					</div>
				</div>
				<div class="headerUserIcon" style="cursor:pointer;" title="{{ auth()->check() ? __('account.my_account') : __('auth.login') }}">
					<x-icon name="user" class="user-icon"/>
				</div>
				<div class="headerCartIcon" style="position:relative; cursor:pointer;">
					<x-icon name="cestino" class="cestino-icon"/>
					<div class="cartCount">
						<span class="spinner"></span>
					</div>
				</div>
				
				<button type="button" class="hamburger-btn" id="hamburgerBtn" aria-label="{{ __('menu.menu') }}">
					<span></span><span></span><span></span>
				</button>
			</div>
		</div>
	</div>
	
</div>

<style>
	.whiteMask{
		z-index:900;
		position:fixed; width:100%; 
		height:100vh; 
		background:#fff; 
		opacity:0; 
		top:0; 
		left:0; 
		transform:translateY(-100%);
		transition:all 1s ease;
	}
	.whiteMask.active{
		opacity:1;
		transform:translateY(0%);
	}
</style>
<div class="whiteMask"></div>

<style>
	.boxCerca {
		position:fixed;		
		z-index:950;
		width:100%;
		top:0;
		margin-top:250px;
		padding-top:20px;
		padding-bottom:20px;
		box-sizing:border-box;
		display:none;
		transition:opacity 1s ease;
	}
	.boxCerca.active{
		display:block;
	}
	.boxCercaMask{
		position:fixed;	
		z-index:955;
		top:0;
		left:0;
		width:100%; 
		height:100vh; 
		background:#fff; 
		opacity:0; 
		display:none;
		transition:opacity 1s ease;
	}
	.boxCercaMask.active{
		opacity:1; 
		display:block;
	}
	.boxCategorie {
		position:fixed;
		z-index:950;
		width:100%;
		top:0;
		margin-top:250px;
		display:none;
		transition:opacity 1s ease;
	}
	.boxCategorie.active {
		display:block;
	}
	.boxCategorieMask {
		position:fixed;
		z-index:955;
		top:0;
		left:0;
		width:100%;
		height:100vh;
		background:#fff;
		opacity:0;
		display:none;
		transition:opacity 1s ease;
	}
	.boxCategorieMask.active {
		opacity:1;
		display:block;
	}
	.boxCategorie .categorie-panel-inner {
		max-height: min(70vh, 600px);
		overflow-y: auto;
		padding-bottom: 40px;
		scrollbar-width: none;
		-ms-overflow-style: none;
	}
	.boxCategorie .categorie-panel-inner::-webkit-scrollbar {
		display: none;
	}
	.lente-icon2{
		width:20px;
		height:20px;
		color:var(--black);
		cursor:pointer;
		position:absolute;
		top:0px; 
		right:0px;
	}
	.search-results-wrapper{
		width:100%;
		max-height:min(400px, calc(100vh - 350px));
		overflow-y:auto;
		margin-top:30px;
		padding-right:10px;
	}
	.search-results-wrapper::-webkit-scrollbar{
		width:6px;
	}
	.search-results-wrapper::-webkit-scrollbar-thumb{
		background:rgba(0,0,0,0.2);
		border-radius:3px;
	}
	.search-results-list{
		width:100%;
	}
	.search-result-item{
		display:flex;
		gap:16px;
		align-items:flex-start;
		padding:10px 0;
		border-bottom:1px solid rgba(0,0,0,0.06);
	}
	.search-result-img{
		flex:0 0 100px;
		max-width:100px;
	}
	.search-result-img img{
		width:100%;
		height:100px;
		object-fit:contain;
		object-position:center;
		display:block;
	}
	.search-result-info{
		flex:1;
		min-width:0;
		display:flex;
		gap:5px;
		flex-direction:column;
		justify-content:center;
	}
	.search-result-title{
		margin:0 0 4px;
		font-size:15px;
		line-height:1.3;
		display:-webkit-box;
		-webkit-line-clamp:3;
		-webkit-box-orient:vertical;
		overflow:hidden;
	}
	.search-result-link{
		text-decoration:none;
		color:inherit;
	}
	.search-result-link:hover .search-result-title{
		color:var(--red);
	}
	.search-result-categories{
		display:flex;
		flex-wrap:wrap;
		gap:4px 8px;
		margin-bottom:4px;
	}
	.search-result-category{
		display:inline-block;
		padding:3px 8px;
		font-size:11px;
		text-decoration:none;
		color:var(--black);
		border-radius:12px;
		box-shadow:2px 2px 4px 0 rgb(0 0 0 / 0.25);
	}
	.search-result-category:hover{
		background:var(--background);
		box-shadow:0 2px 3px 0 rgb(0 0 0 / 0.25);
		color:var(--black);
	}
	.search-result-sku{
		font-size:12px;
		color:var(--blackLight);
		margin-bottom:4px;
	}
	.search-result-price{
		font-size:14px;
		color:var(--red);
	}
	.search-results-list .search-highlight{
		background-color:#ffeb3b;
	}
	.search-results-see-all{
		margin-top:15px;
		text-align:right;
	}
	.search-panel-layout{
		display:flex;
		gap:120px;
		align-items:flex-start;
	}
	.search-panel-left,
	.search-panel-right{
		min-width:0;
	}
	.search-panel-left{
		flex:0 0 65%;
	}
	.search-panel-right{
		flex:0 0 35%;
	}
	.search-family-list{
		width:calc(100% - 25px);
		margin-top:25px;
		margin-left:25px;
		display:flex;
		flex-direction:column;
		gap:12px;
	}
	.search-family-item{
		display:flex;
		gap:10px;
		align-items:center;
		cursor:pointer;
		font-size:14px;
	}
	.search-family-check{
		width:13px;
		height:13px;
		border:solid 1px var(--black);
		display:flex;
		align-items:center;
		justify-content:center;
	}
	.search-family-check-inner{
		width:9px;
		height:9px;
		background:transparent;
	}
	.search-family-item.active .search-family-check-inner{
		background:var(--red);
	}
	@media (max-width: 1024px){
		.search-panel-layout{
			gap:60px;
		}
	}
	@media (max-width: 768px){
		.search-panel-layout{
			flex-direction:column;
			gap:30px;
		}
		.search-panel-left,
		.search-panel-right{
			flex:0 0 100%;
		}
	}
	@media (max-width: 992px) {
		.boxCerca.active .search-overlay-close-mobile {
			display: flex !important;
		}
		.boxCerca {
			margin-top: 80px;
			max-height: calc(100vh - 80px);
			overflow-y: auto;
		}
	}
	@media (min-width: 993px) {
		.search-overlay-close-mobile { display: none !important; }
	}
</style>
<div class="boxCerca">
	<div class="boxCercaMask"></div>
	<button type="button" class="search-overlay-close-mobile" id="searchOverlayCloseMobile" aria-label="{{ __('menu.chiudi') }}" style="display:none; position:fixed; top:16px; right:16px; z-index:956; width:40px; height:40px; border-radius:50%; background:var(--red); color:#fff; border:none; cursor:pointer; align-items:center; justify-content:center; font-size:20px; line-height:1;">&times;</button>
		<div class="generalMargin search-panel-layout" style="position:relative; display:flex; gap:150px;">
		<div class="search-panel-left" style="display:flex; flex-direction:column;gap:25px;">
			<div style="font-size:50px; font-style:italic; line-height:40px; color:var(--black); font-weight:300;">
				{{ __('menu.cerca-un-prodotto') }}
				<div style="position:relative; width:100%; height:25px; margin-top:30px; border-bottom:solid 1px var(--black);">
					<input type="text" name="ricerca" style="position:absolute; top:0px; left:0px; width:calc(100% - 32px); padding-right:30px; border:none; height:20px; font-size:20px; font-family:'Fira Mono'; color:var(--black)" placeholder="{{ __('menu.comincia-a-scrivere') }}"/>
					<x-icon name="lente" class="lente-icon2"/>
				</div>
			</div>
			<div class="search-results-wrapper">
				<div id="search-results"></div>
			</div>
		</div>
		<div class="search-panel-right" style="display:flex; flex-direction:column;gap:25px;">
			<div style="font-size:30px; font-style:italic; color:var(--black); font-weight:300;">
				{{ __('menu.categorie') }}
			</div>
			<div class="search-family-list">
				<div class="search-family-item" data-family="monete">
					<div class="search-family-check">
						<div class="search-family-check-inner"></div>
					</div>
					<span>Monete</span>
				</div>
				<div class="search-family-item" data-family="medaglie">
					<div class="search-family-check">
						<div class="search-family-check-inner"></div>
					</div>
					<span>Medaglie</span>
				</div>
				<div class="search-family-item" data-family="banconote">
					<div class="search-family-check">
						<div class="search-family-check-inner"></div>
					</div>
					<span>Banconote</span>
				</div>
				<div class="search-family-item" data-family="pubblicazioni">
					<div class="search-family-check">
						<div class="search-family-check-inner"></div>
					</div>
					<span>Pubblicazioni</span>
				</div>
				<div class="search-family-item" data-family="antiquariato">
					<div class="search-family-check">
						<div class="search-family-check-inner"></div>
					</div>
					<span>Antiquariato</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="boxCategorie">
	<div class="boxCategorieMask"></div>
	<div class="generalMargin categorie-panel-inner" style="position:relative;">
		@include('web.common.categorie-content', ['tags' => $tags ?? collect(), 'categoryImageFallback' => true])
	</div>
</div>

{{-- Pannello menu mobile (slide da destra, come carrello) --}}
<style>
	.mobile-menu-overlay {
		position: fixed;
		inset: 0;
		background: rgba(0,0,0,0);
		opacity: 0;
		visibility: hidden;
		transition: opacity 0.3s ease, visibility 0.3s ease;
		z-index: 9998;
	}
	.mobile-menu-overlay.show {
		opacity: 1;
		visibility: visible;
		background: rgba(0,0,0,0.4);
	}
	.mobile-menu-panel {
		position: fixed;
		top: 0;
		right: 0;
		width: 320px;
		max-width: 100%;
		height: 100%;
		background: #fff;
		z-index: 9999;
		transform: translateX(100%);
		transition: transform 0.35s cubic-bezier(.4,0,.2,1);
		display: flex;
		flex-direction: column;
		box-shadow: -4px 0 20px rgba(0,0,0,0.1);
	}
	.mobile-menu-overlay.show .mobile-menu-panel {
		transform: translateX(0);
	}
	.mobile-menu-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 16px 20px;
		background: var(--red);
		color: #fff;
		flex-shrink: 0;
	}
	.mobile-menu-header .mobile-menu-title {
		font-family: 'Inria Serif', serif;
		font-size: 30px;
		font-style: italic;
	}
	.mobile-menu-close {
		background: none;
		border: none;
		color: #fff;
		font-size: 24px;
		cursor: pointer;
		padding: 4px;
		line-height: 1;
	}
	.mobile-menu-body {
		flex: 1;
		overflow-y: auto;
		padding: 12px 0;
		scrollbar-width: none;
		-ms-overflow-style: none;
	}
	.mobile-menu-body::-webkit-scrollbar {
		display: none;
	}
	.mobile-menu-body a,
	.mobile-menu-body .mobile-menu-accordion-toggle {
		display: block;
		padding: 14px 20px;
		font-family: 'Inria Sans', sans-serif;
		font-size: 16px;
		color: var(--black);
		text-decoration: none;
		border-bottom: 1px solid rgba(0,0,0,0.06);
		cursor: pointer;
		transition: background 0.2s;
	}
	.mobile-menu-body a:hover,
	.mobile-menu-body .mobile-menu-accordion-toggle:hover {
		background: var(--background);
	}
	.mobile-menu-accordion-toggle {
		display: flex;
		justify-content: space-between;
		align-items: center;
		width: 100%;
		text-align: left;
		background: none;
		border: none;
		font: inherit;
	}
	.mobile-menu-accordion-toggle .mobile-menu-chevron {
		flex-shrink: 0;
		margin-left: 12px;
		font-size: 12px;
		color: var(--black);
		transition: transform 0.25s ease;
	}
	.mobile-menu-accordion-toggle.open .mobile-menu-chevron {
		transform: rotate(180deg);
	}
	.mobile-menu-accordion-content {
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.3s ease;
		background: rgba(0,0,0,0.03);
	}
	.mobile-menu-accordion-content.open {
		max-height: 1200px;
	}
	.mobile-menu-accordion-content a {
		padding-left: 32px;
		font-size: 14px;
	}
	.mobile-menu-accordion-content a.active {
		background: var(--background);
		color: var(--red);
		font-weight: 600;
	}
	/* Albero categorie nel pannello mobile (stile catalog index: apri/chiudi) */
	.mobile-menu-panel .mobile-menu-categories-wrap {
		margin-bottom: 0;
	}
	.mobile-menu-panel .mobile-menu-categories-title {
		display: block;
		padding: 14px 20px;
		font-family: 'Inria Sans', sans-serif;
		font-size: 16px;
		color: var(--black);
		font-weight: 600;
	}
	.mobile-menu-panel .catalog-sidebar-item {
		margin-bottom: 0;
	}
	.mobile-menu-panel .catalog-sidebar-row {
		display: flex;
		align-items: center;
		padding: 10px 12px 10px 20px;
		border-bottom: 1px solid rgba(0,0,0,0.06);
		min-height: 44px;
		box-sizing: border-box;
	}
	.mobile-menu-panel .mobile-menu-categories-tree > .catalog-sidebar-item:first-child > .catalog-sidebar-row {
		border-top: 1px solid rgba(0,0,0,0.06);
	}
	.mobile-menu-panel .catalog-sidebar-row.active {
		background: var(--background);
	}
	.mobile-menu-panel .catalog-sidebar-link-inner {
		flex: 1;
		min-width: 0;
		text-decoration: none;
		color: var(--black);
		font-size: 15px;
	}
	.mobile-menu-panel .catalog-sidebar-link-inner:hover {
		color: var(--red);
	}
	.mobile-menu-panel .catalog-sidebar-toggle {
		border: none;
		background: none;
		cursor: pointer;
		color: var(--black);
		padding: 6px 8px;
		font-size: 1rem;
		flex-shrink: 0;
		min-width: 32px;
		min-height: 32px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
	}
	.mobile-menu-panel .catalog-sidebar-toggle:hover {
		color: var(--red);
	}
	.mobile-menu-panel .catalog-sidebar-children {
		overflow: hidden;
		max-height: 0;
		transition: max-height 0.4s ease;
	}
	.mobile-menu-panel .catalog-sidebar-children.is-expanded {
		max-height: none;
		overflow: visible;
	}
	.mobile-menu-panel .catalog-sidebar-row{
		padding:5px 6px;
	}
	.mobile-menu-panel .catalog-sidebar-link-inner{
		margin:0 0 0 20px;
		padding:0;
	}
	.mobile-menu-body a{
		border:none;
	}
</style>
<div class="mobile-menu-overlay" id="mobileMenuOverlay" aria-hidden="true">
	<div class="mobile-menu-panel">
		<div class="mobile-menu-header">
			<span class="mobile-menu-title">{{ __('menu.menu') }}</span>
			<button type="button" class="mobile-menu-close" id="mobileMenuClose" aria-label="{{ __('general.chiudi') }}">&times;</button>
		</div>
		<div class="mobile-menu-body">
			<button type="button" class="mobile-menu-accordion-toggle">
				<span>{{ __('menu.chi-siamo') }}</span>
				<i class="fa-solid fa-chevron-down mobile-menu-chevron" aria-hidden="true"></i>
			</button>
			<div class="mobile-menu-accordion-content">
				@include('web.common.about-nav-links')
			</div>
			@php
				$tagsMenu = $tags ?? collect();
				$baseMenu = current_locale_prefix();
			@endphp
			<div class="mobile-menu-categories-wrap">
				<span class="mobile-menu-categories-title">{{ __('menu.categorie') }}</span>
				<div class="mobile-menu-categories-tree" style="padding-left:10px;">
					@include('web.common.catalog-sidebar-tree', [
						'nodes' => $tagsMenu,
						'base' => $baseMenu,
						'idPrefix' => 'mobile-cat',
						'openIds' => [],
					])
				</div>
			</div>
			<a href="{{ url($baseMenu . 'catalogo') }}?offerte=1">{{ __('menu.offerte') }}</a>
			<button type="button" class="mobile-menu-accordion-toggle">
				<span>{{ __('menu.certificazione') }}</span>
				<i class="fa-solid fa-chevron-down mobile-menu-chevron" aria-hidden="true"></i>
			</button>
			<div class="mobile-menu-accordion-content">
				@include('web.common.certifications-nav-links')
			</div>
			<button type="button" class="mobile-menu-accordion-toggle">
				<span>{{ __('menu.vendere') }}</span>
				<i class="fa-solid fa-chevron-down mobile-menu-chevron" aria-hidden="true"></i>
			</button>
			<div class="mobile-menu-accordion-content">
				@include('web.common.sell-nav-links')
			</div>
			<button type="button" class="mobile-menu-accordion-toggle">
				<span>{{ __('guide.menu') }}</span>
				<i class="fa-solid fa-chevron-down mobile-menu-chevron" aria-hidden="true"></i>
			</button>
			<div class="mobile-menu-accordion-content">
				@include('web.common.guide-nav-links')
			</div>
			<a href="{{ locale_route('contact.form') }}">{{ __('menu.contatti') }}</a>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {

		const searchWrapper = document.querySelector('.searchWrapper');
		const whiteMask = document.querySelector('.whiteMask');
		const searchBox = document.querySelector('.searchBox');
		const closeButton = document.querySelector('.closeButton');
		const boxCerca = document.querySelector('.boxCerca');
		const boxCercaMask = document.querySelector('.boxCercaMask');
		const boxCategorie = document.querySelector('.boxCategorie');
		const boxCategorieMask = document.querySelector('.boxCategorieMask');
		const openCategoriePanel = document.querySelector('.openCategoriePanel');
		const searchInputOverlay = document.querySelector('.boxCerca input[name=\"ricerca\"]');
		const searchResults = document.getElementById('search-results');
		const cercaInputMenu = document.querySelector('.searchBox .cercaInput');
		const liveSearchUrl = '{{ locale_route('catalog.search') }}';
		const catalogIndexUrl = '{{ locale_route("catalog.index") }}';
		const familyItems = document.querySelectorAll('.search-family-item');
		let selectedFamily = null;
		let searchTimeout = null;
		let searchController = null;

		searchWrapper.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			if (typeof window.closeDesktopSubmenus === 'function') window.closeDesktopSubmenus();
			whiteMask.classList.add('active');
			closeButton.classList.add('active');
			searchBox.classList.remove('active');
			header.style.background="#fff";
			if (boxCategorie && boxCategorie.classList.contains('active')) {
				boxCategorie.classList.remove('active');
				if (boxCategorieMask) boxCategorieMask.classList.remove('active');
			}
			setTimeout(function() {
				boxCerca.classList.add('active');
				boxCercaMask.classList.add('active');
				if (searchInputOverlay) {
					if (cercaInputMenu && cercaInputMenu.value) {
						searchInputOverlay.value = cercaInputMenu.value.trim();
					}
					searchInputOverlay.focus();
					searchInputOverlay.select();
				}
			}, 800);
			setTimeout(function() {
				boxCercaMask.classList.remove('active');
			}, 850);
		});

		if (openCategoriePanel) {
			openCategoriePanel.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				if (typeof window.closeDesktopSubmenus === 'function') window.closeDesktopSubmenus();
				whiteMask.classList.add('active');
				closeButton.classList.add('active');
				searchBox.classList.remove('active');
				header.style.background="#fff";
				if (boxCerca && boxCerca.classList.contains('active')) {
					boxCerca.classList.remove('active');
					boxCercaMask.classList.remove('active');
				}
				setTimeout(function() {
					if (boxCategorie) boxCategorie.classList.add('active');
					if (boxCategorieMask) boxCategorieMask.classList.add('active');
				}, 800);
				setTimeout(function() {
					if (boxCategorieMask) boxCategorieMask.classList.remove('active');
					requestAnimationFrame(function() {
						document.dispatchEvent(new CustomEvent('categoriePanelOpened'));
					});
				}, 850);
			});
		}
		
		function closeSearchAndCategoriePanels() {
			closeButton.classList.remove('active');
			searchBox.classList.add('active');
			setTimeout(function() {
				if (boxCerca) {
					boxCerca.classList.remove('active');
					boxCercaMask.classList.remove('active');
				}
				if (boxCategorie) {
					boxCategorie.classList.remove('active');
					if (boxCategorieMask) boxCategorieMask.classList.remove('active');
				}
			}, 800);
			setTimeout(function() {
				header.style.background = '';
				whiteMask.classList.remove('active');
				if (searchInputOverlay) searchInputOverlay.value = '';
				if (searchResults) searchResults.innerHTML = '';
			}, 850);
		}

		closeButton.addEventListener('click', function(e) {
			e.stopPropagation();
			closeSearchAndCategoriePanels();
		});

		var searchOverlayCloseMobile = document.getElementById('searchOverlayCloseMobile');
		if (searchOverlayCloseMobile) {
			searchOverlayCloseMobile.addEventListener('click', function() {
				closeSearchAndCategoriePanels();
			});
		}

		function performLiveSearch(term) {
			if (!searchResults) return;
			if (searchController) {
				searchController.abort();
			}
			if (!term || term.length < 2) {
				searchResults.innerHTML = '';
				return;
			}
			searchController = new AbortController();
			const params = new URLSearchParams({ q: term });
			if (selectedFamily) {
				params.append('family', selectedFamily);
			}
			var localeMeta = document.querySelector('meta[name="app-locale"]');
			if (localeMeta && localeMeta.getAttribute('content')) {
				params.append('locale', localeMeta.getAttribute('content'));
			}
			fetch(liveSearchUrl + '?' + params.toString(), {
				headers: { 'X-Requested-With': 'XMLHttpRequest' },
				signal: searchController.signal
			})
				.then(function (response) {
					if (!response.ok) return null;
					return response.json();
				})
				.then(function (data) {
					if (!data || typeof data.html === 'undefined') return;
					searchResults.innerHTML = data.html;
				})
				.catch(function () {
					// silenzia errori di rete/abort
				});
		}

		function goToFullResults() {
			const term = searchInputOverlay ? searchInputOverlay.value.trim() : '';
			const params = new URLSearchParams();
			if (term) params.set('q', term);
			if (selectedFamily) params.set('family', selectedFamily);
			const query = params.toString();
			window.location.href = catalogIndexUrl + (query ? '?' + query : '');
		}

		if (searchInputOverlay) {
			searchInputOverlay.addEventListener('input', function () {
				const term = this.value.trim();
				if (searchTimeout) {
					clearTimeout(searchTimeout);
				}
				searchTimeout = setTimeout(function () {
					performLiveSearch(term);
				}, 300);
			});
			searchInputOverlay.addEventListener('keydown', function (e) {
				if (e.key === 'Enter') {
					e.preventDefault();
					goToFullResults();
				}
			});
		}

		if (familyItems && familyItems.length) {
			familyItems.forEach(function (item) {
				item.addEventListener('click', function () {
					const value = this.dataset.family || null;

					if (selectedFamily === value) {
						// se clicco di nuovo sulla stessa, deseleziono
						selectedFamily = null;
						this.classList.remove('active');
					} else {
						selectedFamily = value;
						familyItems.forEach(function (el) {
							el.classList.toggle('active', el === item);
						});
					}

					const term = searchInputOverlay ? searchInputOverlay.value.trim() : '';
					if (term.length >= 2) {
						performLiveSearch(term);
					} else if (searchResults) {
						searchResults.innerHTML = '';
					}
				});
			});
		}

		const header = document.querySelector('.header');
		const headerSpacer = document.querySelector('.header-spacer');

		function updateHeaderSpacer() {
			if (header && headerSpacer) {
				const height = header.offsetHeight;
				headerSpacer.style.height = height + 'px';
				document.documentElement.style.setProperty('--header-height', height + 'px');
			}
		}

		if (header && headerSpacer && typeof ResizeObserver !== 'undefined') {
			new ResizeObserver(updateHeaderSpacer).observe(header);
		}

		updateHeaderSpacer();
		window.addEventListener('load', updateHeaderSpacer);
		window.addEventListener('resize', updateHeaderSpacer);

		window.addEventListener('scroll', function() {
			if (window.scrollY > 20) {
				header.classList.add('scrolled');
			} else {
				header.classList.remove('scrolled');
			}
			updateHeaderSpacer();
		}, { passive: true });

		// Mobile: ricerca (seconda riga) apre stesso overlay ricerca
		var searchWrapperMobile = document.querySelector('.searchWrapperMobile');
		if (searchWrapperMobile && searchWrapper) {
			searchWrapperMobile.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				whiteMask.classList.add('active');
				closeButton.classList.add('active');
				searchBox.classList.remove('active');
				header.style.background = '#fff';
				if (boxCategorie && boxCategorie.classList.contains('active')) {
					boxCategorie.classList.remove('active');
					if (boxCategorieMask) boxCategorieMask.classList.remove('active');
				}
				setTimeout(function() {
					boxCerca.classList.add('active');
					boxCercaMask.classList.add('active');
					if (searchInputOverlay) {
						if (document.querySelector('.header-mobile .cercaInput') && document.querySelector('.header-mobile .cercaInput').value) {
							searchInputOverlay.value = document.querySelector('.header-mobile .cercaInput').value.trim();
						}
						searchInputOverlay.focus();
						searchInputOverlay.select();
					}
				}, 400);
				setTimeout(function() { boxCercaMask.classList.remove('active'); }, 450);
			});
		}

		// Mobile: hamburger apre pannello menu
		var hamburgerBtn = document.getElementById('hamburgerBtn');
		var mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
		var mobileMenuClose = document.getElementById('mobileMenuClose');
		if (hamburgerBtn && mobileMenuOverlay) {
			hamburgerBtn.addEventListener('click', function() {
				mobileMenuOverlay.classList.add('show');
				mobileMenuOverlay.setAttribute('aria-hidden', 'false');
			});
		}
		if (mobileMenuClose && mobileMenuOverlay) {
			mobileMenuClose.addEventListener('click', function() {
				mobileMenuOverlay.classList.remove('show');
				mobileMenuOverlay.setAttribute('aria-hidden', 'true');
			});
		}
		if (mobileMenuOverlay) {
			mobileMenuOverlay.addEventListener('click', function(e) {
				if (e.target === mobileMenuOverlay) {
					mobileMenuOverlay.classList.remove('show');
					mobileMenuOverlay.setAttribute('aria-hidden', 'true');
				}
			});
		}

		// Mobile: sottomenu categorie (toggle gestito da layout.blade.php via MoruzziCatalogSidebar)

		// Desktop: sottomenu "Chi siamo", "Guida", "Certificazioni" e "Vendere"
		// Ne resta aperto uno solo alla volta.
		var desktopSubmenus = [
			{ toggle: document.querySelector('.menu-about-toggle'), submenu: document.querySelector('.menu-about-submenu') },
			{ toggle: document.querySelector('.menu-guide-toggle'), submenu: document.querySelector('.menu-guide-submenu') },
			{ toggle: document.querySelector('.menu-cert-toggle'),  submenu: document.querySelector('.menu-cert-submenu') },
			{ toggle: document.querySelector('.menu-sell-toggle'),  submenu: document.querySelector('.menu-sell-submenu') }
		].filter(function(item) { return item.toggle && item.submenu; });

		function closeDesktopSubmenus(except) {
			desktopSubmenus.forEach(function(item) {
				if (item.submenu !== except) {
					item.submenu.classList.remove('active');
				}
			});
		}
		window.closeDesktopSubmenus = closeDesktopSubmenus;

		desktopSubmenus.forEach(function(item) {
			item.toggle.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				var willOpen = !item.submenu.classList.contains('active');
				closeDesktopSubmenus(item.submenu);
				item.submenu.classList.toggle('active', willOpen);
			});
		});

		document.addEventListener('click', function(e) {
			desktopSubmenus.forEach(function(item) {
				if (!item.submenu.contains(e.target) && !item.toggle.contains(e.target)) {
					item.submenu.classList.remove('active');
				}
			});
		});

		// Mobile: accordion generico (usato per "Chi siamo", "Certificazioni" e "Vendere")
		var mobileAccordions = document.querySelectorAll('.mobile-menu-accordion-toggle');
		if (mobileAccordions.length) {
			mobileAccordions.forEach(function(btn) {
				btn.addEventListener('click', function(e) {
					e.preventDefault();
					var content = btn.nextElementSibling;
					if (!content || !content.classList.contains('mobile-menu-accordion-content')) return;
					var isOpen = content.classList.contains('open');
					document.querySelectorAll('.mobile-menu-accordion-content').forEach(function(c) {
						c.classList.remove('open');
					});
					document.querySelectorAll('.mobile-menu-accordion-toggle').forEach(function(t) {
						t.classList.remove('open');
					});
					if (!isOpen) {
						content.classList.add('open');
						btn.classList.add('open');
					}
				});
			});
		}

		// Mobile: dropdown lingue
		var cambioLinguaMobile = document.querySelector('.cambioLinguaMobile');
		var lingueBoxMobile = document.querySelector('.lingueBoxMobile');
		if (cambioLinguaMobile && lingueBoxMobile) {
			cambioLinguaMobile.addEventListener('click', function(e) {
				if (e.target.closest('a[href]')) {
					return;
				}
				e.stopPropagation();
				lingueBoxMobile.classList.toggle('active');
			});
			document.addEventListener('click', function(e) {
				if (!lingueBoxMobile.contains(e.target) && !cambioLinguaMobile.contains(e.target)) {
					lingueBoxMobile.classList.remove('active');
				}
			});
		}

	});
</script>
