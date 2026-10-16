<!--- hero-sub preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Hero podstrony</div>
			<span class="acf-preview__slug">acf/hero-sub</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_hero_sub['image']['ID']))
		<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($g_hero_sub['image']['ID'], 'thumbnail', false, ['class' => 'h-20 w-32 object-contain']) !!}</figure>
		@endif
		@if (!empty($g_hero_sub['title']))
		<p class="text-h5">{!! $g_hero_sub['title'] !!}</p>
		@endif
		@if (!empty($g_hero_sub['txt']))
		<div>{!! $g_hero_sub['txt'] !!}</div>
		@endif
		<div class="acf-preview-actions">
			@if (!empty($g_hero_sub['button1']['title']))
			<span class="acf-preview-button">{{ $g_hero_sub['button1']['title'] }}</span>
			@endif
			@if (!empty($g_hero_sub['button2']['title']))
			<span class="acf-preview-button">{{ $g_hero_sub['button2']['title'] }}</span>
			@endif
		</div>
	</div>
</div>
