<!--- find -->

@if (!empty($block->preview))
@include('blocks.previews.preview-find')
@else

<section
	data-gsap-anim="section"
	@if (!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-find relative -smt overflow-hidden bg-primary-900 section-py',
	$sectionClass => filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper c-main relative">
		@if (!empty($g_find['header']))
		<h2 data-gsap-element="header" class="text-center text-white">{{ $g_find['header'] }}</h2>
		@endif

		<div class="__inside relative overflow-hidden radius bg-primary-50 p-6 md:p-10 mt-10">
			<img src="{{ get_template_directory_uri() }}/resources/images/shape-logo.svg" alt="" aria-hidden="true" class="pointer-events-none absolute -top-20 -left-16 w-80 opacity-15" />
			<img src="{{ get_template_directory_uri() }}/resources/images/shape-logo.svg" alt="" aria-hidden="true" class="pointer-events-none absolute -right-20 -bottom-28 w-96 opacity-15" />

			<div class="__col relative z-10 grid grid-cols-1 items-center gap-8 lg:grid-cols-[3fr_2fr]">
				@if (!empty($r_find))
				<div class="__labels flex flex-wrap gap-4">
					@foreach ($r_find as $item)
					@if (!empty($item['label']))
					<span data-gsap-element="card" class="bg-white px-4 py-2 rounded-full">{{ $item['label'] }}</span>
					@endif
					@endforeach
				</div>
				@endif

				@if (!empty($g_find['image']))
				<x-picture
					:image="$g_find['image']"
					figureClass="__image w-full lg:justify-self-end"
					class="w-full h-auto object-contain"
					data-gsap-element="img" />
				@endif
			</div>
		</div>
	</div>
</section>

@endif
