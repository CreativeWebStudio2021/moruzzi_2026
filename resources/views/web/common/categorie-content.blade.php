@php
    $tags = $tags ?? collect();
    $categoryImages = \App\Models\Category::imageMap();
    $categoryImageFallback = $categoryImageFallback ?? true;
    $categoryFallbackUrl = asset('images/default_3.png');
@endphp
<style>
	.categorie-content-root .tagContainer{
		width:100%;
		border-bottom:1px solid var(--black);
		display:flex;
		flex-wrap: wrap;
		gap:10px;
		margin-bottom:20px;
	}
	.categorie-content-root .tag{
		display:flex;
		justify-content:center;
		align-items:center;
	}
	.categorie-content-root .tagInner{
		padding:10px 20px;
		border:solid 1px var(--black);
		border-bottom:none;
		border-radius:20px 20px 0 0;
		font-family:'Inria Serif';
		font-style:italic;
		font-size:24px;
		transition:all 0.3s ease;
		cursor:pointer;
		position:relative;
		z-index:1;
	}
	.categorie-content-root .tagLabel{
		display:inline-block;
		transition:transform 0.3s ease;
		transform-origin:center;
	}
	.categorie-content-root .tagInner:hover,
	.categorie-content-root .tagInner.active{
		background:var(--background);
		z-index:5;
		box-shadow:2px -2px 4px rgba(0,0,0,0.25);
	}
	.categorie-content-root .tagInner:hover .tagLabel,
	.categorie-content-root .tagInner.active .tagLabel{
		transform:scale(1.12);
	}
	.categorie-content-root .categorieContainer {
		overflow: hidden;
		transition: height 0.35s ease;
	}
	.categorie-content-root.is-panel .categorieContainer {
		height: auto !important;
		overflow: visible;
	}
	.categorie-content-root .categorieInner{
		display:grid;
		grid-template-columns: repeat(5, 1fr);
		gap:40px;
		padding-top:10px;
	}
	.categorie-content-root .categorie{
		display:flex;
		flex-direction:column;
		gap:20px;
		align-items:center;
		justify-content:center;
		text-align:center;
	}
	.categorie-content-root .categorieImg{
		width:128px;
		height:auto;
		max-width:100%;
		object-fit:contain;
		margin:0 auto;
		transition:transform 0.6s ease;
	}
	.categorie-content-root .categorieImg:hover{
		transform:scale(1.15);
	}
	.categorie-content-root .categorieTxt{
		width:235px;
		min-height:60px;
		font-size:24px;
		font-family:'Inria Serif';
		text-align:center;
	}
	.categorie-content-root .categorieBlock {
		opacity: 0;
		transition: opacity 0.35s ease;
		display: none;
	}
	.categorie-content-root .categorieBlock.active {
		opacity: 1;
		display: block;
	}
	@media (max-width: 1300px) {
		.categorie-content-root .categorieInner {
			grid-template-columns: repeat(3, 1fr);
		}

		.categorie-content-root .tagContainer{
			width:100%;
			border-bottom:1px solid var(--black);
			display:flex;
			flex-wrap: wrap;
			gap:0px;
			margin-bottom:0px;
		}

		.categorie-content-root .tagInner{
			padding:10px 20px;
			border:solid 1px var(--black);
			border-radius:20px 20px 0 0;
			font-family:'Inria Serif';
			font-style:italic;
			font-size:24px;
			transition:all 0.3s ease;
			cursor:pointer;
			position:relative;
			z-index:1;
			transform-origin: top left;
		}
		.categorie-content-root .tagInner:hover,
		.categorie-content-root .tagInner.active{
			background:var(--background);
			z-index:5;
			box-shadow:2px -2px 4px rgba(0,0,0,0.25);
		}
	}
	@media (max-width: 768px) {
		.categorie-content-root .tagInner {
			font-size: 18px;
			padding: 8px 14px;
		}
		.categorie-content-root .categorieInner {
			grid-template-columns: repeat(2, 1fr);
			gap: 24px;
		}
		.categorie-content-root .categorieImg {
			width: 100px;
		}
		.categorie-content-root .categorieTxt {
			width: 100%;
			font-size: 18px;
			min-height: 48px;
		}
	}
	@media (max-width: 480px) {
		.categorie-content-root .categorieInner {
			grid-template-columns: 1fr;
		}
	}
</style>

<div class="categorie-content-root">
	<div class="tagContainer">
		@foreach($tags as $index => $tag)
			<div class="tag">
				<div class="tagInner {{ $index === 0 ? 'active' : '' }}"
					 data-tag="{{ $tag->entity_id }}">
					<span class="tagLabel">{{ $tag->translated_name }}</span>
				</div>
			</div>
		@endforeach
	</div>
	<div class="categorieContainer">
		@foreach($tags as $tag)
			<div class="categorieBlock {{ $loop->first ? 'active' : '' }}"
				 data-block="{{ $tag->entity_id }}"
				 style="{{ $loop->first ? 'display:block;' : 'display:none;' }}">
				<div class="categorieInner">
					@php
						$locale = app()->getLocale();
						$base = app()->getLocale() === 'it' ? '' : app()->getLocale().'/';
					@endphp
					@foreach($tag->children as $child)
						@php
							$childImage = $categoryImages[$child->entity_id] ?? null;
							$hasVisibleImage = category_has_visible_image($childImage);
							$imageSrc = $hasVisibleImage
								? category_image_url($childImage, 'thumb')
								: ($categoryImageFallback ? $categoryFallbackUrl : null);
						@endphp
						<div class="categorie">
							<a href="{{ url($base.$child->translated_link) }}">
								@if($imageSrc)
									<img class="categorieImg"
										 src="{{ $imageSrc }}"
										 alt="{{ image_alt($child->translated_name, __('seo.img_category')) }}"
										 loading="{{ $loop->parent->first ? 'eager' : 'lazy' }}"
										 decoding="async"
										 width="200"
										 height="200">
								@endif
								<div class="categorieTxt">
									{{ $child->translated_name }}
								</div>
							</a>
						</div>
					@endforeach
				</div>
			</div>
		@endforeach
	</div>
</div>

<script>
(function() {
	function measureBlockHeight(block) {
		var inner = block.querySelector('.categorieInner');
		return inner ? inner.scrollHeight : block.scrollHeight;
	}

	function refreshActiveHeight(root) {
		var container = root.querySelector('.categorieContainer');
		var active = root.querySelector('.categorieBlock.active');
		if (!container || !active) return;

		if (root.classList.contains('is-panel')) {
			container.style.height = 'auto';
			return;
		}

		container.style.height = measureBlockHeight(active) + 'px';
	}

	function bindImageLoads(root) {
		var active = root.querySelector('.categorieBlock.active');
		if (!active) return;

		active.querySelectorAll('.categorieImg').forEach(function(img) {
			if (img.complete) return;
			img.addEventListener('load', function() { refreshActiveHeight(root); }, { once: true });
			img.addEventListener('error', function() { refreshActiveHeight(root); }, { once: true });
		});
	}

	function scheduleHeightRefresh(root) {
		refreshActiveHeight(root);
		requestAnimationFrame(function() {
			refreshActiveHeight(root);
			requestAnimationFrame(function() { refreshActiveHeight(root); });
		});
		setTimeout(function() { refreshActiveHeight(root); }, 350);
	}

	function initCategorieContent() {
		document.querySelectorAll('.categorie-content-root').forEach(function(root) {
			if (root.dataset.categorieInited) return;
			root.dataset.categorieInited = '1';

			if (root.closest('.boxCategorie')) {
				root.classList.add('is-panel');
			}

			var container = root.querySelector('.categorieContainer');
			var tags = root.querySelectorAll('.tagInner');

			var resizeObserver = null;
			if (!root.classList.contains('is-panel') && typeof ResizeObserver !== 'undefined') {
				resizeObserver = new ResizeObserver(function() {
					refreshActiveHeight(root);
				});
				var activeInner = root.querySelector('.categorieBlock.active .categorieInner');
				if (activeInner) resizeObserver.observe(activeInner);
			}

			function switchResizeTarget(block) {
				if (!resizeObserver) return;
				resizeObserver.disconnect();
				var inner = block && block.querySelector('.categorieInner');
				if (inner) resizeObserver.observe(inner);
			}

			scheduleHeightRefresh(root);
			bindImageLoads(root);

			tags.forEach(function(tag) {
				tag.addEventListener('click', function() {
					if (this.classList.contains('active')) return;

					var id = this.dataset.tag;
					var current = root.querySelector('.categorieBlock.active');
					var next = root.querySelector('.categorieBlock[data-block="' + id + '"]');

					tags.forEach(function(t) { t.classList.remove('active'); });
					this.classList.add('active');

					if (root.classList.contains('is-panel')) {
						if (current) {
							current.classList.remove('active');
							current.style.display = 'none';
							current.style.opacity = 0;
						}
						if (next) {
							next.style.display = 'block';
							next.classList.add('active');
							next.style.opacity = 1;
							switchResizeTarget(next);
							bindImageLoads(root);
						}
						return;
					}

					if (current) {
						current.style.opacity = 0;
					}

					setTimeout(function() {
						if (current) {
							current.classList.remove('active');
							current.style.display = 'none';
						}
						if (next) {
							next.style.display = 'block';
							next.classList.add('active');
							next.offsetHeight;
							next.style.opacity = 1;
							switchResizeTarget(next);
							scheduleHeightRefresh(root);
							bindImageLoads(root);
						}
					}, 200);
				});
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initCategorieContent);
	} else {
		initCategorieContent();
	}

	window.addEventListener('load', function() {
		document.querySelectorAll('.categorie-content-root').forEach(function(root) {
			scheduleHeightRefresh(root);
		});
	});

	document.addEventListener('categoriePanelOpened', function() {
		document.querySelectorAll('.boxCategorie .categorie-content-root').forEach(function(root) {
			scheduleHeightRefresh(root);
			bindImageLoads(root);
		});
	});
})();
</script>
