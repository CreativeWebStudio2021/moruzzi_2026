<style>
	.tagRegistrati{
		position:fixed; 
		top:50%; 
		left:47px; 
		background:#fff;
		padding:10px 20px; 
		border:solid 1px var(--black); 
		border-bottom:none; 
		border-radius:20px 20px 0 0; 
		font-family:'Irina Serif'; 
		font-style:italic; 
		font-size:24px;
		transform: rotate(90deg) translateX(-50%); 
		transform-origin: top left;
		transition:all 0.3s ease;
		cursor:pointer;
		z-index:1;
	}

	.tagRegistrati:hover, .tagRegistrati.active{
		background:var(--background); 
		transform: rotate(90deg) translateX(-50%) scale(1.04);
		z-index:5;
		box-shadow:2px -2px 4px rgba(0,0,0,0.25);
	}
	a.tagRegistrati{
		text-decoration:none;
		color:inherit;
		display:block;
	}

	@media (max-width: 768px) {
		.tagRegistrati{
			visibility:hidden;
		}
	}
</style>
<a href="{{ locale_route('account.register.page') }}" class="tagRegistrati" title="{{ __('auth.register') }}">
	{{ __('auth.register_button') }}
</a>