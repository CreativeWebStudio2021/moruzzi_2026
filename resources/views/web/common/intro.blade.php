<style>
	.intro{
		position: fixed;
		top: 0;
		left: 0;
		width:100%;
		max-width:100%;
		height:100vh;
		height:100dvh;
		overflow:hidden;
		z-index:1000001;
		background:white;
		transition: background 0.3s ease;
		--intro-coin-base: 400px;
		--intro-coin-active: 500px;
		--intro-coin-roll: -72deg;
		--intro-coin-x1: -38%;
		--intro-coin-x2: 17%;
		--intro-logo-width: 330px;
		--intro-logo-top: 50%;
		--intro-logo-top-active: 50%;
	}
	.intro.scrolling{
		background:transparent;
	}
	body.lock-scroll{
		overflow: hidden;
		overflow-x: clip;
	}

	.main {
		position: relative;
		z-index: 100001;
	}

	.introBg{
		position:absolute;
		width:100%;
		height:100%;
		object-fit:cover;
		object-position:center;
		opacity:0;
		transition: opacity 1.5s ease, transform 1.2s ease-out;
	}

	.intro.animate .introBg{
		opacity:1;
	}

	.intro.exit .introBg{
		transform: translateY(-40%);
		transition: opacity 1s ease, transform 1.2s ease-out;
	}

	.introBox{
		position:absolute;
		left:0;
		width:100%;
		top:50%;
		transform:translateY(-50%);
		display:flex;
		justify-content: space-between;
		align-items:center;
	}

	.introBoxImg{
		width:400px;
		display:flex;
		justify-content:center;
		align-items:center;
	}

	.introBoxImg img.moneta1,
	.introBoxImg img.moneta2{
		width: var(--intro-coin-base);
		height:auto;
		transition: transform 1.7s cubic-bezier(0.34, 1.08, 0.64, 1), width 1.5s ease, opacity 1.5s ease;
		transform-origin: center center;
	}

	.introBoxImg:first-child img.moneta1{
		transform-origin: left center;
	}

	.introBoxImg:last-child img.moneta2{
		transform-origin: right center;
	}

	.introBoxImg:nth-child(2){
		width:auto;
		flex:0 0 auto;
	}

	.introLogo{
		width: var(--intro-logo-width);
		height:auto;
		display:block;
	}

	.introBoxImg:nth-child(2) img.introLogo{
		opacity:0;
		transition: opacity 1.5s ease;
	}

	.intro.animate .introBoxImg:nth-child(2) img.introLogo{
		opacity:1;
	}

	.intro.exit .introBoxImg:nth-child(2) img.introLogo{
		opacity:0;
		transition: opacity 0.8s ease;
	}

	.moneta1{
		transform: translateX(-100%) rotate(var(--intro-coin-roll));
		opacity: 1;
	}

	.intro.animate2 .moneta1{
		width: var(--intro-coin-active);
		transform: translateX(var(--intro-coin-x1)) rotate(0deg);
	}

	.intro.exit .moneta1{
		transform: translateX(-100%) rotate(var(--intro-coin-roll));
		transition: transform 1.2s ease-out;
	}

	.moneta2{
		transform: translateX(100%) rotate(calc(-1 * var(--intro-coin-roll)));
		opacity:0;
	}

	.intro.animate2 .moneta2{
		width: var(--intro-coin-active);
		transform: translateX(var(--intro-coin-x2)) rotate(0deg);
		opacity:1;
	}

	.intro.exit .moneta2{
		transform: translateX(100%) rotate(calc(-1 * var(--intro-coin-roll)));
		transition: transform 1.2s ease-out;
	}

	.intro.exit{
		transform: translateY(-100%);
		transition: transform 1.2s ease-out, background 0.3s ease;
	}

	@media (max-width: 992px) {
		.intro{
			--intro-coin-base: clamp(240px, 36vw, 300px);
			--intro-coin-active: clamp(300px, 46vw, 380px);
			--intro-coin-x1: -28%;
			--intro-coin-x2: 14%;
			--intro-logo-width: clamp(210px, 28vw, 250px);
		}
		.introBoxImg{ width: clamp(240px, 36vw, 300px); }
	}
	@media (max-width: 768px) {
		.intro{
			--intro-coin-base: clamp(280px, 58vw, 440px);
			--intro-coin-active: clamp(280px, 58vw, 440px);
			/* ~46% visibile ai lati, resto fuori schermo */
			--intro-coin-peek-out: 54%;
			--intro-coin-x1: calc(-1 * var(--intro-coin-peek-out));
			--intro-coin-x2: var(--intro-coin-peek-out);
			--intro-coin-roll: -68deg;
			--intro-logo-width: clamp(165px, 44vw, 200px);
		}
		.introBox{
			top: 55%;
			transform: translateY(-50%);
			display: block;
			height: 0;
			padding: 0;
		}
		.introBoxImg:first-child,
		.introBoxImg:last-child{
			position: absolute;
			top: 0;
			width: auto;
			flex: none;
			transform: translateY(-50%);
		}
		.introBoxImg:first-child{
			left: 0;
			justify-content: flex-start;
		}
		.introBoxImg:last-child{
			right: 0;
			left: auto;
			justify-content: flex-end;
		}
		.introBoxImg:nth-child(2){
			position: absolute;
			left: 50%;
			top: 0;
			transform: translate(-50%, -50%);
			width: auto;
			z-index: 5;
			transition: top 0.9s ease, transform 0.9s ease;
		}
		.intro.animate .introBoxImg:nth-child(2){
			top: calc(-40vh + env(safe-area-inset-top, 0px) + 10px);
			transform: translateX(-50%);
		}
	}
	@media (max-width: 600px) {
		.intro{
			--intro-logo-width: clamp(150px, 42vw, 185px);
		}
		.intro.animate .introBoxImg:nth-child(2){
			top: calc(-40vh + env(safe-area-inset-top, 0px) + 6px);
		}
	}
	@media (max-width: 450px) {
		.intro{
			--intro-logo-width: clamp(138px, 36vw, 168px);
		}
		.intro.animate .introBoxImg:nth-child(2){
			top: calc(-40vh + env(safe-area-inset-top, 0px) + 0px);
		}
	}
</style>

<div role="main" class="main">
	<div class="intro" id="homeIntro">
		<picture>
			<source srcset="/images/numismatica_moruzzi_bg_home.webp" type="image/webp">
			<img class="introBg" src="/images/numismatica_moruzzi_bg_home.jpg"
				alt="Collezione numismatica Moruzzi Numismatica"
				fetchpriority="high" decoding="async" width="1512" height="982">
		</picture>
		<div class="introBox">
			<div class="introBoxImg">
				<picture>
					<source srcset="/images/moneta_Adriano_Fronte.webp" type="image/webp">
					<img class="moneta1" src="/images/moneta_Adriano_Fronte.png" alt="Moneta romana età di Adriano" fetchpriority="high" width="510" height="500" decoding="async" data-cmp-info="10">
				</picture>
			</div>
			<div class="introBoxImg"><img class="introLogo" src="{{ asset('images/logo_w.png') }}" alt="Moruzzi Numismatica" fetchpriority="high" width="260" height="234" decoding="async"></div>
			<div class="introBoxImg">
				<picture>
					<source srcset="/images/Moneta_Leone_XIII_Fronte.webp" type="image/webp">
					<img class="moneta2" src="/images/Moneta_Leone_XIII_Fronte.png" alt="Moneta Leone XIII" fetchpriority="high" width="496" height="500" decoding="async" data-cmp-info="10">
				</picture>
			</div>
		</div>
	</div>
</div>

<script>
(function () {
	const intro = document.getElementById('homeIntro');
	const preloader = document.getElementById('preloader');
	const progress = document.getElementById('preloaderProgress');

	if (!intro) {
		return;
	}

	document.body.classList.add('lock-scroll');
	window.scrollTo(0, 0);

	const introImages = Array.from(intro.querySelectorAll('img'));
	let loaded = 0;

	function updateProgress() {
		if (!progress || !introImages.length) return;
		progress.style.width = Math.round((loaded / introImages.length) * 100) + '%';
	}

	function preloadIntroAssets() {
		return Promise.all(introImages.map(function (img) {
			return new Promise(function (resolve) {
				if (img.complete && img.naturalWidth > 0) {
					loaded++;
					updateProgress();
					resolve();
					return;
				}
				function done() {
					loaded++;
					updateProgress();
					resolve();
				}
				img.addEventListener('load', done, { once: true });
				img.addEventListener('error', done, { once: true });
			});
		}));
	}

	function hidePreloader() {
		if (!preloader) return;
		if (progress) progress.style.width = '100%';
		preloader.classList.add('is-hidden');
		setTimeout(function () {
			preloader.style.display = 'none';
			window.dispatchEvent(new CustomEvent('moruzzi:preloader-closed'));
		}, 400);
	}

	function startIntro() {
		hidePreloader();
		setTimeout(function () { intro.classList.add('animate'); }, 80);
		setTimeout(function () {
			intro.classList.add('animate2');
			scheduleAutoDismiss();
		}, 620);
	}

	let introFinished = false;
	let exitTriggered = false;
	let autoDismissTimer = null;

	function clearAutoDismiss() {
		if (autoDismissTimer !== null) {
			clearTimeout(autoDismissTimer);
			autoDismissTimer = null;
		}
	}

	function finishIntro() {
		if (introFinished) return;
		introFinished = true;
		clearAutoDismiss();
		document.body.classList.remove('lock-scroll');
		intro.style.display = 'none';
		window.dispatchEvent(new CustomEvent('moruzzi:intro-closed'));
	}

	function startExitAnimation() {
		if (exitTriggered || introFinished) return;
		exitTriggered = true;
		clearAutoDismiss();
		intro.classList.add('scrolling');
		intro.classList.add('exit');
	}

	function scheduleAutoDismiss() {
		clearAutoDismiss();
		autoDismissTimer = setTimeout(function () {
			autoDismissTimer = null;
			startExitAnimation();
		}, 5000);
	}

	function dismissIntroFromUserScroll() {
		if (introFinished || exitTriggered) return;
		startExitAnimation();
	}

	function isScrollKey(event) {
		var key = event.key;
		return key === 'ArrowDown'
			|| key === 'ArrowUp'
			|| key === 'PageDown'
			|| key === 'PageUp'
			|| key === ' '
			|| key === 'Home'
			|| key === 'End';
	}

	intro.addEventListener('transitionend', function (e) {
		if (e.target === intro && e.propertyName === 'transform') {
			finishIntro();
		}
	});

	intro.addEventListener('click', startExitAnimation);

	window.addEventListener('wheel', function (e) {
		if (introFinished || exitTriggered) return;
		e.preventDefault();
		startExitAnimation();
	}, { passive: false });

	window.addEventListener('scroll', function () {
		if (introFinished || exitTriggered) return;
		if (window.scrollY > 0 || document.documentElement.scrollTop > 0 || document.body.scrollTop > 0) {
			dismissIntroFromUserScroll();
		}
	}, { passive: true });

	window.addEventListener('mousedown', function (e) {
		if (introFinished || exitTriggered || e.button !== 0) return;
		var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
		if (scrollbarWidth <= 0) {
			scrollbarWidth = 18;
		}
		if (e.clientX >= document.documentElement.clientWidth - scrollbarWidth) {
			startExitAnimation();
		}
	});

	window.addEventListener('keydown', function (e) {
		if (introFinished || exitTriggered) return;
		if (!isScrollKey(e)) return;
		e.preventDefault();
		startExitAnimation();
	});

	var touchScrollStarted = false;
	window.addEventListener('touchmove', function (e) {
		if (introFinished || exitTriggered) return;
		if (!touchScrollStarted) {
			touchScrollStarted = true;
			e.preventDefault();
			startExitAnimation();
		}
	}, { passive: false });

	Promise.race([
		preloadIntroAssets(),
		new Promise(function (resolve) { setTimeout(resolve, 4500); })
	]).then(startIntro);
})();
</script>
