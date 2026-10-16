<!--- about preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">O nas</div>
			<span class="acf-preview__slug">acf/about</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_about['image']['ID']))
		<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($g_about['image']['ID'], 'thumbnail', false, ['class' => 'h-20 w-32 object-contain']) !!}</figure>
		@endif
		@if (!empty($g_about['header']))
		<p class="text-h5">{{ $g_about['header'] }}</p>
		@endif
		@if (!empty($g_about['txt']))
		<div>{!! $g_about['txt'] !!}</div>
		@endif
		@if (!empty($g_about['button']['title']))
		<div class="acf-preview-actions"><span class="acf-preview-button">{{ $g_about['button']['title'] }}</span></div>
		@endif
		@if (!empty($r_about))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice((array) $r_about, 0, 4) as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['image']['ID']))
				<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($item['image']['ID'], 'thumbnail', false, ['class' => 'h-12 w-12 object-contain']) !!}</figure>
				@endif
				@if (!empty($item['title']))
				<p class="text-h6">{{ $item['title'] }}</p>
				@endif
				@if (!empty($item['text']))
				<p>{{ $item['text'] }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@endif
	</div>
</div>
