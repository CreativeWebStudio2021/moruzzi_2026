@php
    $sharePageUrl = product_url($product);
    $shareProductName = $product->{'name_'.app()->getLocale()} ?? $product->name;
    $shareText = $shareProductName.' - '.$sharePageUrl;
    $shareLinks = [
        'facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($sharePageUrl),
        'x' => 'https://twitter.com/intent/tweet?url='.urlencode($sharePageUrl).'&text='.urlencode($shareProductName),
        'whatsapp' => 'https://wa.me/?text='.urlencode($shareText),
    ];
@endphp

<div class="product-share boxDati" id="product-share">
    <div class="product-share__title">{{ __('product.share_title') }}</div>
    <div class="product-share__links" role="list">
        <a
            href="{{ $shareLinks['facebook'] }}"
            class="product-share__link"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="{{ __('product.share_on_facebook') }}"
            title="{{ __('product.share_on_facebook') }}"
            role="listitem"
        >
            <span class="product-share__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="40" height="40">
                    <path fill="#1877F2" d="M24 4C12.954 4 4 12.954 4 24c0 10.494 7.652 19.188 17.676 20.726V31.115h-5.453v-6.365h5.453v-4.86c0-5.385 3.208-8.36 8.12-8.36 2.348 0 4.812.42 4.812.42v5.296h-2.713c-2.673 0-3.506 1.657-3.506 3.355v4.069h5.965l-.954 6.365h-5.011v13.611C36.348 43.188 44 34.494 44 24 44 12.954 35.046 4 24 4z"/>
                </svg>
            </span>
        </a>

        <a
            href="{{ $shareLinks['x'] }}"
            class="product-share__link"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="{{ __('product.share_on_x') }}"
            title="{{ __('product.share_on_x') }}"
            role="listitem"
        >
            <span class="product-share__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="40" height="40">
                    <circle cx="24" cy="24" r="20" fill="#000"/>
                    <path fill="#fff" d="M28.66 16h3.34l-7.3 8.34 8.59 11.35h-6.72l-5.26-6.88-6.02 6.88h-3.34l7.81-8.92-8.24-10.77h6.89l4.76 6.29 5.5-6.29zm-1.17 17.69h1.85L19.45 18.25h-1.99l9.03 15.44z"/>
                </svg>
            </span>
        </a>

        <a
            href="{{ $shareLinks['whatsapp'] }}"
            class="product-share__link"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="{{ __('product.share_on_whatsapp') }}"
            title="{{ __('product.share_on_whatsapp') }}"
            role="listitem"
        >
            <span class="product-share__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="40" height="40">
                    <circle cx="24" cy="24" r="20" fill="#25D366"/>
                    <g transform="translate(8 8) scale(1.3333333)">
                        <path fill="#fff" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </g>
                </svg>
            </span>
        </a>

        <button
            type="button"
            class="product-share__link product-share__link--copy"
            data-copy-share-url="{{ $sharePageUrl }}"
            aria-label="{{ __('product.share_copy_link') }}"
            title="{{ __('product.share_copy_link') }}"
            role="listitem"
        >
            <span class="product-share__icon product-share__icon--copy" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="40" height="40">
                    <rect x="8" y="14" width="24" height="28" rx="4" fill="#fff" stroke="#333" stroke-width="2"/>
                    <rect x="16" y="6" width="24" height="28" rx="4" fill="#fff" stroke="#333" stroke-width="2"/>
                </svg>
            </span>
        </button>
    </div>
    <p class="product-share__feedback" id="product-share-feedback" aria-live="polite" hidden></p>
</div>

<script>
(function () {
    const copyBtn = document.querySelector('#product-share [data-copy-share-url]');
    const feedback = document.getElementById('product-share-feedback');
    if (!copyBtn || !feedback) return;

    const copiedMessage = @json(__('product.share_link_copied'));

    copyBtn.addEventListener('click', async function () {
        const url = copyBtn.getAttribute('data-copy-share-url');
        if (!url) return;

        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(url);
            } else {
                const input = document.createElement('textarea');
                input.value = url;
                input.setAttribute('readonly', '');
                input.style.position = 'absolute';
                input.style.left = '-9999px';
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
            }

            feedback.textContent = copiedMessage;
            feedback.hidden = false;
            window.setTimeout(function () {
                feedback.hidden = true;
                feedback.textContent = '';
            }, 2500);
        } catch (e) {
            window.prompt(copiedMessage, url);
        }
    });
})();
</script>
