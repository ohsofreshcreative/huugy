<!--- banner -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-banner relative flex flex-col bg-gradient -spt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main grid grid-cols-1 lg:grid-cols-2 gap-10">
		<div class="__img order-1 md:order-2">
			@if (!empty($g_banner['image']))
			<x-picture
				:image="$g_banner['image']"
				figureClass="__img"
				class="h-full w-full"
				data-gsap-element="img" />
			@endif
		</div>
		<div class="__content order-2 md:order-1">
			@if (function_exists('yoast_breadcrumb'))
			<div data-gsap-element="bread" class="__breadcrumb text-primary [&_#breadcrumbs]:flex-wrap [&_a]:text-white lg:mb-16 !pt-4">
				{!! yoast_breadcrumb('<p id="breadcrumbs">', '</p>', false) !!}
			</div>
			@endif
			<div class="pt-2 pb-8">
				@if (!empty($g_banner['header']))
				<h1 data-gsap-element="header" class="text-white text-h4">
					{{ $g_banner['header'] }}
				</h1>
				@endif
				@if (!empty($g_banner['text']))
				<div data-gsap-element="txt" class="__txt text-white m-header">
					{!! $g_banner['text'] !!}
				</div>
				@endif
				@if (!empty($g_banner['button1']) || !empty($g_banner['button2']))
				<div class="inline-buttons m-btn">
					@if (!empty($g_banner['button1']))
					<x-button
						:href="$g_banner['button1']['url']"
						variant="primary"
						data-gsap-element="btn">
						{{ $g_banner['button1']['title'] }}
					</x-button>
					@endif
					@if (!empty($g_banner['button2']))
					<x-button
						:href="$g_banner['button2']['url']"
						variant="white"
						data-gsap-element="btn">
						{{ $g_banner['button2']['title'] }}
					</x-button>
					@endif
				</div>
				@endif
			</div>
		</div>
	</div>

</section>