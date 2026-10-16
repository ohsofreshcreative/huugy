<!--- promo preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Promocje</div>
			<span class="acf-preview__slug">acf/promo</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_promo['header']))
		<p class="text-h5">{{ $g_promo['header'] }}</p>
		@endif
		@if (!empty($r_promo))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2">
			@foreach ($r_promo as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['image']['ID']))
				<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($item['image']['ID'], 'thumbnail', false, ['class' => 'h-16 w-full object-cover']) !!}</figure>
				@endif
				@if (!empty($item['header']))
				<p class="text-h6">{{ $item['header'] }}</p>
				@endif
				@if (!empty($item['text']))
				<div>{!! $item['text'] !!}</div>
				@endif
				@if (!empty($item['button']['title']))
				<div class="acf-preview-actions"><span class="acf-preview-button">{{ $item['button']['title'] }}</span></div>
				@endif
			</div>
			@endforeach
		</div>
		@endif
	</div>
</div>
