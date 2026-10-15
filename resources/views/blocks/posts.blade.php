<!--- posts -->

<section
	data-gsap-anim="section"
	@if (!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-posts relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper c-main flex flex-col gap-12">
		@if (!empty($posts_settings['title']) || !empty($posts_settings['text']))
		<div class="__top flex flex-col gap-6">
			@if (!empty($posts_settings['title']))
			<h2 data-gsap-element="header">{{ $posts_settings['title'] }}</h2>
			@endif
			@if (!empty($posts_settings['text']))
			<div class="__txt">{!! $posts_settings['text'] !!}</div>
			@endif
		</div>
		@endif
		@if (!empty($items))
		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			@foreach ($items as $item)
			<a href="{{ esc_url($item['url']) }}" aria-label="{{ $item['title'] }}" class="__card group flex flex-col gap-6 border-b border-dotted border-primary pb-10" data-gsap-element="card">
				@if ($show_image && !empty($item['image']))
					<x-picture :image="$item['image']" class="w-full aspect-[3/2] object-cover radius" loading="lazy" />
				@endif
				<div class="flex flex-wrap items-center justify-between gap-3">
					@if (!empty($item['category']))
					<span class="bg-primary-800 text-white rounded-full text-sm px-3 py-2">{{ $item['category'] }}</span>
					@endif
					<time datetime="{{ $item['datetime'] }}" class="flex items-center gap-2">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-secondary" aria-hidden="true">
							<rect x="3" y="5" width="18" height="16" rx="2" />
							<path d="M7 3v4M17 3v4M3 10h18" />
						</svg>
						{{ $item['date'] }}
					</time>
				</div>
				@if (!empty($item['title']))
				<h2 class="text-h7">{{ $item['title'] }}</h2>
					@endif
					@if ($show_excerpt && !empty($item['excerpt']))
					<p>{{ $item['excerpt'] }}</p>
					@endif
					<div class="mt-auto">
						<span class="btn btn-primary group-hover:bg-primary-800! w-12! h-12! p-0! inline-flex! items-center justify-center" aria-hidden="true">
							<x-icon.arrow-up class="-rotate-135 group-hover:-rotate-90 transition-transform duration-300" />
						</span>
					</div>
			</a>
			@endforeach
		</div>
		@endif
		@if (!empty($button['url']))
		<div class="flex justify-center">
			<x-button :href="esc_url($button['url'])" variant="primary" :target="$button['target'] ?? '_self'">
				{{ $button['title'] ?: 'Sprawdź naszego bloga!' }}
			</x-button>
		</div>
		@endif
	</div>
</section>