<!--- find preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Co znajdziesz</div>
			<span class="acf-preview__slug">acf/find</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_find['image']['ID']))
		<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($g_find['image']['ID'], 'thumbnail', false, ['class' => 'h-20 w-32 object-cover']) !!}</figure>
		@endif
		@if (!empty($g_find['header']))
		<p class="text-h5">{{ $g_find['header'] }}</p>
		@endif
		@if (!empty($r_find))
		<ul>
			@foreach ($r_find as $item)
			@if (!empty($item['label']))
			<li>{{ $item['label'] }}</li>
			@endif
			@endforeach
		</ul>
		@endif
	</div>
</div>
