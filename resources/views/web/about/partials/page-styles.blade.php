<style>
    .about-staff-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 24px;
        margin-top: 24px;
    }

    .about-staff-card {
        flex: 0 0 200px;
        width: 200px;
        text-align: center;
    }

    .about-staff-card__photo {
        margin: 0 auto 12px;
    }

    .about-staff-card__name {
        font-family: 'Inria Serif', serif;
        font-style: italic;
        font-size: 1.1rem;
        margin: 0 0 6px;
        color: var(--red);
    }

    .about-staff-card__role {
        margin: 0;
        font-size: 0.92rem;
        color: var(--blackLight);
        line-height: 1.5;
    }

    .about-staff-card a {
        text-decoration: none;
        color: inherit;
    }

    .about-staff-card a:hover .about-staff-card__name {
        text-decoration: underline;
    }

    .about-split-item {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        align-items: flex-start;
        margin-bottom: 28px;
        padding-bottom: 28px;
        border-bottom: 1px solid rgba(45, 45, 45, 0.1);
    }

    .about-split-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .about-split-item__media {
        flex: 0 0 160px;
        width: 160px;
        margin: 0;
    }

    .about-split-item__media img {
        display: block;
        width: 100%;
        height: auto;
    }

    .about-split-item__body {
        flex: 1 1 240px;
        min-width: 0;
    }

    .about-split-item__title {
        font-family: 'Inria Serif', serif;
        font-style: italic;
        font-size: 1.15rem;
        margin: 0 0 10px;
        color: var(--red);
    }

    .about-split-item__meta {
        font-size: 0.9rem;
        color: var(--blackLight);
        margin-bottom: 12px;
    }

    .about-split-item__body p {
        margin: 0 0 12px;
    }

    .about-split-item__body p:last-child {
        margin-bottom: 0;
    }

    .about-masonry {
        column-count: 3;
        column-gap: 16px;
    }

    .about-masonry__item {
        break-inside: avoid;
        margin: 0 0 16px;
    }

    .about-masonry__item img {
        display: block;
        width: 100%;
        height: auto;
    }

    .about-cta-block {
        margin-top: 8px;
    }

    .about-cta-block__text {
        margin: 0 0 16px;
    }

    .about-cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 24px;
        border-radius: 999px;
        background: var(--red);
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .about-cta-btn:hover {
        background: #a01830;
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    @media (max-width: 900px) {
        .about-masonry {
            column-count: 2;
        }
    }

    @media (max-width: 560px) {
        .about-masonry {
            column-count: 1;
        }

        .about-split-item__media {
            flex: 0 0 140px;
            width: 140px;
        }
    }

    .about-shop-carousel .carousel-track {
        display: flex;
        gap: 12px;
        transition: transform 0.35s ease;
    }

    .about-shop-carousel .slide {
        background: transparent;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .about-shop-carousel .slideImgContainer {
        position: relative;
        width: 100%;
        aspect-ratio: 1/1;
        overflow: hidden;
        background: #f7f7f7;
    }

    .about-shop-carousel .slideImgContainer img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .about-shop-carousel .slide .cert-frame__caption {
        margin: 8px 0 0;
        padding: 0;
        font-size: 0.85rem;
        text-align: center;
    }

    .about-shop-carousel .carousel {
        position: relative;
        overflow: hidden;
    }

    .about-shop-carousel .carousel-controls {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        aspect-ratio: 1 / 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 6px;
        pointer-events: none;
        z-index: 2;
    }

    .about-shop-carousel .arrow {
        pointer-events: auto;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.88);
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.18);
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .about-shop-carousel .arrow:hover {
        background: #fff;
        transform: scale(1.05);
    }

    .about-shop-carousel .freccia-sinistra,
    .about-shop-carousel .freccia-destra {
        color: var(--black);
        width: 18px;
    }

    .about-shop-carousel .arrow:hover .freccia-sinistra,
    .about-shop-carousel .arrow:hover .freccia-destra {
        color: var(--red);
    }

    .about-panel {
        background: #fff;
        padding: 20px;
        margin-top: 24px;
    }

    .about-portrait {
        flex: 0 0 160px;
        max-width: 160px;
        width: 160px;
    }

    .about-portrait.cert-frame {
        margin: 0;
    }

    .about-portrait img {
        width: 100%;
        height: auto;
    }
</style>
