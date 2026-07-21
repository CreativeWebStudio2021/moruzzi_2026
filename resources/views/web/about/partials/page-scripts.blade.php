<script>
document.addEventListener('DOMContentLoaded', function () {
    var reveals = document.querySelectorAll('.cert-reveal');
    if (!reveals.length || !('IntersectionObserver' in window)) {
        reveals.forEach(function (el) { el.classList.add('is-visible'); });
    } else {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { root: null, rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

        reveals.forEach(function (el, index) {
            el.style.transitionDelay = (index % 4) * 0.08 + 's';
            observer.observe(el);
        });
    }

    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox="about-gallery"]', {
            Toolbar: {
                display: {
                    left: ['infobar'],
                    middle: [],
                    right: ['slideshow', 'download', 'thumbs', 'close'],
                },
            },
        });
    }
});
</script>
