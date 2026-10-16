<!--- content -->

@if (!empty($block->preview))
@include('blocks.previews.preview-content')
@else

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-content relative -smt overflow-hidden' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	@if ($bgshape)
	<img data-gsap-element="img" class="absolute -translate-y-1/2 -translate-x-1/2 opacity-20" src="{{ get_template_directory_uri() }}/resources/images/circle.svg">
	@endif

	@if ($bgshape2)
	<img data-gsap-element="img" class="absolute right-1/12 top-1/2 -translate-y-1/2 translate-x-1/2 opacity-20" src="{{ get_template_directory_uri() }}/resources/images/shape-logo.svg">
	@endif

	<div class="__wrapper c-main">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-20">
			<div class="__img order1 relative" data-gsap-element="img">
				@if (!empty($g_content['image']))
				<x-picture
					data-gsap-element="img"
					:image="$g_content['image']"
					:figureClass="'__img h-full' . ($stroke ? ' __img--stroke' : '')"
					class="w-full object-cover max-h-[600px]" />

				@endif
			</div>

			<div class="__content order2">
				<p data-gsap-element="title" class="__title">{{ $g_content['title'] }}</p>
				<h2 data-gsap-element="header" class="text-h4">{{ $g_content['header'] }}</h2>

				<div data-gsap-element="txt" class="m-header __txt">
					{!! $g_content['text'] !!}
				</div>

				@if (!empty($g_content['button1']) || !empty($g_content['button2']))
				<div class="inline-buttons m-btn">
					@if (!empty($g_content['button1']))
					<x-button
						:href="$g_content['button1']['url']"
						variant="primary"
						class=""
						data-gsap-element="btn">
						{{ $g_content['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_content['button2']))
					<x-button
						:href="$g_content['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_content['button2']['title'] }}
					</x-button>
					@endif
				</div>
				@endif

			</div>

		</div>
	</div>
</section>

@endif
