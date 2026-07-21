@extends('web.layout')

@section('content')

@include('web.contatti.partials.page-styles')

<section class="section-big-pt-space b-g-light">
	<div class="generalMargin" style="padding:40px 0 80px;">
		<h1  style="margin-top:0; margin-bottom:30px; font-size:50px; font-style:italic; line-height:40px; font-family:'Inria Serif'; color:var(--red)">
			{{ __('contact.title') }}
		</h1>	
		<div style="display:flex; flex-wrap:wrap; gap:40px;">
			<div style="flex:1">			
				
				<p style="margin-bottom:30px; margin-top:0;">
					{{ __('contact.intro') }}
				</p>

				<form method="POST" action="{{ locale_route('contact.submit') }}">
					@csrf
					<input type="hidden" name="_started" value="{{ time() }}">
					<div aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;">
						<label for="contact_website">Website</label>
						<input type="text" name="website" id="contact_website" tabindex="-1" autocomplete="off" value="">
					</div>

					<div style="display:flex; gap:20px; flex-wrap:wrap;">
						<div style="flex:1 1 180px;">
							<input
								type="text"
								name="nome"
								class="inputFormText"
								placeholder="{{ field_placeholder('contact.name') }}"
								value="{{ old('nome') }}"
								required
								style="margin-top:10px;"
							/>
							@error('nome')
								<div style="margin-top:5px; font-size:13px; color:#dc2626;">
									{{ $message }}
								</div>
							@enderror
						</div>
						<div style="flex:1 1 180px;">
							<input
								type="text"
								name="cognome"
								class="inputFormText"
								placeholder="{{ field_placeholder('contact.surname') }}"
								value="{{ old('cognome') }}"
								required
								style="margin-top:10px;"
							/>
							@error('cognome')
								<div style="margin-top:5px; font-size:13px; color:#dc2626;">
									{{ $message }}
								</div>
							@enderror
						</div>
					</div>

					<input
						type="email"
						name="email"
						class="inputFormText"
						placeholder="{{ field_placeholder('contact.email') }}"
						value="{{ old('email') }}"
						required
						style="margin-top:30px; width:100%;"
					/>
					@error('email')
						<div style="margin-top:5px; font-size:13px; color:#dc2626;">
							{{ $message }}
						</div>
					@enderror

					<input
						type="text"
						name="telefono"
						class="inputFormText"
						placeholder="{{ field_placeholder('contact.phone', false) }}"
						value="{{ old('telefono') }}"
						style="margin-top:30px; width:100%;"
					/>
					@error('telefono')
						<div style="margin-top:5px; font-size:13px; color:#dc2626;">
							{{ $message }}
						</div>
					@enderror

					<textarea
						name="messaggio"
						class="inputFormText"
						placeholder="{{ field_placeholder('contact.message') }}"
						required
						style="margin-top:30px; width:100%; min-height:120px; resize:vertical; padding-top:6px;"
					>{{ old('messaggio') }}</textarea>
					@error('messaggio')
						<div style="margin-top:5px; font-size:13px; color:#dc2626;">
							{{ $message }}
						</div>
					@enderror

					@include('web.common.form-required-note')

					<div style="margin-top:30px; display:flex; justify-content:flex-end;">
						<button type="submit" class="morButton morButton2" style="width:150px; font-size:18px; border:none;">
							<span class="morButtonTxt">{{ __('contact.submit') }}</span>
						</button>
					</div>
				</form>
			</div>

			<div style="flex:1;">
				<div style="font-size:24px; margin-bottom:10px; font-weight:700;">
					Moruzzi Numismatica
				</div>
				<div style="margin-bottom:12px;">
					<div>Viale dei Salesiani, 12a - 00175 Roma</div>
				</div>
				<div style="margin-bottom:12px;">
					<div>+39 0671510220</div>
					<div>+39 0671545937</div>
				</div>
				<div style="margin-bottom:12px;">
					<div>P.IVA 01614081006</div>
				</div>
			<div style="margin-bottom:12px;">
				@php $siteEmail = config('mail.from.address'); @endphp
				@if($siteEmail)
					<div>Email: <a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a></div>
				@endif
			</div>
				<div style="margin-bottom:12px; display:flex; gap:10px;">
					<a href="https://www.facebook.com/moruzzi.numismatica" target="_blank" title="">
						<x-icon name="facebook" class="socialItem"/>
					</a>
					<a href="https://x.com/Moruzzi_Monete" target="_blank" title="">
						<x-icon name="x" class="socialItem"/>
					</a>
					<a href="https://www.instagram.com/moruzzi_numismatica/?hl=it" target="_blank" title="">
						<x-icon name="instagram" class="socialItem"/>			
					</a>
					<a href="https://whatsapp.com/channel/0029Vb67PHi8qIzvmq7jS93x" target="_blank" title="">
						<x-icon name="whatsapp" class="socialItem"/>
					</a>
				</div>
				<div style="position:relative; width:100%; height:350px;">
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3009.354072893954!2d12.563395315415733!3d41.85681457922532!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132f61e65f7a1f3b%3A0x8cf0b2d27bb1e693!2sViale%20dei%20Salesiani%2C%2012A%2C%2000175%20Roma%20RM!5e0!3m2!1sit!2sit!4v1700000000000"
						style="border:0; position:absolute; top:0; left:0; width:100%; height:100%;"
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"
						allowfullscreen
					></iframe>
				</div>
			</div>
		</div>

		@include('web.contatti.partials.store-hours')
		@include('web.contatti.partials.ebay-shop')
	</div>
</section>
@endsection

