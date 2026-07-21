<style>
	.user-overlay {
		position: fixed;
		inset: 0;
		background: rgba(0,0,0,0);
		opacity: 0;
		visibility: hidden;
		transition: opacity .3s ease, background .3s ease;
		display: flex;
		justify-content: flex-end;
		z-index: 9999;
	}

	.user-overlay.show {
		opacity: 1;
		visibility: visible;
		background: rgba(0,0,0,0.4);
	}

	.user-panel {
		width: 380px;
		height: 100%;
		background: #fff;
		transform: translateX(100%);
		transition: transform .35s cubic-bezier(.4,0,.2,1);
		display: flex;
		flex-direction: column;
	}

	.user-overlay.show .user-panel {
		transform: translateX(0);
	}

	.user-header {
		display: flex;
		justify-content: space-between;
		font-weight: bold;
		margin-bottom: 20px;
		background:var(--red);
		padding:20px;
		color:#fff;
	}

	.user-content {
		padding:20px;
	}

	.user-form {
		display: flex;
		flex-direction: column;
		gap: 12px;
	}

	.user-input {
		width: 100%;
		border: none;
		border-bottom: 1px solid var(--black);
		background: none;
		padding: 8px 2px;
		font-size: 14px;
	}

	.user-input:focus {
		outline: none;
		box-shadow: none;
	}

	.user-menu a {
		display: block;
		padding: 10px 0;
		border-bottom: 1px solid #eee;
		color: #333;
	}

	.user-errors {
		margin-top: 4px;
		color: #dc2626;
		font-size: 12px;
	}

	.user-links {
		margin-top: 30px;
		font-size: 13px;
		display: flex;
		flex-direction: column;
		gap: 4px;
	}

	.user-links a {
		color: var(--black);
		text-decoration: underline;
	}

	.logout-btn {
		background: #dc2626;
		color: #fff;
		padding: 10px;
		width: 100%;
		border: none;
		margin-top: 15px;
	}

</style>

<div id="userOverlay" class="user-overlay">
    <div class="user-panel">

        <div class="user-header">
            <span style="font-family:'Inria Serif'; font-size:30px; font-style:italic; font-weight:600; line-height:20px;">
                @auth
                    {{ __('account.my_account') }}
                @else
                    {{ __('account.login') }}
                @endauth
            </span>

            <span id="userClose" style="font-family:'Inria Serif'; font-size:30px; font-style:italic; font-weight:600; line-height:20px; cursor:pointer;">&times;</span>
        </div>

        <div class="user-content">

            @auth
                <div class="user-welcome">
                    {{ __('account.welcome') }} <b>{{ auth()->user()->nome ?? auth()->user()->name }}</b>
                </div>

                <div class="user-menu">
                    @if (Route::has('account.dashboard'))
                        <a href="{{ locale_route('account.dashboard') }}">
                            {{ __('account.my_account') }}
                        </a>
                    @endif

                    @if (Route::has('account.orders'))
                        <a href="{{ locale_route('account.orders') }}">
                            {{ __('account.my_orders') }}
                        </a>
                    @endif

                    @if (Route::has('account.shipping'))
                        <a href="{{ locale_route('account.shipping') }}">
                            {{ __('account.my_shipping_data') }}
                        </a>
                    @endif

                    @if (Route::has('account.password'))
                        <a href="{{ locale_route('account.password') }}">
                            {{ __('account.change_password') }}
                        </a>
                    @endif

                    <form method="POST" action="{{ locale_route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            {{ __('account.logout') }}
                        </button>
                    </form>
                </div>

            @else

                <form method="POST" action="{{ locale_route('login') }}" class="user-form">
                    @csrf

                    <p>{{ __('auth.already_registered_msg') }}</p>

                    <input type="email"
                           name="email"
                           class="user-input"
                           placeholder="{{ field_placeholder('auth.email') }}"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <div class="user-errors">{{ $message }}</div>
                    @enderror

                    <input type="password"
                           name="password"
                           class="user-input"
                           placeholder="{{ field_placeholder('auth.password') }}"
                           required>
                    @error('password')
                        <div class="user-errors">{{ $message }}</div>
                    @enderror

                    <label class="remember" style="font-size:13px; display:flex; align-items:center; gap:6px; margin-top:4px;">
                        <input type="checkbox"
                               name="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <span>{{ __('auth.remember_me') }}</span>
                    </label>

                    @include('web.common.form-required-note')

                    <button type="submit" class="morButton morButton2" style="width:160px; margin-top:15px; background:var(--background); border:none;">
                        <span class="morButtonTxt">{{ __('auth.login_button') }}</span>
                    </button>
                </form>

                <div class="user-links">
                    <a href="{{ locale_route('password.request') }}">
                        {{ __('auth.forgot_password_link') }}
                    </a>

                    <a href="{{ locale_route('account.register.page') }}">
                        {{ __('auth.register_now_link') }}
                    </a>
                </div>

            @endauth

        </div>
    </div>
</div>

<script>
	
	function openUserPanel() {
		document.getElementById('userOverlay')
			.classList.add('show');

		document.body.style.overflow = 'hidden';
	}

	function closeUserPanel() {
		document.getElementById('userOverlay')
			.classList.remove('show');

		setTimeout(() => {
			document.body.style.overflow = '';
		}, 300);
	}

	document.getElementById('userClose')
		.addEventListener('click', closeUserPanel);

	document.getElementById('userOverlay')
		.addEventListener('click', function(e) {
			if (e.target.id === 'userOverlay') {
				closeUserPanel();
			}
		});
	
	document.querySelectorAll('.headerUserIcon').forEach(function(el) {
		el.addEventListener('click', openUserPanel);
	});

	@php
		$overlayEmailError = $errors->first('email');
	@endphp

	@if (!empty($overlayEmailError) && $overlayEmailError === __('auth.failed'))
	document.addEventListener('DOMContentLoaded', function () {
		openUserPanel();
	});
	@endif

</script>