<!--- cta preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">CTA</div>
			<span class="acf-preview__slug">acf/cta</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_octa['image']['ID']))
		<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($g_octa['image']['ID'], 'thumbnail', false, ['class' => 'h-20 w-32 object-cover']) !!}</figure>
		@endif
		@if (!empty($g_octa['header']))
		<p class="text-h5">{{ $g_octa['header'] }}</p>
		@endif
		@if (!empty($g_octa['txt']))
		<div>{!! $g_octa['txt'] !!}</div>
		@endif
		@if ($form)
		<p>Formularz: {{ !empty($g_octa['shortcode']) ? $g_octa['shortcode'] : 'brak' }}</p>
		@else
		<div class="acf-preview-actions">
			@if (!empty($g_octa['button1']['title']))
			<span class="acf-preview-button">{{ $g_octa['button1']['title'] }}</span>
			@endif
			@if (!empty($g_octa['button2']['title']))
			<span class="acf-preview-button">{{ $g_octa['button2']['title'] }}</span>
			@endif
		</div>
		@endif
		<p>Treść z opcji motywu (CTA)</p>
	</div>
</div>
