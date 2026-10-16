<!--- cantors preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Kantory</div>
			<span class="acf-preview__slug">acf/cantors</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_cantors['bg']['ID']))
		<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($g_cantors['bg']['ID'], 'thumbnail', false, ['class' => 'h-20 w-32 object-cover']) !!}</figure>
		@endif
		@if (!empty($g_cantors['header']))
		<p class="text-h5">{{ $g_cantors['header'] }}</p>
		@endif
		@if (!empty($g_cantors['text']))
		<p>{!! $g_cantors['text'] !!}</p>
		@endif
		@if (!empty($g_cantors['buttons']))
		<div class="acf-preview-actions">
			@foreach ((array) $g_cantors['buttons'] as $button)
			@if (!empty($button['label']))
			<span class="acf-preview-button">{{ $button['label'] }}</span>
			@endif
			@endforeach
		</div>
		@endif
		@if (!empty($r_cantors))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice((array) $r_cantors, 0, 4) as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['image']['ID']))
				<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($item['image']['ID'], 'thumbnail', false, ['class' => 'h-16 w-full object-cover']) !!}</figure>
				@endif
				@if (!empty($item['title']))
				<p class="text-h6">{{ $item['title'] }}</p>
				@endif
				@if (!empty($item['address']))
				<p>{!! $item['address'] !!}</p>
				@endif
				@if (!empty($item['phone']))
				<p>{{ $item['phone'] }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@endif
	</div>
</div>
