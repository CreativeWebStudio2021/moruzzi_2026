
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		@include('web.common.iubenda-cookie-solution')
		@include('web.common.google-tag-manager-head')
		<!-- Basic -->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8">
		<meta name="author" content="Creative Web Studio" />
		<title>{{ $metaTitle ?? config('app.name') }}</title>
		<meta name="description" content="{{ $metaDescription ?? config('app.name') }}"/>
		@stack('meta')
		@if(!empty($metaImage))
		<meta property="og:type" content="website" />
		<meta property="og:title" content="{{ $metaTitle ?? config('app.name') }}" />
		<meta property="og:description" content="{{ $metaDescription ?? config('app.name') }}" />
		<meta property="og:image" content="{{ $metaImage }}" />
		<meta property="og:url" content="{{ url()->current() }}" />
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:image" content="{{ $metaImage }}" />
		@endif
		
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="app-locale" content="{{ app()->getLocale() }}">
		<base href="{{ Config::get('app.url') }}/" />
		
		<link rel="preload" href="/fonts/Inria_Serif/InriaSerif-Regular.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="/fonts/fonts.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
		<noscript><link rel="stylesheet" href="/fonts/fonts.css"></noscript>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" media="print" onload="this.media='all'">
		<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>
		@if(should_show_home_intro())
		<link rel="preload" href="{{ asset('images/numismatica_moruzzi_bg_home.jpg') }}" as="image">
		<link rel="preload" href="{{ asset('images/logo_w.png') }}" as="image">
		<link rel="preload" href="/images/moneta_Adriano_Fronte.webp" as="image" type="image/webp" fetchpriority="high">
		<link rel="preload" href="/images/Moneta_Leone_XIII_Fronte.webp" as="image" type="image/webp" fetchpriority="high">
		@endif
		
		<link rel="icon" type="image/png" href="/images/favicon/favicon-96x96.png" sizes="96x96" />
		<link rel="icon" type="image/svg+xml" href="/images/favicon/favicon.svg" />
		<link rel="shortcut icon" href="/images/favicon/favicon.ico" />
		<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png" />
		<meta name="apple-mobile-web-app-title" content="Moruzzi" />
		<link rel="manifest" href="/images/favicon/site.webmanifest" />
		
		<style>
			
			:root {
				--black: #2d2d2d;
				--blackLight: #5f5f5f;
				--red: #802810;
				--background: #e7e0d4;
				--backgroundRGB: 231, 224, 212;
				--dirtyWhite: #FFFDF5;
				--generalMargin: 20px 130px;
				--generalMarginLat: 130px;
				--header-height: 220px;
			}
			@media (max-width: 1200px) {
				:root {
					--generalMargin: 20px 50px;
					--generalMarginLat: 50px;
				}
			}
			@media (max-width: 991px) {
				:root {
					--generalMargin: 16px 24px;
					--generalMarginLat: 24px;
				}
			}
			@media (max-width: 768px) {
				:root {
					--generalMargin: 16px 20px;
					--generalMarginLat: 20px;
				}
			}	
			input[type="text"]:focus {
				outline: none;
			}
			html {
				overflow-x: clip;
				max-width: 100%;
			}
			body{
				background:var(--background);
				color:var(--black);
				margin:0;
				padding:0;
				font-family:'Inria Sans';
				font-size:18px;
				overflow-x: clip;
				max-width: 100%;
			}
			.container {
				max-width: 100%;
				overflow-x: clip;
			}
			a{
				color:var(--black);
				text-decoration:none;
			}
			.generalMargin{
				margin:var(--generalMargin);
			}
			
			.morButton{
				width:200px;
				height:36px;
				margin:0 auto;
				box-shadow:4px 4px 8px 2px rgb(0 0 0 / 0.25);
				border-radius:20px;
				display:flex;
				justify-content:center;
				align-items:center;
				transition:all 0.4s ease;
				cursor:pointer;
				border:none; 
				font-size:16px;
			}
			.morButton2{
				width:200px;
				margin:0;
			}
			.morButtonFit{
				width:auto;
				min-width:200px;
				max-width:100%;
				height:auto;
				min-height:36px;
				padding:6px 24px;
				box-sizing:border-box;
			}
			.morButtonFit.morButton2{
				width:auto;
			}
			.morButtonFit .morButtonTxt{
				height:auto;
				padding-bottom:0;
				line-height:1.25;
				text-align:center;
				white-space:nowrap;
			}
			@media (max-width: 480px){
				.morButtonFit .morButtonTxt{
					white-space:normal;
				}
			}
			.morButton:hover{
				background:var(--blackLight);
				box-shadow:0px 4px 4px 0px rgb(0 0 0 / 0.25);
				color:#fff;
			}
			.morButtonTxt{
				height:16px;
				padding-bottom:6px;
				font-family: 'DM Mono';
				font-weight: 300;
			}
			.morButtonWhite{
				background:var(--background) !important;
				color:var(--black) !important;
			}
			.morButtonWhite:hover{
				background:var(--blackLight) !important;
				color:#fff !important;
			}
			.title-paragraph{
				font-family:'Inria Serif';
				font-size:50px;
				font-style:italic;
				font-weight:300;
				line-height:40px;
			}

			#toast-container {
				position: fixed;
				top: 20px;
				right: 20px;
				z-index: 99999;
				display: flex;
				flex-direction: column;
				gap: 10px;
			}

			.toast {
				min-width: 250px;
				padding: 14px 18px;
				border-radius: 8px;
				color: #fff;
				font-size: 14px;
				box-shadow: 0 10px 25px rgba(0,0,0,0.15);
				opacity: 0;
				transform: translateX(20px);
				transition: all 0.3s ease;
				display: flex;
				align-items: center;
				gap: 10px;
			}

			.toast.show {
				opacity: 1;
				transform: translateX(0);
			}

			.toast-success { background: #16a34a; }
			.toast-error   { background: #dc2626; }
			.toast-warning { background: #f59e0b; }
			.toast-info    { background: #2563eb; }

			.toast-close {
				margin-left: auto;
				cursor: pointer;
				font-weight: bold;
			}

			/* Layout catalogo / pagine informative con sidebar categorie */
			.catalog-section { background: var(--background); max-width: 100%; }
			.catalog-wrapper {
				margin: var(--generalMargin);
				max-width: 100%;
				min-width: 0;
				box-sizing: border-box;
			}
			.catalog-layout {
				display: flex;
				gap: 30px;
				align-items: flex-start;
				max-width: 100%;
				min-width: 0;
			}
			.catalog-sidebar-wrap { flex: 0 0 260px; min-width: 0; position: sticky; top: var(--header-height, 220px); align-self: flex-start; }
			.catalog-main { flex: 1; min-width: 0; margin-top:15px;}
			.catalog-sidebar {
				padding: 0;
				background: #fff;
				box-shadow: 0 2px 8px rgba(0,0,0,0.08);
				max-height: calc(100vh - 120px);
				display: flex;
				flex-direction: column;
			}
			.catalog-sidebar-header { padding: 15px 20px; background: var(--red); color: #fff; flex-shrink: 0; }
			.catalog-sidebar-body {
				padding: 8px 0 12px;
				overflow-y: auto;
				scrollbar-width: none;
				-ms-overflow-style: none;
			}
			.catalog-sidebar-body::-webkit-scrollbar { display: none; }
			.catalog-sidebar-item { margin-bottom: 2px; }
			.catalog-sidebar-row {
				display: flex;
				align-items: flex-start;
				padding: 6px 8px 6px 12px;
				border-bottom: 1px solid rgba(0,0,0,0.06);
			}
			.catalog-sidebar-row.active {
				background: var(--background);
			}
			.catalog-sidebar-link-inner {
				flex: 1;
				min-width: 0;
				text-decoration: none;
				color: var(--black);
				font-size: 0.95rem;
			}
			.catalog-sidebar-name {
				display: block;
				overflow-wrap: anywhere;
				word-break: break-word;
				line-height: 1.35;
			}
			.catalog-sidebar-link-inner:hover {
				color: var(--red);
			}
			.catalog-sidebar-toggle {
				border: none;
				background: none;
				cursor: pointer;
				color: var(--black);
				padding: 2px 6px 0;
				font-size: 1rem;
				flex-shrink: 0;
			}
			.catalog-sidebar-toggle:hover {
				color: var(--red);
			}
			.catalog-sidebar-children {
				overflow: hidden;
				max-height: 0;
				transition: max-height 0.35s ease;
			}
			.catalog-sidebar-children.is-expanded {
				max-height: none;
				overflow: visible;
			}
			.catalog-page-title {
				font-size: 30px;
				font-style:italic;
				font-weight: 700;
				color: var(--red);
				line-height: 1.2;
				margin: 0 0 10px;
				font-family: 'Inria Serif', serif;
			}
			.catalog-breadcrumb { margin-bottom: 24px; }
			.catalog-description { margin-top: 15px; margin-bottom: 24px; }

			.inputFormText {
				width: 100%;
				border: none;
				border-bottom: solid 1px var(--black);
				background: none;
				padding: 8px 2px;
			}
			.inputFormText:focus { outline: none; box-shadow: none; }

			.password-field-wrap {
				position: relative;
				width: 100%;
			}
			.password-field-wrap > input {
				width: 100%;
				padding-right: 40px;
				box-sizing: border-box;
			}
			.password-toggle-btn {
				position: absolute;
				right: 0;
				top: 50%;
				transform: translateY(-50%);
				border: none;
				background: none;
				padding: 4px 6px;
				cursor: pointer;
				color: var(--blackLight, #666);
				line-height: 1;
				font-size: 16px;
			}
			.password-toggle-btn:hover,
			.password-toggle-btn:focus {
				color: var(--red, #802810);
				outline: none;
			}

			.catalog-breadcrumb .catalog-page-title {
				display: flex;
				align-items: center;
				gap: 10px;
			}
			.breadcrumb-list { list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap; align-items: center; gap: 4px; font-size: 0.95rem; }
			.breadcrumb-list li { display: inline; }
			.breadcrumb-list a { color: var(--red); }

			@media (max-width: 991px) {
				.catalog-layout { flex-direction: column-reverse; }
				.catalog-main {
					order: 1;
					width: 100%;
					max-width: 100%;
				}
				.catalog-sidebar-wrap {
					flex: 0 0 auto;
					width: 100%;
					max-width: 100%;
					position: static;
					top: auto;
					align-self: stretch;
					margin-top: 20px;
				}
				.catalog-sidebar {
					position: relative;
					top: 0;
					max-height: none;
				}
				.catalog-page-title {
					font-size: clamp(26px, 6vw, 40px);
				}
			}

		</style>
		
		@stack('styles')
		
	</head>
	<body>
		@include('web.common.google-tag-manager-body')
		{{-- Debug locale: aggiungi ?locale_debug=1 all'URL per vedere i valori --}}
		@if(request()->query('locale_debug'))
		<div style="position:fixed;bottom:10px;right:10px;z-index:99999;background:#1a1a1a;color:#0f0;padding:12px;font-family:monospace;font-size:12px;max-width:320px;border:1px solid #333;border-radius:4px;">
			<strong style="color:#fff;">Locale debug</strong><br>
			app()->getLocale(): <code>{{ app()->getLocale() }}</code><br>
			request()->path(): <code>{{ request()->path() }}</code><br>
			segment(1): <code>{{ request()->segment(1) ?? '—' }}</code><br>
			route()->getName(): <code>{{ request()->route()?->getName() ?? '—' }}</code><br>
			route('locale'): <code>{{ request()->route('locale') ?? '—' }}</code><br>
			locale_route('home'): <code style="word-break:break-all;">{{ locale_route('home') }}</code><br>
			config(app.locale): <code>{{ config('app.locale') }}</code>
		</div>
		@endif

		@include('web.common.preloader')
        
		<div class="container " style="position:relative;">			
			@if(should_show_home_intro())
				@include('web.common.intro')
			@endif
			@include('web.common.header')
			@yield('content') 
			@include('web.common.registrati')
			@include('web.common.footer')		
		</div>
		
		@include('web.common.mini-cart-overlay')
		@include('web.common.user-overlay')
		@include('web.common.newsletter-overlay')

		<div id="toast-container"></div>
		
		@stack('scripts')
		
		<script>
			window.cartAddUrl    = "{{ locale_route('cart.add') }}";
			window.cartCountUrl  = "{{ locale_route('cart.count') }}";
			window.cartMiniUrl   = "{{ locale_route('cart.mini') }}";
			window.cartUpdateUrl = "{{ locale_route('cart.update') }}";
			window.cartRemoveUrl = "{{ locale_route('cart.remove') }}";
			window.cartQtyMinConfirm = @json(__('cart.qty_min_confirm'));
			window.cartRemoveConfirm = @json(__('cart.remove_confirm'));
			window.cartClearConfirm = @json(__('cart.clear_confirm'));
		</script>

		<script>
			window.passwordToggleShow = @json(__('auth.show_password'));
			window.passwordToggleHide = @json(__('auth.hide_password'));
		</script>
		<script src="{{ asset('js/password-toggle.js') }}" defer></script>

		<script src="{{ asset('js/cart.js') }}" defer></script>

		@php
			$emailError = $errors->first('email');
		@endphp

		<script>
			document.addEventListener('DOMContentLoaded', function () {
				@if (session('login_success'))
					if (typeof showToast === 'function') {
						showToast(@json(__('auth.login_success')), 'success');
					}
				@endif

				@if (session('register_success'))
					if (typeof showToast === 'function') {
						showToast(@json(__('auth.register_success')), 'success');
					}
				@endif

				@if (!empty($emailError) && $emailError === __('auth.failed'))
					if (typeof showToast === 'function') {
						showToast(@json($emailError), 'error');
					}
				@endif

				@if ($errors->any() && request()->routeIs('register'))
					if (typeof showToast === 'function') {
						showToast(@json(__('auth.register_error')), 'error');
					}
				@endif

				@if ($errors->any() && request()->routeIs('account.*'))
					if (typeof showToast === 'function') {
						showToast(@json(__('auth.form_error')), 'error');
					}
				@endif

				@if ($errors->has('quantity') && request()->routeIs('cart.index'))
					if (typeof showToast === 'function') {
						showToast(@json($errors->first('quantity')), 'error');
					}
				@endif

				@if (session('status'))
					if (typeof showToast === 'function') {
						showToast(@json(session('status')), @json(session('status_type', 'success')));
					}
				@endif
			});

			window.MoruzziCatalogSidebar = (function () {
				function unclampAncestors(container) {
					let el = container.parentElement;
					while (el) {
						if (el.classList && el.classList.contains('catalog-sidebar-children') && el.classList.contains('open')) {
							el.classList.add('is-expanded');
							el.style.maxHeight = 'none';
							el.style.overflow = 'visible';
						}
						el = el.parentElement;
					}
				}

				function expand(container) {
					container.classList.add('open', 'is-expanded');
					container.style.maxHeight = 'none';
					container.style.overflow = 'visible';
					unclampAncestors(container);
				}

				function collapse(container) {
					const height = container.scrollHeight;
					container.classList.remove('is-expanded');
					container.style.overflow = 'hidden';
					container.style.maxHeight = height + 'px';

					requestAnimationFrame(function () {
						container.style.maxHeight = '0px';
					});

					container.addEventListener('transitionend', function onEnd(e) {
						if (e.propertyName !== 'max-height') {
							return;
						}
						container.removeEventListener('transitionend', onEnd);
						container.classList.remove('open');
						container.style.maxHeight = '';
						container.style.overflow = '';
					});
				}

				function init() {
					document.querySelectorAll('.catalog-sidebar-children.open').forEach(function (container) {
						expand(container);
					});
				}

				function toggle(container, willOpen) {
					if (willOpen) {
						expand(container);
						return;
					}
					collapse(container);
				}

				return { init, toggle };
			})();

			document.addEventListener('DOMContentLoaded', function () {
				window.MoruzziCatalogSidebar.init();
			});

			document.addEventListener('click', function (e) {
				const toggle = e.target.closest('.catalog-sidebar-toggle');
				if (!toggle) return;

				const targetId = toggle.getAttribute('data-target');
				if (!targetId) return;

				const container = document.getElementById(targetId);
				if (!container) return;

				e.preventDefault();

				const icon = toggle.querySelector('i');
				const isOpen = container.classList.contains('open');

				window.MoruzziCatalogSidebar.toggle(container, !isOpen);

				if (icon) {
					icon.classList.toggle('fa-square-plus', isOpen);
					icon.classList.toggle('fa-square-minus', !isOpen);
				}

				toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
			});
		</script>

	</body>
</html>
