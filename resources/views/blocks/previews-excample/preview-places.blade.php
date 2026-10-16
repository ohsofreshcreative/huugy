<!--- places preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Placówki</div>
			<span class="acf-preview__slug">acf/places</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_places['header']))
		<p class="text-h5">{{ strip_tags($g_places['header']) }}</p>
		@endif
		@if (!empty($g_places['text']))
		<p>{!! $g_places['text'] !!}</p>
		@endif
		@if (!empty($g_places['button']['title']))
		<div class="acf-preview-actions"><span class="acf-preview-button">{{ $g_places['button']['title'] }}</span></div>
		@endif
		@if (!empty($r_places))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice((array) $r_places, 0, 4) as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['image']['ID']))
				<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($item['image']['ID'], 'thumbnail', false, ['class' => 'h-12 w-12 object-cover']) !!}</figure>
				@endif
				@if (!empty($item['name']))
				<p class="text-h6">{{ $item['name'] }}</p>
				@endif
				@if (!empty($item['phone']))
				<p>{{ $item['phone'] }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@else
		<p>Brak placówek (Opcje → Lokacje).</p>
		@endif
	</div>
</div>
