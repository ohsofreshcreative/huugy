<!--- quote preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Cytat</div>
			<span class="acf-preview__slug">acf/quote</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_quote['image']['ID']))
		<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($g_quote['image']['ID'], 'thumbnail', false, ['class' => 'h-20 w-32 object-cover']) !!}</figure>
		@endif
		@if (!empty($g_quote['header']))
		<div class="text-h5">{!! $g_quote['header'] !!}</div>
		@endif
		@if (!empty($g_quote['text']))
		<div>{!! $g_quote['text'] !!}</div>
		@endif
		@if (!empty($g_quote['author']))
		<p>— {{ $g_quote['author'] }}</p>
		@endif
	</div>
</div>
