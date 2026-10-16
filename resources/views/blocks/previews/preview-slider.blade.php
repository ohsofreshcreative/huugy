<!--- slider preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Slider</div>
			<span class="acf-preview__slug">acf/slider</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_slider['header']))
		<p class="text-h5">{{ $g_slider['header'] }}</p>
		@endif
		@if (!empty($g_slider['text']))
		<div>{!! $g_slider['text'] !!}</div>
		@endif
		@if (!empty($slides))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice($slides, 0, 3) as $slide)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($slide['image_url']))
				<figure class="acf-preview__media m-0"><img src="{{ $slide['image_url'] }}" alt="{{ $slide['image_alt'] }}" class="h-16 w-full object-cover"></figure>
				@endif
				@if (!empty($slide['header']))
				<p class="text-h6">{{ $slide['header'] }}</p>
				@endif
				@if (!empty($slide['text']))
				<p>{{ $slide['text'] }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@if (count($slides) > 3)
		<p>+ {{ count($slides) - 3 }} kolejnych slajdów</p>
		@endif
		@endif
	</div>
</div>
