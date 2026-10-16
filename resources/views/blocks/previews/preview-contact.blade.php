<!--- contact preview --->

<div class="acf-preview" @if(!empty($nomt)) data-acf-nomt @endif>
	<div class="acf-preview__meta">
		<div class="acf-preview__heading">
			<div class="acf-preview__title">Kontakt</div>
			<span class="acf-preview__slug">acf/contact</span>
		</div>
		@include('partials.block-preview-settings')
	</div>
	<div class="acf-preview__content">
		@if (!empty($g_contact_1['image']['ID']))
		<figure class="acf-preview__media m-0">{!! wp_get_attachment_image($g_contact_1['image']['ID'], 'thumbnail', false, ['class' => 'h-20 w-32 object-cover']) !!}</figure>
		@endif
		@if (!empty($g_contact_1['header']))
		<p class="text-h5">{{ $g_contact_1['header'] }}</p>
		@endif
		@if (!empty($g_contact_1['text']))
		<div>{!! $g_contact_1['text'] !!}</div>
		@endif
		<div class="acf-preview__grid grid grid-cols-1 sm:grid-cols-2">
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($g_contact_1['phone']))
				<p>{{ $g_contact_1['phone'] }}</p>
				@endif
				@if (!empty($g_contact_1['mail']))
				<p>{{ $g_contact_1['mail'] }}</p>
				@endif
				@if (!empty($g_contact_1['address']))
				<div>{!! $g_contact_1['address'] !!}</div>
				@endif
				@if (!empty($g_contact_1['hours_header']))
				<p class="text-h6">{{ $g_contact_1['hours_header'] }}</p>
				@endif
				@if (!empty($g_contact_1['hours']))
				<div>{!! $g_contact_1['hours'] !!}</div>
				@endif
			</div>
			<div class="acf-preview__card flex flex-col gap-2">
				@if (!empty($g_contact_2['title']))
				<p class="text-h6">{{ $g_contact_2['title'] }}</p>
				@endif
				<p>Formularz: {{ !empty($g_contact_2['shortcode']) ? $g_contact_2['shortcode'] : 'brak' }}</p>
			</div>
		</div>
	</div>
</div>
