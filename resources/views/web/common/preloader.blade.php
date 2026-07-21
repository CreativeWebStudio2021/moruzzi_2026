<div id="preloader" aria-hidden="true">
	<div class="loader-content">
		<img src="{{ asset('images/logo_r.png') }}" alt="{{ __('seo.img_preloader') }}" width="150" height="150" decoding="async">
		<div class="loader-bar">
			<div class="progress" id="preloaderProgress"></div>
		</div>
	</div>
</div>

<style>
	#preloader {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: #ffffff;
		z-index: 1000002;
		display: flex;
		justify-content: center;
		align-items: center;
		flex-direction: column;
		transition: opacity 0.35s ease, visibility 0.35s ease;
	}
	#preloader.is-hidden {
		opacity: 0;
		visibility: hidden;
		pointer-events: none;
	}
	.loader-content {
		display: flex;
		flex-direction: column;
		align-items: center;
	}
	.loader-content img {
		width: 150px;
		height: auto;
		margin-bottom: 20px;
	}
	.loader-bar {
		width: 200px;
		height: 8px;
		background: #ddd;
		overflow: hidden;
		border-radius: 4px;
	}
	.progress {
		width: 0%;
		height: 100%;
		background: var(--red);
		transition: width 0.25s ease;
	}
</style>

<script>
(function () {
	const preloader = document.getElementById('preloader');
	const progress = document.getElementById('preloaderProgress');
	const intro = document.getElementById('homeIntro');

	if (!preloader || intro) {
		return;
	}

	let fake = 0;
	const tick = setInterval(function () {
		fake = Math.min(fake + 6, 92);
		if (progress) progress.style.width = fake + '%';
	}, 100);

	function hidePreloader() {
		clearInterval(tick);
		if (progress) progress.style.width = '100%';
		preloader.classList.add('is-hidden');
		setTimeout(function () {
			preloader.style.display = 'none';
			window.dispatchEvent(new CustomEvent('moruzzi:preloader-closed'));
		}, 400);
	}

	window.addEventListener('load', hidePreloader);
})();
</script>
