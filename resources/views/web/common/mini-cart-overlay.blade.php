<style>
	/* Overlay */
	.mini-cart-overlay {
		position: fixed;
		inset: 0;
		background: rgba(0,0,0,0);
		opacity: 0;
		visibility: hidden;
		transition: opacity 0.3s ease, background 0.3s ease;
		display: flex;
		justify-content: flex-end;
		z-index: 9999;
	}

	.mini-cart-overlay.show {
		opacity: 1;
		visibility: visible;
		background: rgba(0,0,0,0.4);
	}

	.mini-cart {
		width: 380px;
		max-width: 100%;
		height: 100%;
		background: #fff;
		display: flex;
		flex-direction: column;

		transform: translateX(100%);
		opacity: 0;
		transition: transform 0.35s cubic-bezier(.4,0,.2,1), opacity 0.3s ease;
	}

	.mini-cart-overlay.show .mini-cart {
		transform: translateX(0);
		opacity: 1;
	}

	.mini-cart-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-weight: bold;
		margin-bottom: 0;
		background: var(--red);
		padding: 20px;
		color: #fff;
		flex-shrink: 0;
	}

	.mini-cart-header .mini-cart-title {
		font-family: 'Inria Serif', serif;
		font-size: 22px;
		font-style: italic;
	}

	.mini-cart-close {
		font-size: 28px;
		line-height: 1;
		cursor: pointer;
		opacity: 0.9;
	}

	.mini-cart-body {
		padding: 20px;
		overflow-y: auto;
		scrollbar-width: none;
		-ms-overflow-style: none;
		flex: 1;
		display: flex;
		flex-direction: column;
		gap: 16px;
	}
	.mini-cart-body::-webkit-scrollbar {
		display: none;
	}

	/* Item: allineato al carrello (immagine + corpo con qty-box) */
	.mini-cart-item {
		display: flex;
		gap: 12px;
		align-items: flex-start;
		padding-bottom: 16px;
		border-bottom: 1px solid rgba(0,0,0,0.08);
	}

	.mini-cart-item:last-child {
		border-bottom: none;
		padding-bottom: 0;
	}

	.mini-cart-item-img {
		flex: 0 0 72px;
		width: 72px;
		height: 72px;
		background: #f5f5f5;
		overflow: hidden;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.mini-cart-item-img img {
		width: 100%;
		height: 100%;
		object-fit: contain;
		object-position: center;
	}

	.mini-cart-item-body {
		flex: 1;
		min-width: 0;
		display: flex;
		flex-direction: column;
		gap: 6px;
	}

	.mini-cart-item-title {
		font-size: 14px;
		font-weight: 600;
		color: var(--black);
		line-height: 1.3;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	.mini-cart-item-price {
		font-size: 14px;
		color: var(--red);
		font-weight: 600;
	}

	.mini-cart-item-row {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 10px;
		margin-top: 4px;
	}

	.mini-cart-item-qty {
		display: inline-flex;
		align-items: center;
		border: 1px solid #ddd;
		border-radius: 4px;
		overflow: hidden;
	}

	.mini-cart-item-qty input {
		width: 44px;
		border: none;
		text-align: center;
		font-size: 14px;
		padding: 4px 2px;
	}

	.mini-cart-item-qty button {
		background: #f1f1f1;
		border: none;
		width: 26px;
		height: 26px;
		cursor: pointer;
		font-size: 14px;
		line-height: 1;
	}

	.mini-cart-item-qty button:hover {
		background: #e0e0e0;
	}

	.mini-cart-item-remove {
		background: #333;
		border: none;
		color: #fff;
		padding: 4px 8px;
		cursor: pointer;
		font-size: 12px;
		flex-shrink: 0;
	}

	.mini-cart-footer {
		margin-top: auto;
		padding: 20px;
		border-top: 1px solid rgba(0,0,0,0.08);
		display: flex;
		flex-direction: column;
		gap: 12px;
	}

	.mini-cart-subtotal {
		font-size: 16px;
		font-weight: 600;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.mini-cart-footer-buttons {
		display: flex;
		flex-direction: column;
		gap: 10px;
	}

	.mini-cart-footer-buttons .morButton {
		width: 100%;
		text-align: center;
		text-decoration: none;
		display: flex;
		align-items: center;
		justify-content: center;
		box-sizing: border-box;
	}
</style>

<div id="miniCartOverlay" class="mini-cart-overlay">
    <div class="mini-cart">
        <div class="mini-cart-header">
            <span class="mini-cart-title">{{ __('cart.your_cart') }}</span>
            <span id="miniCartClose" class="mini-cart-close" aria-label="{{ __('general.chiudi') }}">&times;</span>
        </div>

        <div class="mini-cart-body">
            <div id="miniCartContent"></div>
        </div>

        <div class="mini-cart-footer" id="miniCartFooter" style="display: none;">
            <div class="mini-cart-subtotal">
                <span>{{ __('cart.total') }}:</span>
                <span id="miniCartSubtotal">€ 0,00</span>
            </div>

            <div class="mini-cart-footer-buttons">
                <a href="{{ locale_route('cart.index') }}" class="morButton morButton2 morButtonFit">
                    <span class="morButtonTxt">{{ __('cart.go_to_cart') }}</span>
                </a>
                <a href="{{ locale_route('checkout.options') }}" class="morButton morButton2 morButtonFit">
                    <span class="morButtonTxt">{{ __('cart.proceed_checkout') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
	var miniCartEmptyText = @json(__('cart.empty'));
	var miniCartTotalLabel = @json(__('cart.total'));

	function openMiniCart() {
		fetch(window.cartMiniUrl)
			.then(res => res.json())
			.then(data => {
				renderMiniCart(data);
				document.getElementById('miniCartOverlay').classList.add('show');
				document.body.style.overflow = 'hidden';
			});
	}

	function closeMiniCart() {
		document.getElementById('miniCartOverlay').classList.remove('show');
		setTimeout(function() {
			document.body.style.overflow = '';
		}, 300);
	}

	function renderMiniCart(data) {
		var container = document.getElementById('miniCartContent');
		var subtotalEl = document.getElementById('miniCartSubtotal');
		var footer = document.getElementById('miniCartFooter');

		if (!container) return;

		container.innerHTML = '';

		if (!data.items || data.items.length === 0) {
			container.innerHTML = '<p style="margin:0; color:var(--blackLight);">' + miniCartEmptyText + '</p>';
			if (subtotalEl) subtotalEl.textContent = '€ 0,00';
			if (footer) footer.style.display = 'none';
			return;
		}

		if (footer) footer.style.display = 'flex';

		function miniCartAlt(text) {
			text = (text || '').replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim();
			if (text.length <= 100) {
				return text;
			}
			var truncated = text.substring(0, 100);
			var lastSpace = truncated.lastIndexOf(' ');
			if (lastSpace >= 60) {
				truncated = truncated.substring(0, lastSpace);
			}
			return truncated.replace(/[\s.,;:-]+$/, '');
		}

		data.items.forEach(function(item) {
			var priceStr = (typeof item.price === 'number' ? item.price.toFixed(2) : item.price).toString().replace('.', ',');
			var imgSrc = (item.image || '').replace(/"/g, '&quot;');
			var title = (item.title || '').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
			var altText = miniCartAlt(item.title || '').replace(/"/g, '&quot;');
			var itemId = item.id;
			var qty = item.quantity || 1;

			var html = '<div class="mini-cart-item" data-item-id="' + itemId + '">' +
				'<div class="mini-cart-item-img">' +
				'<img src="' + imgSrc + '" alt="' + altText + '" loading="lazy">' +
				'</div>' +
				'<div class="mini-cart-item-body">' +
				'<div class="mini-cart-item-title">' + title + '</div>' +
				'<div class="mini-cart-item-price">€ ' + priceStr + '</div>' +
				'<div class="mini-cart-item-row">' +
				'<div class="mini-cart-item-qty">' +
				'<button type="button" class="mini-cart-qty-minus" data-item-id="' + itemId + '">−</button>' +
				'<input type="number" min="1" value="' + qty + '" data-item-id="' + itemId + '">' +
				'<button type="button" class="mini-cart-qty-plus" data-item-id="' + itemId + '">+</button>' +
				'</div>' +
				'<button type="button" class="mini-cart-item-remove" data-item-id="' + itemId + '">✕</button>' +
				'</div>' +
				'</div>' +
				'</div>';
			container.innerHTML += html;
		});

		if (subtotalEl && data.subtotal != null) {
			var subStr = (typeof data.subtotal === 'number' ? data.subtotal.toFixed(2) : data.subtotal).toString().replace('.', ',');
			subtotalEl.textContent = '€ ' + subStr;
		}
	}

	function refreshMiniCart() {
		fetch(window.cartMiniUrl)
			.then(res => res.json())
			.then(renderMiniCart);
	}

	document.querySelectorAll('.headerCartIcon').forEach(function(el) {
		el.addEventListener('click', openMiniCart);
	});

	document.getElementById('miniCartClose').addEventListener('click', closeMiniCart);

	document.getElementById('miniCartOverlay').addEventListener('click', function(e) {
		if (e.target.id === 'miniCartOverlay') {
			closeMiniCart();
		}
	});

	document.addEventListener('change', function(e) {
		var input = e.target;
		if (input.dataset.itemId && input.matches('.mini-cart-item-qty input')) {
			window.updateCartItem(input.dataset.itemId, input.value);
		}
	});

	document.addEventListener('click', function(e) {
		var minus = e.target.closest('.mini-cart-qty-minus');
		var plus = e.target.closest('.mini-cart-qty-plus');
		var remove = e.target.closest('.mini-cart-item-remove');
		if (minus) {
			var itemId = minus.dataset.itemId;
			var item = document.querySelector('.mini-cart-item[data-item-id="' + itemId + '"]');
			var input = item && item.querySelector('input[type="number"]');
			if (input) {
				var v = parseInt(input.value, 10) || 1;
				if (v <= 1) {
					var message = window.cartQtyMinConfirm || 'Remove this item from your cart?';
					if (!confirm(message)) return;
					window.removeCartItem(itemId);
					return;
				}
				input.value = v - 1;
				window.updateCartItem(itemId, v - 1);
			}
		}
		if (plus) {
			var itemId = plus.dataset.itemId;
			var item = document.querySelector('.mini-cart-item[data-item-id="' + itemId + '"]');
			var input = item && item.querySelector('input[type="number"]');
			if (input) {
				var v = (parseInt(input.value, 10) || 0) + 1;
				input.value = v;
				window.updateCartItem(itemId, v);
			}
		}
		if (remove && remove.dataset.itemId) {
			var removeMessage = window.cartRemoveConfirm || 'Remove this product?';
			if (!confirm(removeMessage)) return;
			window.removeCartItem(remove.dataset.itemId);
		}
	});

	window.refreshMiniCart = refreshMiniCart;
})();
</script>
