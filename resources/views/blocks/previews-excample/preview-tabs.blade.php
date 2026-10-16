<!--- tabs preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Zakładki z mapą</div>
			<span class="acf-preview__slug">acf/tabs</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_tabs['title']))
		<p class="text-h5">{{ $g_tabs['title'] }}</p>
		@endif
		@if (!empty($g_tabs['txt']))
		<p>{{ $g_tabs['txt'] }}</p>
		@endif
		@if (!empty($r_tabs))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice((array) $r_tabs, 0, 4) as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['tab']))
				<p class="text-h6">{{ $item['tab'] }}</p>
				@endif
				@if (!empty($item['tab_desc']))
				<p>{!! $item['tab_desc'] !!}</p>
				@endif
				@if (!empty($item['tab_extra']))
				<p>{{ $item['tab_extra'] }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@endif
		@if (!empty($locations))
		<p>Mapa: {{ count((array) $locations) }} lokalizacji</p>
		@endif
	</div>
</div>
