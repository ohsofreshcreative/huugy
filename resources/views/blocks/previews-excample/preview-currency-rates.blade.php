<!--- currency-rates preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Kursy walut</div>
			<span class="acf-preview__slug">acf/currency-rates</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_rates['title']))
		<p class="text-h5">{{ $g_rates['title'] }}</p>
		@endif
		@if (!empty($g_rates['txt']))
		<div>{!! $g_rates['txt'] !!}</div>
		@endif
		@if (!empty($locations))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice((array) $locations, 0, 4) as $i => $loc)
			<div class="acf-preview__card flex flex-col gap-2">
				<p class="text-h6">{{ $loc['name'] ?? 'Placówka ' . ($i + 1) }}</p>
				<p>{{ count($loc['rates'] ?? []) }} walut</p>
			</div>
			@endforeach
		</div>
		@else
		<p>Brak danych o kursach.</p>
		@endif
		@if (!empty($updated_at))
		<p>Aktualizacja: {{ is_numeric($updated_at) ? wp_date('d.m.Y H:i', $updated_at) : $updated_at }}</p>
		@endif
	</div>
</div>
