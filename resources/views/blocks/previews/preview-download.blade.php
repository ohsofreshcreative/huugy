<!--- download preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Do pobrania</div>
			<span class="acf-preview__slug">acf/download</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($r_download))
		<ul>
			@foreach ($r_download as $item)
			@if (!empty($item['title']))
			<li>{{ $item['title'] }}@if (!empty($item['file']['filename'])) ({{ $item['file']['filename'] }})@endif</li>
			@endif
			@endforeach
		</ul>
		@else
		<p>Brak dokumentów</p>
		@endif
	</div>
</div>
