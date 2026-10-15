<!--- cta -->

<section
	data-gsap-anim="section"
	@if (!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-cta relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper c-main">
		<div class="__inside relative isolate overflow-hidden radius bg-primary text-white p-8 lg:p-16">
			@if (!empty($g_octa['image']))
			<x-picture :image="$g_octa['image']" figureClass="__bg absolute inset-0 -z-20" class="absolute inset-0 w-full h-full object-cover object-right" loading="lazy" />
			@endif
			<div class="absolute inset-0 -z-10 pointer-events-none bg-linear-to-r from-primary-800 via-primary-800/90 to-primary-800/20" aria-hidden="true"></div>

			<div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-12 lg:gap-20">
				<div class="__content flex flex-col items-start">
					@if (!empty($g_octa['header']))
					<h4 data-gsap-element="header">{{ $g_octa['header'] }}</h4>
					@endif
					@if (!empty($g_octa['txt']))
					<div data-gsap-element="txt" class="__txt mt-2">{!! $g_octa['txt'] !!}</div>
					@endif

					@if (!$form && (!empty($g_octa['button1']['url']) || !empty($g_octa['button2']['url'])))
					<div class="inline-buttons mt-6">
						@if (!empty($g_octa['button1']['url']))
						<x-button :href="esc_url($g_octa['button1']['url'])" :target="$g_octa['button1']['target'] ?? '_self'" variant="white" class="group inline-flex! items-center text-secondary-dark! gap-4 whitespace-normal! pl-6! p-2!" data-gsap-element="btn">
							{{ $g_octa['button1']['title'] }}
							<span class="flex shrink-0 items-center justify-center w-12 h-12 rounded-full bg-primary text-white" aria-hidden="true">
								<x-icon.arrow-up class="-rotate-135 group-hover:-rotate-90 transition-transform duration-300 motion-reduce:transition-none" />
							</span>
						</x-button>
						@endif
						@if (!empty($g_octa['button2']['url']))
						<x-button :href="esc_url($g_octa['button2']['url'])" :target="$g_octa['button2']['target'] ?? '_self'" variant="white" data-gsap-element="btn">
							{{ $g_octa['button2']['title'] }}
						</x-button>
						@endif
					</div>
					@endif
				</div>

				@if ($form && !empty($g_octa['shortcode']))
				<div data-gsap-element="form" class="__form bg-white text-primary p-8 flex flex-col gap-6">
					@if (!empty($g_octa['title']))
					<h3>{{ $g_octa['title'] }}</h3>
					@endif
					{!! do_shortcode($g_octa['shortcode']) !!}
				</div>
				@endif
			</div>
		</div>
	</div>
</section>