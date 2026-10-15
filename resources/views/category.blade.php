@extends('layouts.app')

@section('content')

@php
$term = get_queried_object();
$categories = get_categories();

$default_category_id = (int) get_option('default_category');
usort($categories, fn ($a, $b) => ($b->term_id === $default_category_id) - ($a->term_id === $default_category_id));

$category_header = get_field('category_header', $term);
$category_description = get_field('category_description', $term);
$category_image = get_field('category_image', $term);

$cta = get_field('g_octa', 'option');
$form = !empty($cta['shortcode']);

// Pobranie pól ACF dla sekcji 'bottom'
$section_id = $bottom['section_id'] ?? '';
$section_class = $bottom['section_class'] ?? '';
$flip = $bottom['flip'] ?? false;

// Przygotowanie klas CSS
$sectionClass = '';
$sectionClass .= $flip ? ' order-flip' : '';

// Wygenerowanie unikalnego ID dla SVG
$unique_id = 'clip_'.uniqid();
@endphp

<div class="hero category-header relative bg-gradient -spt">
	<div class="__wrapper c-main relative z-10">
		@if (function_exists('yoast_breadcrumb'))
		<div data-gsap-element="bread" class="__breadcrumb text-primary [&_#breadcrumbs]:flex-wrap [&_a]:text-white">
			{!! yoast_breadcrumb('<p id="breadcrumbs" class="!pt-4">', '</p>', false) !!}
		</div>
		@endif
		<div class="__wrapper pt-10 pb-20">
			<div class="__content w-full md:w-1/2">
				<h2 class="text-h4 text-secondary">
					{!! $category_header ?: get_the_archive_title() !!}
				</h2>
				@if ($category_description)
				<div class="text-white m-header">
					{!! $category_description !!}
				</div>
				@endif
			</div>
		</div>
	</div>
</div>

<div id="category-tabs" class="category-tabs c-main z-20 relative -smt">
	<div class="flex flex-wrap gap-2 items-center">
		<div class="flex flex-wrap gap-2 items-center !font-medium tracking-wide">
			@foreach($categories as $category)
			@if($category->name !== 'Baza wiedzy')
			@php $isActive = $term && $term->term_id === $category->term_id; @endphp
			<a
				href="{{ get_category_link($category->term_id) }}"
				@if($isActive) aria-current="page" @endif
				@class(['__tab relative flex-shrink-0 block rounded-3xl px-8 py-4', 'bg-primary !text-white'=> $isActive, 'bg-white !text-primary' => !$isActive])>
				<span @class([
					'pointer-events-none bg-primary border-5 border-white absolute -top-4 left-0 rounded-full p-[6px] transition-all duration-300 ease-out motion-reduce:transition-none',
					'opacity-100 scale-100' => $isActive,
					'opacity-0 scale-75' => !$isActive,
				]) aria-hidden="true">
					<img src="http://huugy.local/wp-content/uploads/2026/09/hu.svg" alt="" class="w-3 h-3 object-contain" />
				</span>
				{{ $category->name }}
			</a>
			@endif
			@endforeach
		</div>
	</div>
</div>

@if (have_posts())
@php $loop_index = 0; @endphp
<div class="__posts c-main !mt-10 posts grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

	@while (have_posts())
	@php
	the_post();
	$featured = !is_paged() && $loop_index === 0;
	@endphp

	@include('partials.category-post', ['featured' => $featured])
	@php $loop_index++; @endphp
	@endwhile
</div>

{{-- {!! get_the_posts_navigation() !!} --}}
{!! the_posts_pagination() !!}
@else
<div class="mt-20 mb-20">
	<div class="c-main">
		<h3>Brak wpisów w tej kategorii.</h3>
		<a class="main-btn m-btn" href="/wszystkie-wpisy/">
			Sprawdź wszystkie wpisy
		</a>
	</div>
</div>
@endif

<!-- cta -->
@php
$g_octa = get_field('g_octa', 'option');
$form = true;
$sectionClass = '-smt';
$section_id = '';
$section_class = '';
$background = 'none';
@endphp
@include('blocks.cta')

@endsection