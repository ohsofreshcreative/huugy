<!--- action -->

<section
	@if (!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-action relative mt-10 mb-8' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper">
		<div class="__inside relative isolate overflow-hidden radius bg-primary text-white p-8 lg:p-16">
			@if (!empty($g_action['image']))
			<x-picture :image="$g_action['image']" figureClass="__bg absolute inset-0 -z-20" class="absolute inset-0 w-full h-full object-cover object-right" loading="lazy" />
			@endif
			<div class="absolute inset-0 -z-10 pointer-events-none bg-linear-to-r from-primary-800 via-primary-800/90 to-primary-800/20" aria-hidden="true"></div>

			<div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-12 lg:gap-20">
				<div class="__content flex flex-col items-start">
					@if (!empty($g_action['header']))
					<p data-gsap-element="header" class="text-h4 !mt-0">{{ $g_action['header'] }}</p>
					@endif
					@if (!empty($g_action['text']))
					<div data-gsap-element="txt" class="__txt [&_p]:!mt-2">{!! $g_action['text'] !!}</div>
					@endif

					@if (!empty($g_action['button1']['url']))
					<div class="inline-buttons mt-6">
						<x-button :href="esc_url($g_action['button1']['url'])" :target="$g_action['button1']['target'] ?? '_self'" variant="white" class="group inline-flex! items-center text-secondary-dark! gap-4 whitespace-normal! pl-6! p-2!" data-gsap-element="btn">
							{{ $g_action['button1']['title'] }}
							<span class="flex shrink-0 items-center justify-center w-12 h-12 rounded-full bg-primary text-white" aria-hidden="true">
								<x-icon.arrow-up class="-rotate-135 group-hover:-rotate-90 transition-transform duration-300 motion-reduce:transition-none" />
							</span>
						</x-button>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>