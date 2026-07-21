<style>
.guide-page-title {
    font-size: clamp(28px, 4.5vw, 50px);
}

.guide-page,
.guide-page .cert-block,
.guide-page .cert-split,
.catalog-main .catalog-description {
    max-width: 100%;
    min-width: 0;
}

.guide-page img,
.guide-page video,
.guide-page iframe,
.guide-page table,
.guide-page .cert-frame img {
    max-width: 100%;
    height: auto;
}

.guide-page table {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.guide-page .cert-split__body,
.guide-page .cert-block p,
.guide-page .guide-faq-item__answer {
    overflow-wrap: anywhere;
}

.product-carousel-section {
    max-width: 100%;
    min-width: 0;
}

.guide-lead {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 24px;
    color: var(--text-muted, #555);
}

.guide-sidebar-section {
    padding-left: 16px;
    padding-right: 12px;
}

.guide-sidebar-section + .guide-sidebar-section {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
}

.guide-sidebar-section-title {
    font-family: 'Inria Serif', serif;
    font-style: italic;
    font-size: 18px;
    margin-bottom: 8px;
    color: var(--red, #800000);
}

.guide-faq-item + .guide-faq-item {
    margin-top: 28px;
    padding-top: 28px;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
}

.guide-faq-item__question {
    margin: 0 0 12px;
    font-family: 'Inria Serif', serif;
    font-style: italic;
    font-size: 24px;
    line-height: 1.35;
    color: var(--red, #800000);
}

.guide-faq-item__answer {
    font-size: 16px;
    line-height: 1.7;
}

.guide-faq-item__answer a {
    color: var(--red, #800000);
    text-decoration: underline;
}

.guide-faq-item__media img {
    width: 100%;
    height: auto;
    display: block;
}

.guide-split + .guide-split,
.guide-figure + .guide-split,
.guide-table-wrap + .guide-split {
    margin-top: 28px;
}

.guide-split__body p + p {
    margin-top: 14px;
}

.guide-figure {
    max-width: 420px;
    margin-left: auto;
    margin-right: auto;
}

.guide-table-wrap {
    overflow-x: auto;
}

.guide-table-wrap table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
    line-height: 1.5;
}

.guide-table-wrap th,
.guide-table-wrap td {
    border: 1px solid rgba(0, 0, 0, 0.12);
    padding: 8px 10px;
    vertical-align: top;
}

.guide-table-wrap a {
    color: var(--red, #800000);
    text-decoration: underline;
}

.guide-hub-section + .guide-hub-section {
    margin-top: 36px;
    padding-top: 28px;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
}

.guide-hub-section__title {
    font-family: 'Inria Serif', serif;
    font-style: italic;
    font-size: 28px;
    margin: 0 0 12px;
    color: var(--red, #800000);
}

.guide-hub-links {
    list-style: none;
    margin: 0;
    padding: 0;
}

.guide-hub-links li + li {
    margin-top: 8px;
}

.guide-hub-links a {
    color: var(--black, #2d2d2d);
    text-decoration: none;
}

.guide-hub-links a:hover {
    color: var(--red, #800000);
    text-decoration: underline;
}

@media (max-width: 991px) {
    .guide-faq-item__question {
        font-size: 20px;
    }

    .guide-hub-section__title {
        font-size: 22px;
    }
}
</style>
