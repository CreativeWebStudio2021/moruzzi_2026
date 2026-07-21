<script>
document.addEventListener('DOMContentLoaded', function () {
    var reveals = document.querySelectorAll('.cert-reveal');
    if (!reveals.length || !('IntersectionObserver' in window)) {
        reveals.forEach(function (el) { el.classList.add('is-visible'); });
        return;
    }

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

    document.querySelectorAll('.cert-meter').forEach(function (meter) {
        var meterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                meterObserver.unobserve(entry.target);
            });
        }, { threshold: 0.35 });
        meterObserver.observe(meter);
    });

    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox="cert-gallery"]', {
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
