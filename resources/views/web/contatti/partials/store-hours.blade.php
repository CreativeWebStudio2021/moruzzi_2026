<section id="orari" class="contact-extra-block">
	<h2 class="contact-extra-block__title">{{ __('contact.hours_title') }}</h2>
	<p class="contact-extra-block__intro">{!! __('contact.hours_intro') !!}</p>

	<div class="contact-hours-grid">
		<div class="contact-hours-card">
			<h3 class="contact-hours-card__title">{{ __('contact.hours_winter_title') }}</h3>
			<p class="contact-hours-card__period">{!! __('contact.hours_winter_period') !!}</p>
			<table class="contact-hours-table">
				<tbody>
					@foreach(__('contact.hours_winter_rows') as $row)
						<tr>
							<th scope="row">{{ $row['day'] }}</th>
							<td>{!! $row['hours'] !!}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="contact-hours-card">
			<h3 class="contact-hours-card__title">{{ __('contact.hours_summer_title') }}</h3>
			<p class="contact-hours-card__period">{!! __('contact.hours_summer_period') !!}</p>
			<table class="contact-hours-table">
				<tbody>
					@foreach(__('contact.hours_summer_rows') as $row)
						<tr>
							<th scope="row">{{ $row['day'] }}</th>
							<td>{!! $row['hours'] !!}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
