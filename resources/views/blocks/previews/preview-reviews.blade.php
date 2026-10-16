<!--- reviews preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Opinie</div>
			<span class="acf-preview__slug">acf/reviews</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($header))
		<p class="text-h5">{{ $header }}</p>
		@endif
		@if (!empty($info))
		<div>{!! $info !!}</div>
		@endif
		@if (!empty($r_reviews))
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
			@foreach (array_slice($r_reviews, 0, 3) as $item)
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($item['name']))
				<p class="text-h6">{{ $item['name'] }}@if (!empty($item['rating'])) ({{ $item['rating'] }}/5)@endif</p>
				@endif
				@if (!empty($item['position']))
				<p>{{ $item['position'] }}</p>
				@endif
				@if (!empty($item['txt']))
				<div>{!! $item['txt'] !!}</div>
				@endif
			</div>
			@endforeach
		</div>
		@if (count($r_reviews) > 3)
		<p>+ {{ count($r_reviews) - 3 }} kolejnych opinii</p>
		@endif
		@endif
		<p>Opinie z opcji motywu</p>
	</div>
</div>
