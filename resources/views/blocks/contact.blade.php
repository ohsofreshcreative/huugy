<!--- contact --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-contact relative overflow-hidden bg-primary-900' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<img src="{{ get_template_directory_uri() }}/resources/images/shape-logo.svg" alt="" aria-hidden="true" class="pointer-events-none absolute -top-20 -left-20 w-80 opacity-20" />
	<img src="{{ get_template_directory_uri() }}/resources/images/shape-logo.svg" alt="" aria-hidden="true" class="pointer-events-none absolute top-12 -right-20 w-96 opacity-20" />

	<div class="__wrapper c-main relative z-10 pt-10 pb-10 md:pt-24 md:pb-24">
		<div class="__top relative grid grid-cols-1 lg:grid-cols-[3fr_2fr] items-stretch overflow-hidden radius">
			@if (!empty($g_contact_1['image']))
			<x-picture
				:image="$g_contact_1['image']"
				figureClass="absolute inset-0 z-0"
				class="w-full h-full object-cover"
				data-gsap-element="img" />
			<div aria-hidden="true" class="pointer-events-none absolute inset-0 z-0 bg-primary-900/60"></div>
			@endif

			<div class="__intro relative z-10 flex p-6 md:p-10">
				<div class="relative z-10 flex h-full flex-col justify-end">
					@if (!empty($logo['url']))
					<img data-gsap-element="img" src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? $siteName }}" class="w-auto h-8 md:h-12 object-contain object-left brightness-0 invert" />
					@endif

					@if (!empty($g_contact_1['header']))
					<h4 data-gsap-element="header" class="text-white m-header">{{ $g_contact_1['header'] }}</h4>
					@endif

					@if (!empty($g_contact_1['text']))
					<div data-gsap-element="txt" class="__txt m-header text-white">
						{!! $g_contact_1['text'] !!}
					</div>
					@endif
				</div>
			</div>

			<div data-gsap-element="form" class="__form relative z-10 bg-white radius p-6 md:p-10 lg:my-4 lg:-ml-10 mr-4">
				@if (!empty($g_contact_2['title']))
				<h3 class="text-h5 m-title">{{ $g_contact_2['title'] }}</h3>
				@endif

				@if (!empty($g_contact_2['shortcode']))
				{!! do_shortcode($g_contact_2['shortcode']) !!}
				@endif
			</div>
		</div>

		@if (!empty($g_contact_1['phone']) || !empty($g_contact_1['mail']) || !empty($g_contact_1['address']) || !empty($g_contact_1['hours']))
		<div class="__data grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 md:mt-8">
			@if (!empty($g_contact_1['phone']) || !empty($g_contact_1['mail']) || !empty($g_contact_1['address']))
			<div data-gsap-element="card" class="__card bg-white radius p-6 md:p-10">
				<div class="flex flex-col gap-4">
					@if (!empty($g_contact_1['phone']))
					<a class="__phone text-gray hover:text-primary" href="tel:{{ str_replace(' ', '', $g_contact_1['phone']) }}">{{ $g_contact_1['phone'] }}</a>
					@endif

					@if (!empty($g_contact_1['mail']))
					<a class="__mail text-gray hover:text-primary" href="mailto:{{ $g_contact_1['mail'] }}">{{ $g_contact_1['mail'] }}</a>
					@endif

					@if (!empty($g_contact_1['address']))
					<div class="__address">
						{!! $g_contact_1['address'] !!}
					</div>
					@endif
				</div>
			</div>
			@endif

			@if (!empty($g_contact_1['hours']))
			<div data-gsap-element="card" class="__card bg-white radius p-6 md:p-10">
				@if (!empty($g_contact_1['hours_header']))
				<h3 class="text-h5 text-primary m-title">{{ $g_contact_1['hours_header'] }}</h3>
				@endif

				<div class="__hours">
					{!! $g_contact_1['hours'] !!}
				</div>
			</div>
			@endif
		</div>
		@endif
	</div>

</section>