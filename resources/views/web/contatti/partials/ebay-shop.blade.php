<section id="ebay" class="contact-extra-block">
	<h2 class="contact-extra-block__title">{{ __('contact.ebay_title') }}</h2>
	<p class="contact-extra-block__intro">{!! __('contact.ebay_intro', ['url' => __('contact.ebay_url'), 'shop' => __('contact.ebay_shop_name')]) !!}</p>
	<p class="contact-extra-block__text">{!! __('contact.ebay_body') !!}</p>
	<p class="contact-extra-block__actions">
		<a
			href="{{ __('contact.ebay_url') }}"
			class="morButton morButton2 morButtonFit contact-ebay-btn"
			target="_blank"
			rel="noopener noreferrer"
		>
			<span class="morButtonTxt">{{ __('contact.ebay_cta') }}</span>
		</a>
	</p>
	<p class="contact-extra-block__note">
		<a href="{{ locale_route('shop.terms') }}">{{ __('contact.ebay_terms_link') }}</a>
	</p>
</section>
