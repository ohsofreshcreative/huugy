<!--- steps -->

<section
	data-gsap-anim="section"
	@if (!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-steps relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper c-main flex flex-col gap-10">
		@if (!empty($g_steps['header']) || !empty($g_steps['text']))
		<div class="__top flex flex-col items-center gap-6 text-center">
			@if (!empty($g_steps['header']))
			<h2 data-gsap-element="header">{{ $g_steps['header'] }}</h2>
			@endif
			@if (!empty($g_steps['text']))
			<div class="__txt" data-gsap-element="txt">{!! $g_steps['text'] !!}</div>
			@endif
		</div>
		@endif

		@if (!empty($r_steps))
		<div class="__inside relative overflow-hidden grid grid-cols-1 lg:grid-cols-4 items-center gap-8 lg:gap-16 bg-background-light text-black radius p-6 lg:p-12">
			<img class="absolute opacity-20 top-0 left-0 -translate-x-1/2 -translate-y-1/2 pointer-events-none" src="{{ get_template_directory_uri() }}/resources/images/circle.svg" />
			<div class="__nav flex flex-col gap-3" role="tablist" aria-label="Kroki procesu" aria-orientation="vertical">
				@foreach ($r_steps as $item)
				<x-button
					tag="button"
					type="button"
					variant="outline-primary"
					class="group relative w-full! whitespace-normal! aria-selected:bg-primary! aria-selected:text-white!"
					role="tab"
					id="{{ $tabs_id }}-tab-{{ $loop->index }}"
					aria-controls="{{ $tabs_id }}-panel-{{ $loop->index }}"
					aria-selected="{{ $loop->first ? 'true' : 'false' }}"
					tabindex="{{ $loop->first ? '0' : '-1' }}">
					@if (!empty($g_steps['logo']['url']))
					<span class="pointer-events-none bg-primary border-5 border-white absolute left-0 top-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 scale-75 rounded-full group-aria-selected:opacity-100 group-aria-selected:scale-100 transition-all duration-300 ease-out motion-reduce:transition-none p-2" aria-hidden="true">
						<img src="{{ esc_url($g_steps['logo']['url']) }}" alt="" class="w-4 h-4 object-contain" />
					</span>
					@endif
					{{ ($item['title'] ?? '') ?: 'Krok ' . $loop->iteration }}
				</x-button>
				@endforeach
			</div>

			<div class="lg:col-span-3 min-w-0">
				@foreach ($r_steps as $item)
				<div
					role="tabpanel"
					id="{{ $tabs_id }}-panel-{{ $loop->index }}"
					aria-labelledby="{{ $tabs_id }}-tab-{{ $loop->index }}"
					tabindex="0"
					@if (!$loop->first) hidden @endif>
					<div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8 lg:gap-12">
						<div class="__content flex flex-col items-start">
							<p class="!text-body">{{ !empty($item['number']) ? $item['number'] : 'Krok ' . $loop->iteration }}</p>
							@if (!empty($item['header']) || !empty($item['title']))
							<h3 class="!text-body mt-2">{{ ($item['header'] ?? '') ?: ($item['title'] ?? '') }}</h3>
							@endif
							@if (!empty($item['text']))
							<div class="__txt [&_p]:!text-body">{!! $item['text'] !!}</div>
							@endif
							@if (!empty($item['button']['url']))
							<x-button :href="esc_url($item['button']['url'])" variant="outline-primary-small mt-4" :target="$item['button']['target'] ?? '_self'">
								{{ $item['button']['title'] }}
							</x-button>
							@endif
						</div>
						@if (!empty($item['image']))
						<x-picture :image="$item['image']" figureClass="__img" class="w-full object-contain" loading="lazy" />
						@endif
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif
	</div>
</section>