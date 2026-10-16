<!--- faq preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Najczęściej zadawane pytania</div>
			<span class="acf-preview__slug">acf/faq</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_faq['image']['ID']))
		<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($g_faq['image']['ID'], 'thumbnail', false, ['class' => 'h-20 w-32 object-cover']) !!}</figure>
		@endif
		@if (!empty($g_faq['header']))
		<p class="text-h5">{{ $g_faq['header'] }}</p>
		@endif
		@if (!empty($g_faq['text']))
		<div>{!! $g_faq['text'] !!}</div>
		@endif
		@if (!empty($g_faq['button']['title']))
		<div class="acf-preview-actions"><span class="acf-preview-button">{{ $g_faq['button']['title'] }}</span></div>
		@endif
		@if (!empty($r_faq))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2">
			@foreach (array_slice((array) $r_faq, 0, 4) as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['title']))
				<p class="text-h6">{{ $item['title'] }}</p>
				@endif
				@if (!empty($item['txt']))
				<div>{!! $item['txt'] !!}</div>
				@endif
			</div>
			@endforeach
		</div>
		@if (count((array) $r_faq) > 4)
		<p>+ {{ count((array) $r_faq) - 4 }} kolejnych pytań</p>
		@endif
		@endif
	</div>
</div>
