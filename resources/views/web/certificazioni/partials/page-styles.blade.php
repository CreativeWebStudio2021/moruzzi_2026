<style>
    .cert-page {
        --cert-frame-bg: #f7f3ec;
        --cert-frame-border: rgba(45, 45, 45, 0.12);
        --cert-card-bg: rgba(255, 255, 255, 0.55);
        font-size: 16px;
        line-height: 1.75;
        color: var(--black);
    }

    .cert-lead {
        font-family: 'Inria Serif', serif;
        font-size: 1.25rem;
        font-style: italic;
        line-height: 1.6;
        margin: 0 0 28px;
        color: var(--black);
    }

    .cert-block {
        margin-bottom: 32px;
    }

    .cert-block p {
        margin: 0 0 14px;
    }

    .cert-block p:last-child {
        margin-bottom: 0;
    }

    .cert-reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.65s ease, transform 0.65s ease;
    }

    .cert-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .cert-callout {
        background: var(--cert-card-bg);
        border-left: 4px solid var(--red);
        padding: 18px 20px;
        border-radius: 0 8px 8px 0;
        box-shadow: 0 8px 24px rgba(45, 45, 45, 0.06);
    }

    .cert-callout__title {
        font-family: 'Inria Serif', serif;
        font-style: italic;
        font-size: 1.15rem;
        margin: 0 0 8px;
        color: var(--red);
    }

    .cert-whatsapp-box {
        background: #fff;
        padding: 22px 24px;
        border-radius: 8px;
        border: 1px solid rgba(45, 45, 45, 0.1);
        box-shadow: 0 8px 24px rgba(45, 45, 45, 0.08);
    }

    .cert-whatsapp-box .cert-split__media.cert-frame {
        background: transparent;
        border: none;
        box-shadow: none;
        padding: 0;
    }

    .cert-whatsapp-box .cert-split__media.cert-frame:hover {
        transform: none;
        box-shadow: none;
    }

    .cert-notice {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        background: rgba(128, 40, 16, 0.08);
        border: 1px solid rgba(128, 40, 16, 0.2);
        border-radius: 10px;
        padding: 16px 18px;
        margin-bottom: 28px;
    }

    .cert-notice__icon {
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--red);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: cert-pulse 2.4s ease-in-out infinite;
    }

    @keyframes cert-pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(128, 40, 16, 0.35); }
        50% { transform: scale(1.04); box-shadow: 0 0 0 8px rgba(128, 40, 16, 0); }
    }

    .cert-frame {
        display: block;
        width: fit-content;
        max-width: 100%;
        margin: 0 auto;
        background: var(--cert-frame-bg);
        border: 1px solid var(--cert-frame-border);
        border-radius: 10px;
        padding: 12px;
        box-shadow: 0 10px 28px rgba(45, 45, 45, 0.08);
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }

    .cert-frame:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px rgba(45, 45, 45, 0.12);
    }

    .cert-frame__link {
        display: block;
        cursor: zoom-in;
        line-height: 0;
    }

    .cert-frame img {
        display: block;
        width: auto;
        max-width: 100%;
        height: auto;
        margin: 0 auto;
        border-radius: 6px;
    }

    .cert-frame__caption {
        margin-top: 10px;
        font-size: 0.85rem;
        color: var(--blackLight);
        text-align: center;
    }

    .cert-media-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 20px;
        align-items: start;
        justify-items: center;
    }

    .cert-media-grid .cert-frame {
        width: fit-content;
        max-width: 100%;
    }

    .cert-media-grid--2 .cert-frame { grid-column: span 6; }
    .cert-media-grid--3 .cert-frame { grid-column: span 4; }
    .cert-media-grid--hero .cert-frame:first-child { grid-column: span 7; }
    .cert-media-grid--hero .cert-frame:last-child { grid-column: span 5; }
    .cert-media-grid--full .cert-frame {
        grid-column: span 12;
    }

    .cert-split {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-start;
    }

    .cert-split__media {
        flex: 0 0 160px;
        width: 160px;
        margin: 0;
    }

    .cert-split__media.cert-frame {
        margin: 0;
    }

    .cert-split__media.cert-frame img {
        display: block;
        width: 100%;
        height: auto;
        margin: 0;
    }

    .cert-split__media--compact {
        flex: 0 0 90px;
        width: 90px;
    }

    .cert-split__body {
        flex: 1 1 240px;
        min-width: 0;
        text-align: left;
    }

    .cert-split__body p {
        margin: 0 0 14px;
        text-align: left;
    }

    .cert-split__body p:last-child {
        margin-bottom: 0;
    }

    .cert-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    .cert-feature {
        background: var(--cert-card-bg);
        border: 1px solid var(--cert-frame-border);
        border-radius: 10px;
        padding: 18px;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .cert-feature:hover {
        transform: translateY(-3px);
        border-color: rgba(128, 40, 16, 0.35);
    }

    .cert-feature__title {
        font-family: 'Inria Serif', serif;
        font-style: italic;
        font-size: 1.05rem;
        margin: 0 0 8px;
        color: var(--red);
    }

    .cert-meters {
        display: grid;
        gap: 18px;
    }

    .cert-meter__head {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .cert-meter__bar {
        height: 10px;
        background: rgba(45, 45, 45, 0.1);
        border-radius: 999px;
        overflow: hidden;
    }

    .cert-meter__fill {
        display: block;
        height: 100%;
        width: 0;
        background: linear-gradient(90deg, var(--red), #a83a20);
        border-radius: inherit;
        transition: width 1.1s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .cert-meter.is-visible .cert-meter__fill {
        width: var(--cert-meter-value, 50%);
    }

    .cert-pricing {
        border: 1px solid var(--cert-frame-border);
        border-radius: 10px;
        overflow: hidden;
        background: var(--cert-card-bg);
    }

    .cert-pricing__row {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 16px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--cert-frame-border);
        align-items: start;
    }

    .cert-pricing__row:last-child {
        border-bottom: none;
    }

    .cert-pricing__price {
        font-family: 'Inria Serif', serif;
        font-style: italic;
        font-size: 1.1rem;
        color: var(--red);
        white-space: nowrap;
    }

    .cert-pricing__note {
        padding: 12px 18px;
        font-size: 0.9rem;
        color: var(--blackLight);
        background: rgba(255, 255, 255, 0.35);
        border-top: 1px solid var(--cert-frame-border);
    }

    .cert-links {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .cert-links a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 999px;
        border: 1px solid var(--blackLight);
        color: var(--black);
        text-decoration: none;
        font-size: 0.92rem;
        transition: background 0.25s ease, color 0.25s ease, border-color 0.25s ease;
    }

    .cert-links a:hover {
        background: var(--red);
        border-color: var(--red);
        color: #fff;
    }

    .cert-upgrade-flow {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 20px;
        background: var(--cert-card-bg);
        border-radius: 12px;
        border: 1px solid var(--cert-frame-border);
    }

    .cert-upgrade-flow__arrow {
        font-size: 1.6rem;
        color: var(--red);
        animation: cert-arrow-nudge 1.8s ease-in-out infinite;
    }

    @keyframes cert-arrow-nudge {
        0%, 100% { transform: translateX(0); opacity: 0.7; }
        50% { transform: translateX(6px); opacity: 1; }
    }

    @media (max-width: 900px) {
        .cert-split {
            flex-direction: column;
        }

        .cert-split__media {
            flex: 0 0 140px;
            width: 140px;
        }

        .cert-split__media--compact {
            flex: 0 0 80px;
            width: 80px;
        }

        .cert-media-grid--2 .cert-frame,
        .cert-media-grid--3 .cert-frame,
        .cert-media-grid--hero .cert-frame:first-child,
        .cert-media-grid--hero .cert-frame:last-child,
        .cert-media-grid--full .cert-frame {
            grid-column: span 12;
        }

        .cert-pricing__row {
            grid-template-columns: 1fr;
        }

        .cert-pricing__price {
            white-space: normal;
        }
    }

    .cert-list {
        margin: 0;
        padding-left: 1.2rem;
    }

    .cert-list li {
        margin: 0 0 12px;
        line-height: 1.7;
    }

    .cert-table-title {
        font-family: 'Inria Serif', serif;
        font-style: italic;
        font-size: 1.2rem;
        margin: 28px 0 12px;
    }

    .cert-table-title:first-child {
        margin-top: 0;
    }

    .cert-table-wrap {
        overflow-x: auto;
        margin-bottom: 8px;
    }

    .cert-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
        background: rgba(255, 255, 255, 0.55);
    }

    .cert-table th,
    .cert-table td {
        border: 1px solid rgba(45, 45, 45, 0.14);
        padding: 10px 12px;
        text-align: left;
        vertical-align: top;
    }

    .cert-table th {
        background: rgba(45, 45, 45, 0.06);
        font-family: 'DM Mono', monospace;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
</style>
