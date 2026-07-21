@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-carousel-section .carousel-wrapper').forEach(function (wrapper) {
        var track = wrapper.querySelector('.carousel-track');
        var carousel = wrapper.querySelector('.carousel');
        var slides = wrapper.querySelectorAll('.slide');
        var prevBtn = wrapper.querySelector('.prev');
        var nextBtn = wrapper.querySelector('.next');

        if (!track || !slides.length || !carousel) {
            return;
        }

        var gap = 20;
        var index = 0;
        var slidesToShow = 1;
        var maxIndex = 0;
        var resizeTimer;
        var autoplayTimer = null;
        var autoplayDelay = parseInt(wrapper.dataset.interval, 10) || 4000;

        function startAutoplay() {
            stopAutoplay();
            if (maxIndex <= 0) {
                return;
            }
            autoplayTimer = setInterval(nextSlide, autoplayDelay);
        }

        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }

        function resetAutoplay() {
            stopAutoplay();
            startAutoplay();
        }

        function getSlidesToShow() {
            var lg = parseInt(wrapper.dataset.slides, 10) || 4;
            var md = parseInt(wrapper.dataset.slidesMd, 10) || 2;
            var sm = parseInt(wrapper.dataset.slidesSm, 10) || 1;
            var count = lg;

            if (window.innerWidth <= 768) {
                count = sm;
            } else if (window.innerWidth <= 1024) {
                count = md;
            } else if (window.innerWidth <= 1300) {
                count = Math.min(3, lg);
            }

            return Math.max(1, count);
        }

        function setControlsVisible(visible) {
            var display = visible ? '' : 'none';
            if (prevBtn) prevBtn.style.display = display;
            if (nextBtn) nextBtn.style.display = display;
        }

        function applySlideWidths() {
            var totalGap = gap * (slidesToShow - 1);
            slides.forEach(function (slide) {
                slide.style.flex = '0 0 calc((100% - ' + totalGap + 'px) / ' + slidesToShow + ')';
            });
        }

        function updateCarousel() {
            if (slides[0]) {
                var slideWidth = slides[0].getBoundingClientRect().width + gap;
                track.style.transform = 'translateX(-' + (index * slideWidth) + 'px)';
            }
        }

        function rebuildCarousel() {
            slidesToShow = getSlidesToShow();
            maxIndex = Math.max(0, slides.length - slidesToShow);
            if (index > maxIndex) {
                index = maxIndex;
            }

            if (slidesToShow >= slides.length) {
                setControlsVisible(false);
                stopAutoplay();
            } else {
                setControlsVisible(true);
            }

            applySlideWidths();
            updateCarousel();
            startAutoplay();
        }

        function nextSlide() {
            index = index >= maxIndex ? 0 : index + 1;
            updateCarousel();
        }

        function prevSlide() {
            index = index <= 0 ? maxIndex : index - 1;
            updateCarousel();
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                prevSlide();
                resetAutoplay();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                nextSlide();
                resetAutoplay();
            });
        }

        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);

        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                stopAutoplay();
                rebuildCarousel();
            }, 150);
        });

        rebuildCarousel();
    });
});
</script>
@endpush
@endonce
