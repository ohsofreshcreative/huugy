<!--- whyus preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Dlaczego my</div>
			<span class="acf-preview__slug">acf/whyus</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_whyus['subtitle']))
		<p>{{ $g_whyus['subtitle'] }}</p>
		@endif
		@if (!empty($g_whyus['header']))
		<p class="text-h5">{{ $g_whyus['header'] }}</p>
		@endif
		@if (!empty($g_whyus['text']))
		<div>{!! $g_whyus['text'] !!}</div>
		@endif
		@if (!empty($r_whyus))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice($r_whyus, 0, 6) as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['image']['ID']))
				<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($item['image']['ID'], 'thumbnail', false, ['class' => 'h-10 w-10 object-contain']) !!}</figure>
				@endif
				@if (!empty($item['header']))
				<p class="text-h6">{{ $item['header'] }}</p>
				@endif
				@if (!empty($item['text']))
				<div>{!! $item['text'] !!}</div>
				@endif
			</div>
			@endforeach
		</div>
		@if (count($r_whyus) > 6)
		<p>+ {{ count($r_whyus) - 6 }} kolejnych kafelków</p>
		@endif
		@endif
	</div>
</div>
