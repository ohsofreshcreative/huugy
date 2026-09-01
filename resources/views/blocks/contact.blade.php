<!--- contact --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-contact  relative' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	@if (!empty($g_contact_1['image']))
	<figure class="absolute inset-0 w-full h-full z-0 m-0">
		<picture class="w-full h-full">
			<img src="{{ $g_contact_1['image']['url'] }}" alt="{{ $g_contact_1['image']['alt'] }}" class="w-full h-full object-cover" />
		</picture>
	</figure>
	@endif

	@if (!empty($g_contact_1['image']))
	<div class="absolute inset-0 z-1 pointer-events-none opacity-90" style="background: linear-gradient(90deg, #B40061 5.84%, #4E002A 100.47%);"></div>
	@endif

	<div class="__wrapper c-main relative z-2 pt-10 pb-10 md:pt-24 md:pb-24">

		<div class="relative grid grid-cols-1 lg:grid-cols-2 items-center gap-10 z-10">
			<div class="__content flex flex-col justify-between">
				<h2 data-gsap-element="header" class="text-white m-header">{!! $g_contact_1['header'] !!}</h2>
				@if (!empty($g_contact_1['text']))
				<div data-gsap-element="txt" class="__txt m-header text-white [&_strong]:text-secondary! *:[&_strong]:font-semibold!">
					{!! $g_contact_1['text'] !!}
				</div>
				@endif
				<a data-gsap-element="txt" class="__phone flex items-center !text-white hover:!text-primary-200 w-max mt-6" href="tel:{{ $g_contact_1['phone'] }}">{{ $g_contact_1['phone'] }}</a>
				<a data-gsap-element="txt" class="__mail flex items-center !text-white hover:!text-primary-200 w-max mt-2" href="mailto:{{ $g_contact_1['mail'] }}">{{ $g_contact_1['mail'] }}</a>
				@if (!empty($g_contact_1['hours']))
				<div data-gsap-element="txt" class="__txt text-white [&_strong]:text-white! *:[&_strong]:font-semibold! mt-6">
					{!! $g_contact_1['hours'] !!}
				</div>
				@endif
				<x-button
					href="#lokalizacje"
					variant="secondary"
					class="!bg-secondary-200 hover:!bg-secondary-400 mt-6"
					data-gsap-element="btn">
					Sprawdź lokalizacje
				</x-button>
			</div>

			<div data-gsap-element="form" class="__form bg-white p-6 md:p-10">
				<h4 class="mb-4">{!! $g_contact_2['title'] !!}</h4>
				{!! do_shortcode($g_contact_2['shortcode']) !!}
			</div>
		</div>
	</div>

</section>