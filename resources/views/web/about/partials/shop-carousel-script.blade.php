<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carouselWrappers = document.querySelectorAll('.about-shop-carousel .carousel-wrapper');

        carouselWrappers.forEach(function (wrapper) {
            const track = wrapper.querySelector('.carousel-track');
            const slides = wrapper.querySelectorAll('.slide');
            const prevBtn = wrapper.querySelector('.prev');
            const nextBtn = wrapper.querySelector('.next');
            const carousel = wrapper.querySelector('.carousel');

            if (!track || !slides.length || !prevBtn || !nextBtn || !carousel) {
                return;
            }

            const slidesToShow = parseInt(wrapper.dataset.slides, 10) || 1;
            const intervalMs = parseInt(wrapper.dataset.interval, 10) || 2000;
            const gap = 12;
            const totalGap = gap * (slidesToShow - 1);

            slides.forEach(function (slide) {
                slide.style.flex = '0 0 calc((100% - ' + totalGap + 'px) / ' + slidesToShow + ')';
            });

            const maxIndex = Math.max(0, slides.length - slidesToShow);
            let index = 0;
            let interval;

            function updateCarousel() {
                const slideWidth = slides[0].getBoundingClientRect().width + gap;
                track.style.transform = 'translateX(-' + (index * slideWidth) + 'px)';
            }

            function nextSlide() {
                index = index >= maxIndex ? 0 : index + 1;
                updateCarousel();
            }

            function prevSlide() {
                index = index <= 0 ? maxIndex : index - 1;
                updateCarousel();
            }

            function startAutoplay() {
                interval = setInterval(nextSlide, intervalMs);
            }

            function stopAutoplay() {
                clearInterval(interval);
            }

            function resetAutoplay() {
                stopAutoplay();
                startAutoplay();
            }

            nextBtn.addEventListener('click', function () {
                nextSlide();
                resetAutoplay();
            });

            prevBtn.addEventListener('click', function () {
                prevSlide();
                resetAutoplay();
            });

            carousel.addEventListener('mouseenter', stopAutoplay);
            carousel.addEventListener('mouseleave', startAutoplay);

            let startX = 0;
            let isDragging = false;

            carousel.addEventListener('touchstart', function (e) {
                stopAutoplay();
                startX = e.touches[0].clientX;
                isDragging = true;
            });

            carousel.addEventListener('touchmove', function (e) {
                if (!isDragging) {
                    return;
                }

                const diff = startX - e.touches[0].clientX;

                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                    isDragging = false;
                }
            });

            carousel.addEventListener('touchend', function () {
                isDragging = false;
                startAutoplay();
            });

            window.addEventListener('resize', updateCarousel);

            updateCarousel();
            startAutoplay();
        });
    });
</script>
