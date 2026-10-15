<!--- whyus -->

<section
	data-gsap-anim="section"
	@if (!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-whyus relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper c-main flex flex-col">
		@if (!empty($g_whyus['subtitle']) || !empty($g_whyus['header']) || !empty($g_whyus['text']))
		<div class="__top flex flex-col">
			@if (!empty($g_whyus['subtitle']))
			<p data-gsap-element="title" class="text-primary">{{ $g_whyus['subtitle'] }}</p>
			@endif
			@if (!empty($g_whyus['header']))
			<h2 data-gsap-element="header">{{ $g_whyus['header'] }}</h2>
			@endif
			@if (!empty($g_whyus['text']))
			<div class="__txt" data-gsap-element="txt">{!! $g_whyus['text'] !!}</div>
			@endif
		</div>
		@endif

		@if (!empty($r_whyus))
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-8">
			@foreach ($r_whyus as $item)
			<div
				@class([ '__card relative radius isolate overflow-hidden bg-primary text-white flex flex-col justify-between gap-24 p-6' , 'lg:row-span-2'=> $loop->index < 2,
					])
					data-gsap-element="card">
					@if (!empty($item['image']))
					<x-picture :image="$item['image']" figureClass="absolute inset-0 -z-20" class="absolute inset-0 w-full h-full object-cover" loading="lazy" />
					@endif
					<div class="absolute inset-0 bg-black/50 -z-10" aria-hidden="true"></div>
					<div class="__top flex flex-col items-start gap-3">
						<span class="bg-primary-lighter text-primary rounded-full px-3">{{ sprintf('%02d', $loop->iteration) }}</span>
						@if (!empty($item['header']))
						<p class="text-h6">{{ $item['header'] }}</p>
						@endif
					</div>
					@if (!empty($item['text']))
					<div class="__txt">{!! $item['text'] !!}</div>
					@endif
			</div>
			@endforeach
		</div>
		@endif
	</div>
</section>