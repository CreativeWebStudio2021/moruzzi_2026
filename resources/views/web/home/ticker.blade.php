<style>
	.ticker{
		width:100%;
		overflow:hidden;
		background:white; 
		color:var(--back);;
		white-space:nowrap;
	}

	.ticker-track{
		display:inline-flex;
		gap:10px;
		animation: tickerScroll 10s linear infinite;
	}

	.ticker span{
		font-family:'Inria Sans';
		font-size:30px;
	}

	@keyframes tickerScroll{
		0% {
			transform: translateX(0);
		}
		100% {
			transform: translateX(-50%);
		}
	}

</style>

<div class="ticker" role="button" tabindex="0" onclick="if(window.showNewsletterOverlay){ event.preventDefault(); window.showNewsletterOverlay(); }" onkeydown="if((event.key==='Enter'||event.key===' ')&&window.showNewsletterOverlay){ event.preventDefault(); window.showNewsletterOverlay(); }" title="{{ __('newsletter.title') }}" style="cursor:pointer;">
	<div class="ticker-track">
        <span>{{ __('home.iscriviti-newsletter') }}</span>
        <span>{{ __('home.iscriviti-newsletter') }}</span>
        <span>{{ __('home.iscriviti-newsletter') }}</span>
        <span>{{ __('home.iscriviti-newsletter') }}</span>
        <span>{{ __('home.iscriviti-newsletter') }}</span>

        <!-- DUPLICATO PER LOOP PERFETTO -->
        <span>{{ __('home.iscriviti-newsletter') }}</span>
        <span>{{ __('home.iscriviti-newsletter') }}</span>
        <span>{{ __('home.iscriviti-newsletter') }}</span>
        <span>{{ __('home.iscriviti-newsletter') }}</span>
        <span>{{ __('home.iscriviti-newsletter') }}</span>
    </div>
</div>
