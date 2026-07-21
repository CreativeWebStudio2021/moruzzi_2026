@php
	$showAuto = !session('newsletter_popup_shown');
	$waitForIntro = should_show_home_intro();
	$showMessage = session('newsletter_message');
	$showErrors = $errors->has('subscriber_email');
	$dismissUrl = locale_route('newsletter.dismiss');
	$subscribeUrl = locale_route('newsletter.subscribe');
	$whatsappChannelUrl = 'https://whatsapp.com/channel/0029Vb67PHi8qIzvmq7jS93x';
@endphp
<style>
	.newsletter-overlay {
		position: fixed;
		inset: 0;
		width: 100%;
		max-width: 100%;
		background: rgba(0,0,0,0.5);
		opacity: 0;
		visibility: hidden;
		transition: opacity 0.4s ease, visibility 0.4s ease;
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 99999;
		overflow-x: hidden;
		overflow-y: auto;
		padding: 16px;
		box-sizing: border-box;
	}
	.newsletter-overlay.show {
		opacity: 1;
		visibility: visible;
	}
	.newsletter-overlay .newsletter-box {
		background: #fff;
		width: 100%;
		max-width: min(440px, calc(100vw - 32px));
		border-radius: 8px;
		box-shadow: 0 12px 40px rgba(0,0,0,0.2);
		opacity: 0;
		transform: scale(0.95);
		transition: opacity 0.4s ease 0.1s, transform 0.4s ease 0.1s;
		box-sizing: border-box;
		flex-shrink: 0;
	}
	.newsletter-overlay.show .newsletter-box {
		opacity: 1;
		transform: scale(1);
	}
	.newsletter-overlay .newsletter-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 12px;
		background: var(--red);
		color: #fff;
		padding: 18px 20px;
		border-radius: 8px 8px 0 0;
		min-width: 0;
	}
	.newsletter-overlay .newsletter-title {
		font-family: 'Inria Serif', serif;
		font-size: clamp(18px, 4.8vw, 22px);
		font-style: italic;
		margin: 0;
		min-width: 0;
		line-height: 1.25;
	}
	.newsletter-overlay .newsletter-close {
		background: none;
		border: none;
		color: #fff;
		font-size: 24px;
		cursor: pointer;
		line-height: 1;
		padding: 4px;
		opacity: 0.9;
		flex-shrink: 0;
	}
	.newsletter-overlay .newsletter-close:hover {
		opacity: 1;
	}
	.newsletter-overlay .newsletter-body {
		padding: 24px 20px;
	}
	.newsletter-overlay .newsletter-body p {
		margin: 0 0 16px;
		color: var(--black);
		font-size: 15px;
		line-height: 1.5;
	}
	.newsletter-overlay .newsletter-body .form-group {
		margin-bottom: 16px;
	}
	.newsletter-overlay .newsletter-body label {
		display: block;
		margin-bottom: 6px;
		font-weight: 600;
		font-size: 14px;
		color: var(--black);
	}
	.newsletter-overlay .newsletter-body input[type="email"] {
		width: 100%;
		padding: 10px 12px;
		border: 1px solid #ccc;
		border-radius: 4px;
		font-size: 16px;
		box-sizing: border-box;
	}
	.newsletter-overlay .newsletter-body .btn-subscribe {
		width: 100%;
		padding: 12px 20px;
		background: var(--red);
		color: #fff;
		border: none;
		border-radius: 4px;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
		transition: background 0.2s ease;
	}
	.newsletter-overlay .newsletter-body .btn-subscribe:hover {
		background: var(--black);
	}
	.newsletter-overlay .newsletter-divider {
		border: none;
		border-top: 1px solid #e1e1e1;
		margin: 24px 0;
	}
	.newsletter-overlay .newsletter-whatsapp-title {
		font-family: 'Inria Serif', serif;
		font-size: clamp(16px, 4.2vw, 20px);
		font-style: italic;
		margin: 0 0 16px;
		text-align: center;
		color: var(--black);
		line-height: 1.3;
	}
	.newsletter-overlay .btn-whatsapp {
		background: #20BA5A;
		color: #fff;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		text-align: center;
		text-decoration: none;
		box-sizing: border-box;
		border: 1px solid rgba(0, 0, 0, 0.08);
		box-shadow: 0 2px 8px rgba(32, 186, 90, 0.35);
		transition: background 0.2s ease, box-shadow 0.2s ease, transform 0.15s ease;
	}
	.newsletter-overlay .btn-whatsapp .newsletter-whatsapp-btn-icon {
		width: 20px;
		height: 20px;
		flex-shrink: 0;
		color: #fff;
	}
	.newsletter-overlay .btn-whatsapp:hover {
		background: #128C7E;
		color: #fff;
		box-shadow: 0 4px 14px rgba(18, 140, 126, 0.4);
		transform: translateY(-1px);
	}
	.newsletter-overlay .newsletter-message {
		margin-bottom: 12px;
		padding: 10px 12px;
		border-radius: 4px;
		font-size: 14px;
	}
	.newsletter-overlay .newsletter-message.success {
		background: rgba(0,128,0,0.15);
		color: #0a5f0a;
	}
	.newsletter-overlay .newsletter-message.error {
		background: rgba(255,0,0,0.1);
		color: #b00;
	}
	body.newsletter-open {
		overflow: hidden;
		overflow-x: clip;
	}
</style>

<div id="newsletter-overlay" class="newsletter-overlay" data-auto-show="{{ $showAuto ? '1' : '0' }}" data-wait-intro="{{ $waitForIntro ? '1' : '0' }}" data-show-message="{{ $showMessage ? '1' : '0' }}" data-show-errors="{{ $showErrors ? '1' : '0' }}" aria-hidden="true">
	<div class="newsletter-box" role="dialog" aria-labelledby="newsletter-title" aria-modal="true">
		<div class="newsletter-header">
			<h2 id="newsletter-title" class="newsletter-title">{{ __('newsletter.title') }}</h2>
			<button type="button" class="newsletter-close" onclick="closeNewsletterOverlay()" aria-label="{{ __('general.chiudi') }}">
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>
		<div class="newsletter-body">
			@if(session('newsletter_message'))
				<div class="newsletter-message {{ session('newsletter_message_type', 'success') }}">
					{{ session('newsletter_message') }}
				</div>
			@endif
			<p>{{ __('newsletter.description') }}</p>
			<form action="{{ $subscribeUrl }}" method="post" id="formNewsletterPopup" name="formNewsletterPopup">
				@csrf
				<input type="hidden" name="subscribe_newsletter" value="inviato"/>
				<div class="form-group">
					<label for="newsletter-subscriber_email">{{ field_placeholder('newsletter.email') }}</label>
					<input type="email" name="subscriber_email" id="newsletter-subscriber_email" class="form-control" placeholder="{{ field_placeholder('newsletter.email_placeholder') }}" required value="{{ old('subscriber_email') }}"/>
					@error('subscriber_email')
						<small class="newsletter-message error" style="display:block; margin-top:6px;">{{ $message }}</small>
					@enderror
				</div>
				@include('web.common.form-required-note')
				<div class="form-group">
					<button type="submit" class="btn-subscribe">{{ __('newsletter.submit') }}</button>
				</div>
			</form>

			<hr class="newsletter-divider" aria-hidden="true">

			<div class="newsletter-whatsapp">
				<h3 class="newsletter-whatsapp-title">{{ __('newsletter.whatsapp_title') }}</h3>
				<a
					href="{{ $whatsappChannelUrl }}"
					target="_blank"
					rel="noopener noreferrer"
					class="btn-subscribe btn-whatsapp"
				>
					<x-icon name="whatsapp" class="newsletter-whatsapp-btn-icon"/>
					<span>{{ __('newsletter.submit') }}</span>
				</a>
			</div>
		</div>
	</div>
</div>

<script>
(function() {
	const overlay = document.getElementById('newsletter-overlay');
	const dismissUrl = '{{ $dismissUrl }}';
	const autoShow = overlay && overlay.getAttribute('data-auto-show') === '1';
	const waitForIntro = overlay && overlay.getAttribute('data-wait-intro') === '1';
	const showMessage = overlay && overlay.getAttribute('data-show-message') === '1';
	const showErrors = overlay && overlay.getAttribute('data-show-errors') === '1';

	function showNewsletter() {
		if (!overlay) return;
		overlay.classList.add('show');
		overlay.setAttribute('aria-hidden', 'false');
		document.body.classList.add('newsletter-open');
	}

	function closeNewsletterOverlay() {
		if (!overlay) return;
		overlay.classList.remove('show');
		overlay.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('newsletter-open');
		fetch(dismissUrl, { method: 'GET', credentials: 'same-origin' }).catch(function(){});
	}

	window.closeNewsletterOverlay = closeNewsletterOverlay;
	window.showNewsletterOverlay = showNewsletter;

	function scheduleAutoShow(delayMs) {
		setTimeout(function () {
			showNewsletter();
		}, delayMs);
	}

	function preloaderIsActive() {
		const preloader = document.getElementById('preloader');
		if (!preloader) return false;
		return preloader.style.display !== 'none' && !preloader.classList.contains('is-hidden');
	}

	function introIsActive() {
		const intro = document.getElementById('homeIntro');
		if (!intro) return false;
		return intro.style.display !== 'none';
	}

	function whenContentIsVisible(callback) {
		if (waitForIntro && introIsActive()) {
			window.addEventListener('moruzzi:intro-closed', callback, { once: true });
			return;
		}
		if (preloaderIsActive()) {
			window.addEventListener('moruzzi:preloader-closed', callback, { once: true });
			return;
		}
		callback();
	}

	function markAsShown() {
		fetch(dismissUrl, { method: 'GET', credentials: 'same-origin' }).catch(function(){});
	}

	if (autoShow) {
		whenContentIsVisible(function () {
			scheduleAutoShow(waitForIntro ? 1200 : 2000);
			// Segna come "mostrato" per la sessione già alla prima apertura
			// automatica, così non riappare ad ogni cambio pagina anche se
			// l'utente naviga senza chiuderlo esplicitamente.
			markAsShown();
		});
	}

	if (showMessage || showErrors) {
		showNewsletter();
	}

	if (overlay) {
		overlay.addEventListener('click', function(e) {
			if (e.target === overlay) {
				closeNewsletterOverlay();
			}
		});
	}
})();
</script>
