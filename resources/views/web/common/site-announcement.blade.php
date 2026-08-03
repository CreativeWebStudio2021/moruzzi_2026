<style>
    .site-announcement {
        width: 100%;
        box-sizing: border-box;
        background: #fff;
        color: var(--red, #802810);
        border-top: 2px solid var(--red, #802810);
        border-bottom: 2px solid var(--red, #802810);
        font-family: 'Fira Sans', sans-serif;
        position: relative;
        z-index: 40;
    }
    .site-announcement__inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 12px 48px 12px 20px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .site-announcement__text {
        flex: 1;
        margin: 0;
        font-size: 15px;
        line-height: 1.45;
        font-weight: 600;
        white-space: pre-line;
    }
    .site-announcement__close {
        position: absolute;
        top: 8px;
        right: 12px;
        border: 0;
        background: transparent;
        color: var(--red, #802810);
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        padding: 4px 8px;
        opacity: 0.75;
    }
    .site-announcement__close:hover { opacity: 1; }
    .site-announcement-reopen {
        position: fixed;
        left: 16px;
        bottom: 0;
        z-index: 60;
        padding: 0;
        display: block;
    }
    .site-announcement-reopen__btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid var(--red, #802810);
        border-bottom: 0;
        border-radius: 6px 6px 0 0;
        background: #fff;
        color: var(--red, #802810);
        font-size: 12px;
        font-weight: 600;
        padding: 8px 12px;
        cursor: pointer;
        text-decoration: none;
        font-family: 'Fira Sans', sans-serif;
        box-shadow: 0 2px 8px rgba(0,0,0,.12);
    }
    .site-announcement-reopen__btn:hover {
        background: var(--red, #802810);
        color: #fff;
    }
    @media (max-width: 767px) {
        .site-announcement__inner { padding: 12px 40px 12px 14px; }
        .site-announcement__text { font-size: 14px; }
        .site-announcement-reopen { left: 12px; bottom: 0; }
    }
</style>

@if($siteAnnouncementActive && ! $siteAnnouncementDismissed)
    <div class="site-announcement" role="status" aria-live="polite" id="siteAnnouncement">
        <div class="site-announcement__inner">
            <p class="site-announcement__text">{{ $siteAnnouncement->message }}</p>
        </div>
        <form method="post" action="{{ locale_route('announcement.dismiss') }}" style="margin:0;">
            @csrf
            <button type="submit" class="site-announcement__close" title="Chiudi avviso" aria-label="Chiudi avviso">&times;</button>
        </form>
    </div>
@elseif($siteAnnouncementActive && $siteAnnouncementDismissed)
    <div class="site-announcement-reopen">
        <form method="post" action="{{ locale_route('announcement.reopen') }}" style="margin:0;">
            @csrf
            <button type="submit" class="site-announcement-reopen__btn" title="{{ $siteAnnouncement->reopenButtonLabel() }}">
                {{ $siteAnnouncement->reopenButtonLabel() }}
            </button>
        </form>
    </div>
@endif
