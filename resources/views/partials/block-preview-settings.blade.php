@php
$preview_settings = array_filter([
	'Tło' => !empty($background) && $background !== 'none' ? $background : null,
	'ID' => $section_id ?? null,
	'Klasa' => $section_class ?? null,
	'Odwrócenie' => !empty($flip) ? 'tak' : null,
	'Szeroki' => !empty($wide) ? 'tak' : null,
	'Bez marginesu' => !empty($nomt) ? 'tak' : null,
	'Większy odstęp' => !empty($gap) ? 'tak' : null,
]);
@endphp

@if (!empty($preview_settings))
<div class="acf-preview__settings">
	@foreach ($preview_settings as $label => $value)
	<span class="acf-preview__setting">{{ $label }}: {{ $value }}</span>
	@endforeach
</div>
@endif
