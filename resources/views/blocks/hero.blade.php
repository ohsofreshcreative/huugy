<!--- hero -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-hero relative bg-gradient overflow-hidden radius mx-0 md:mx-14' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>



	<div class="__wrapper c-main relative h-full flex items-center py-30">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-20 relative z-10">
			@if ($bgshape && !empty($bgshape_image))
			<div class="__media order-2 isolate grid grid-cols-1 items-center w-full">
				<div class="col-start-1 row-start-1 w-1/2 justify-self-end pointer-events-none" aria-hidden="true">
					<x-picture
						:image="$bgshape_image"
						class="w-full h-auto object-contain object-right" />
				</div>

				@if (!empty($g_hero['image']))
				<x-picture
					data-gsap-element="img"
					:image="$g_hero['image']"
					figureClass="__img relative z-10 col-start-1 row-start-1 w-4/5 justify-self-start"
					class="w-full h-auto object-contain object-left" />
				@endif
			</div>
			@elseif (!empty($g_hero['image']))
			<x-picture
				data-gsap-element="img"
				:image="$g_hero['image']"
				figureClass="__img h-full order-2 lg:w-[130%] lg:max-w-none"
				class="w-full h-full object-contain" />
			@endif

			<div class="__content order-1">
				@if(function_exists('yoast_breadcrumb'))
				<div class="__breadcrumb mb-4">
					{!! yoast_breadcrumb('<p id="breadcrumbs">','</p>') !!}
				</div>
				@endif
				<h1 data-gsap-element="header" class="text-h3 text-white">{{ $g_hero['header'] }}</h1>

				<div data-gsap-element="txt" class="__txt m-header text-white">
					{!! $g_hero['text'] !!}
				</div>

				@if (!empty($g_hero['button1']) || !empty($g_hero['button2']))
				<div class="inline-buttons m-btn">
					@if (!empty($g_hero['button1']))
					<x-button
						:href="$g_hero['button1']['url']"
						variant="primary"
						class=""
						data-gsap-element="btn">
						{{ $g_hero['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_hero['button2']))
					<x-button
						:href="$g_hero['button2']['url']"
						variant="white"
						class=""
						data-gsap-element="btn">
						{{ $g_hero['button2']['title'] }}
					</x-button>
					@endif
				</div>
				@endif

			</div>

		</div>
	</div>

</section>