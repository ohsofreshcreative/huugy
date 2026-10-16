<!--- categories preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Kategorie produktów</div>
			<span class="acf-preview__slug">acf/categories</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_categories['subtitle']))
		<p>{{ $g_categories['subtitle'] }}</p>
		@endif
		@if (!empty($g_categories['header']))
		<p class="text-h5">{{ $g_categories['header'] }}</p>
		@endif
		@if (!empty($items))
		<div class="acf-preview__grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
			@foreach (array_slice($items, 0, 8) as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['image']['ID']))
				<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($item['image']['ID'], 'thumbnail', false, ['class' => 'h-16 w-full object-cover']) !!}</figure>
				@endif
				<p class="text-h6">{{ $item['title'] }}</p>
			</div>
			@endforeach
		</div>
		@if (count($items) > 8)
		<p>+ {{ count($items) - 8 }} kolejnych kategorii</p>
		@endif
		@endif
	</div>
</div>
