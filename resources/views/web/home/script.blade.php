<script>
	document.addEventListener('DOMContentLoaded', function() {

		document.querySelectorAll('[data-lazy-bg]').forEach(function (el) {
			var src = el.getAttribute('data-lazy-bg');
			if (!src) return;

			var apply = function () {
				el.style.backgroundImage = 'url(' + src + ')';
			};

			if ('IntersectionObserver' in window) {
				var observer = new IntersectionObserver(function (entries) {
					entries.forEach(function (entry) {
						if (!entry.isIntersecting) return;
						apply();
						observer.unobserve(el);
					});
				}, { rootMargin: '240px 0px' });
				observer.observe(el);
			} else {
				apply();
			}
		});

		const carouselWrappers = document.querySelectorAll('.carousel-wrapper');

		carouselWrappers.forEach(wrapper => {

			const track = wrapper.querySelector('.carousel-track');
			const slides = wrapper.querySelectorAll('.slide');
			const prevBtn = wrapper.querySelector('.prev');
			const nextBtn = wrapper.querySelector('.next');
			const dotsContainer = wrapper.querySelector('.dots');
			const carousel = wrapper.querySelector('.carousel');

			const slidesToShow = parseInt(wrapper.dataset.slides) || 3;
			
			const gap = 20;
			const totalGap = gap * (slidesToShow - 1);

			slides.forEach(slide => {
				slide.style.flex = `0 0 calc((100% - ${totalGap}px) / ${slidesToShow})`;
			});

			const totalSlides = slides.length;
			const maxIndex = totalSlides - slidesToShow;

			let index = 0;
			let interval;

			/* =========================
			   CREA DOTS
			========================== */

			for (let i = 0; i <= maxIndex; i++) {
				const dot = document.createElement('span');
				if (i === 0) dot.classList.add('active');
				dot.addEventListener('click', () => goToSlide(i));
				dotsContainer.appendChild(dot);
			}

			const dots = dotsContainer.querySelectorAll('span');

			/* =========================
			   UPDATE
			========================== */

			function updateCarousel() {
				const slideWidth = slides[0].getBoundingClientRect().width + gap;
				track.style.transform = `translateX(-${index * slideWidth}px)`;

				dots.forEach(dot => dot.classList.remove('active'));
				dots[index].classList.add('active');
			}

			function nextSlide() {
				index = (index >= maxIndex) ? 0 : index + 1;
				updateCarousel();
			}

			function prevSlide() {
				index = (index <= 0) ? maxIndex : index - 1;
				updateCarousel();
			}

			function goToSlide(i) {
				index = i;
				updateCarousel();
				resetAutoplay();
			}

			/* =========================
			   BUTTON EVENTS
			========================== */

			nextBtn.addEventListener('click', () => {
				nextSlide();
				resetAutoplay();
			});

			prevBtn.addEventListener('click', () => {
				prevSlide();
				resetAutoplay();
			});

			/* =========================
			   AUTOPLAY
			========================== */

			function startAutoplay() {
				interval = setInterval(nextSlide, 3000);
			}

			function stopAutoplay() {
				clearInterval(interval);
			}

			function resetAutoplay() {
				stopAutoplay();
				startAutoplay();
			}

			startAutoplay();

			/* =========================
			   PAUSA ON HOVER
			========================== */

			carousel.addEventListener('mouseenter', stopAutoplay);
			carousel.addEventListener('mouseleave', startAutoplay);

			/* =========================
			   TOUCH SWIPE
			========================== */

			let startX = 0;
			let isDragging = false;

			carousel.addEventListener('touchstart', (e) => {
				stopAutoplay();
				startX = e.touches[0].clientX;
				isDragging = true;
			});

			carousel.addEventListener('touchmove', (e) => {
				if (!isDragging) return;
				const currentX = e.touches[0].clientX;
				const diff = startX - currentX;

				if (Math.abs(diff) > 50) {
					if (diff > 0) nextSlide();
					else prevSlide();
					isDragging = false;
				}
			});

			carousel.addEventListener('touchend', () => {
				isDragging = false;
				startAutoplay();
			});

		});

	});
</script>