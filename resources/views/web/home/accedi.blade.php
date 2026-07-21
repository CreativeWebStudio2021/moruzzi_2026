<style>
	.accedi-container{
		display:flex;
		gap:40px;
		padding-top:85px;
		padding-bottom:75px;
	}
	.offerte-speciali-titolo{
		font-family:'Inria Serif';
		font-size:36px;
		font-style:italic;
		font-weight:300;
		line-height:35px;
	}
	.offerte-speciali-testo-container{
		display:flex;
		flex-direction:column;
		gap:20px;
		color:#fff;
	}
	.offerte-speciali-container{
		flex:1;
		display:flex;
		background:var(--red);
	}
	.offerte-speciali-img-container{
		width:40%;
	}
	.offerte-speciali-text-container{
		width:60%;
	}
	@media (max-width: 1024px) {
		.accedi-container{
			flex-direction:column;
		}
	}
	@media (max-width: 600px) {
		.offerte-speciali-titolo{
			font-size:32px;
			line-height:30px;
		}
		.offerte-speciali-container{
			flex-direction:column;
		}
		.offerte-speciali-img-container{
			width:100%;
			height:200px;
		}
		.offerte-speciali-text-container{
			width:100%;
		}
	}
</style>	
<div class="generalMargin accedi-container">
	<div class="offerte-speciali-container">
		<div class="offerte-speciali-img-container">
			<div style="position:relative; width:100%; height:100%;">
				<img src="{{ asset('images/offerte_speciali.png') }}" alt="{{ image_alt_from_file('offerte_speciali.png') }}" loading="lazy" decoding="async" width="245" height="582" style="position:absolute; width:100%; height:100%; object-fit:cover;"/>
			</div>
		</div>
		<div class="offerte-speciali-text-container">
			<div style=" width:calc(100% - 40px); height:calc(100% - 70px); display:flex; flex-direction:column; justify-content:space-between; padding:20px 20px 50px;">
				<div class="offerte-speciali-testo-container">
					<span class="offerte-speciali-titolo">
						{!! __('home.offerte-speciali-titolo') !!}
					</span>
					<span>
						{!! __('home.offerte-speciali-testo') !!}
					</span>
				</div>
				<div style="display:flex; justify-content:end; margin-top:10px">
					@php
						$offersCategory = \App\Models\Category::find(969);
						$offersUrl = $offersCategory
							? url(current_locale_prefix() . $offersCategory->translated_link)
							: url('offerte-speciali.html');
					@endphp
					<a href="{{ $offersUrl }}">
						<div class="morButton morButton2 morButtonWhite">
							<span class="morButtonTxt">{{ __('general.approfondisci') }}</span>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	
	<style>
		.accedi-form{
			max-width:400px;
		}
		.inputFormText{
			width:100%;
			border:none;
			border-bottom:solid 1px var(--black);
			background:none;
		}
		.inputFormText:focus {
			outline: none;
			box-shadow: none;
		}
		.inputFormText::placeholder{
			font-family:'Inria Sans';
		}
		.registra-account-testo{
			width:70%;
			margin-top:50px;
		}
		@media (max-width: 1024px) {
			.accedi-form{
				max-width:100%;
			}
			.registra-account-testo{
				width:100%;
			}
		}
	</style>
	<div style="flex:1">
		<div style="padding:15px 0 50px;">
			<div style="width:100%; ">
				<span style="font-family:'Inria Serif'; font-size:36px; font-style:italic; font-weight:300; line-height:35px;">
					{{ __('home.accedi-account-titolo') }}
				</span>
				
				<form method="POST" action="{{ locale_route('login') }}" class="accedi-form">
					@csrf

					<input
						type="email"
						name="email"
						class="inputFormText"
						placeholder="{{ field_placeholder('auth.email') }}"
						style="margin-top:55px;"
						value="{{ old('email') }}"
						required
					/>
					@error('email')
						<div style="margin-top:5px; font-size:13px; color:#dc2626;">
							{{ $message }}
						</div>
					@enderror

					<input
						type="password"
						name="password"
						class="inputFormText"
						placeholder="{{ field_placeholder('auth.password') }}"
						style="margin-top:30px;"
						required
					/>
					@error('password')
						<div style="margin-top:5px; font-size:13px; color:#dc2626;">
							{{ $message }}
						</div>
					@enderror
					
					@include('web.common.form-required-note')

					<div style="margin-top:30px; display:flex; justify-content:space-between; align-items:center;">
						<a href="{{ locale_route('password.request') }}" style="text-decoration:underline;">
							{{ __('home.accedi-account-password-dimenticata') }}
						</a>
						<button type="submit" class="morButton morButton2" style="width:100px; margin-top:20px; font-size:18px; border:none;">
							<span class="morButtonTxt">{{ __('home.accedi-account-bottone') }}</span>
						</button>
					</div>
				</form>
				<div style="font-family:'Inria Serif'; font-size:36px; font-style:italic; font-weight:300; line-height:35px; margin-top:80px;">
					{{ __('home.registra-account-titolo') }}
				</div>
				<div class="registra-account-testo">
					<span>
						{{ __('home.registra-account-testo') }}
					</span>
					<div style="display:flex; justify-content:end;">
						<a href="{{ locale_route('account.register.page') }}">
							<div class="morButton morButton2" style="width:150px; margin-top:30px;">
								<span class="morButtonTxt">{{ __('home.registra-account-bottone') }}</span>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>