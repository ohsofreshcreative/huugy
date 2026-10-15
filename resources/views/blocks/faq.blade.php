<!--- faq --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-faq relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">

		<div class="__content text-center">
			<p data-gsap-element="title" class="">FAQ</p>
			<h4 data-gsap-element="header" class="">{{ $g_faq['header'] }}</h4>
		</div>
		<div data-gsap-element="tabs" class="tabs-wrapper flex flex-col mt-4">
			@foreach ($r_faq as $item)
			<div class="tabs bg-white border border-primary h-max radius">
				<input class="tab-check" type="checkbox" name="radio-a" id="check{{ $loop->index }}">
				<label class="tabs-label flex items-center justify-between" for="check{{ $loop->index }}">
					<div class="flex items-center gap-4">
						<p class="font-header">{{ $item['title'] }}</p>
					</div>

					<span class="__icon" aria-hidden="true">
						<span class="__plus text-primary">+</span>
						<span class="__minus text-primary">−</span>
					</span>
				</label>

				<div class="tabs-content">
					{!! $item['txt'] !!}
				</div>
			</div>
			@endforeach
		</div>

	</div>

</section>