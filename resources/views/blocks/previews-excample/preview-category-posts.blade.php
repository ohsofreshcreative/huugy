<!--- category-posts preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Baza wiedzy - Ostatnie wpisy</div>
			<span class="acf-preview__slug">acf/category-posts</span>
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
		@if (!empty($posts_settings['button']['title']))
		<div class="acf-preview-actions"><span class="acf-preview-button">{{ $posts_settings['button']['title'] }}</span></div>
		@endif
		@if (!empty($posts))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice((array) $posts, 0, 4) as $post)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($show_image) && has_post_thumbnail($post->ID))
				<figure class="acf-preview__media m-0">
					{!! get_the_post_thumbnail($post->ID, 'thumbnail', ['class' => 'h-16 w-16 object-contain']) !!}
				</figure>
				@endif
				<p class="text-h6">{{ get_the_title($post->ID) }}</p>
				@if (!empty($show_excerpt))
				<p>{{ get_the_excerpt($post) }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@else
		<p>Brak wpisów do wyświetlenia.</p>
		@endif
	</div>
</div>
