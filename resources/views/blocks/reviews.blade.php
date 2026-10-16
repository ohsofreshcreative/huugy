<!--- reviews -->

@if (!empty($block->preview))
@include('blocks.previews.preview-reviews')
@else

<section
	data-gsap-anim="section"
	@if (!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-reviews relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper c-main flex flex-col gap-10">
		<div class="__top flex flex-wrap items-center justify-between gap-6">
			@if (!empty($header))
			<h2 data-gsap-element="header">{{ $header }}</h2>
			@endif
			@if (count($r_reviews) > 1)
			<div class="flex gap-4">
				<x-button tag="button" type="button" class="__prev w-12! h-12! p-0! inline-flex! items-center justify-center disabled:opacity-40" aria-label="Poprzednia opinia">
					<x-icon.arrow-up class="rotate-90" />
				</x-button>
				<x-button tag="button" type="button" class="__next w-12! h-12! p-0! inline-flex! items-center justify-center disabled:opacity-40" aria-label="Następna opinia">
					<x-icon.arrow-up class="-rotate-90" />
				</x-button>
			</div>
			@endif
		</div>
		@if (!empty($info))
		<div class="__info">{!! $info !!}</div>
		@endif

		@if (!empty($r_reviews))
		<div class="swiper reviews-swiper w-full min-w-0">
			<div class="swiper-wrapper">
				@foreach ($r_reviews as $card)
				<div class="swiper-slide h-auto!">
					<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 h-full">
						@if (!empty($card['project_image']))
						<div class="__img relative aspect-square lg:aspect-auto">
							<x-picture :image="$card['project_image']" figureClass="absolute inset-0" class="absolute inset-0 w-full h-full object-cover radius" loading="lazy" />
						</div>
						@endif
						<div @class([ '__card relative isolate text-primary-light p-8 flex flex-col justify-between gap-16 min-h-[400px]' , '__card-avatar'=> !empty($card['image']),
							'bg-primary radius' => empty($card['image']),
							'lg:col-span-2' => !empty($card['project_image']),
							'lg:col-span-3' => empty($card['project_image']),
							])>
							@if (!empty($card['image']))
							<span class="__corner" aria-hidden="true"></span>
							@endif
							@if (!empty($card['txt']))
							<blockquote class="__txt text-xl">{!! $card['txt'] !!}</blockquote>
							@endif
							<div @class(['flex items-end justify-between gap-6', 'pr-28'=> !empty($card['image'])])>
								<div class="__author flex flex-col gap-3">
									@if (!empty($card['name']))
									<p>{{ $card['name'] }}</p>
									@endif
									@if (!empty($card['position']))
									<p>{{ $card['position'] }}</p>
									@endif
								</div>
								@if (!empty($card['image']))
								<x-picture :image="$card['image']" figureClass="absolute bottom-0 right-0 w-24" class="w-24 h-24 object-cover radius" loading="lazy" />
								@endif
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@if (count($r_reviews) > 1)
		<div class="__pagination swiper-pagination static!" aria-label="Paginacja opinii"></div>
		@endif
		@endif
	</div>
</section>

@endif
