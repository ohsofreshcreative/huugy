<!--- posts preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Najnowsze wpisy</div>
			<span class="acf-preview__slug">acf/posts</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($posts_settings['title']))
		<p class="text-h5">{{ $posts_settings['title'] }}</p>
		@endif
		@if (!empty($posts_settings['text']))
		<div>{!! $posts_settings['text'] !!}</div>
		@endif
		@if (!empty($button['title']))
		<div class="acf-preview-actions"><span class="acf-preview-button">{{ $button['title'] }}</span></div>
		@endif
		@if (!empty($items))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-3">
			@foreach ($items as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if ($show_image && !empty($item['image']))
				<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($item['image'], 'thumbnail', false, ['class' => 'h-16 w-full object-cover']) !!}</figure>
				@endif
				<p>{{ $item['date'] }}@if (!empty($item['category'])) · {{ $item['category'] }}@endif</p>
				<p class="text-h6">{{ $item['title'] }}</p>
			</div>
			@endforeach
		</div>
		@endif
		<p>3 najnowsze wpisy (dane dynamiczne)</p>
	</div>
</div>
