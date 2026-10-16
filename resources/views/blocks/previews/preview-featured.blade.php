<!--- featured preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Polecane produkty</div>
			<span class="acf-preview__slug">acf/featured</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_featured['badge']))
		<p>{{ $g_featured['badge'] }}</p>
		@endif
		@if (!empty($g_featured['header']))
		<p class="text-h5">{{ $g_featured['header'] }}</p>
		@endif
		@if (!empty($g_featured['text']))
		<div>{!! $g_featured['text'] !!}</div>
		@endif
		@if (!empty($button['title']))
		<div class="acf-preview-actions"><span class="acf-preview-button">{{ $button['title'] }}</span></div>
		@endif
		@if (!empty($items))
		<div class="acf-preview__grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
			@foreach ($items as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['image']['ID']))
				<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($item['image']['ID'], 'thumbnail', false, ['class' => 'h-16 w-full object-contain']) !!}</figure>
				@endif
				<p class="text-h6">{{ $item['title'] }}</p>
			</div>
			@endforeach
		</div>
		@endif
		@if (empty($g_featured['products']))
		<p>Produkty wyróżnione w WooCommerce (dane dynamiczne)</p>
		@endif
	</div>
</div>
