{{--
The Template for displaying product archives, including the main shop page which is a post type archive

This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')
@php
$term = get_queried_object();
$is_shop_main = !($term instanceof WP_Term);
// Na głównej stronie sklepu (bez terminu kategorii) używamy ustawień z opcji "Ustawienia sklepu"
$g_oshop = $is_shop_main ? get_field('g_oshop', 'option') : null;

$hero_image = ($term instanceof WP_Term) ? get_field('hero_image', $term) : ($g_oshop['hero_image'] ?? null);
$hero_header_custom = ($term instanceof WP_Term) ? get_field('hero_header', $term) : ($g_oshop['hero_header'] ?? null);
$display_header = !empty($hero_header_custom) ? $hero_header_custom : woocommerce_page_title(false);
do_action('get_header', 'shop');
do_action('woocommerce_before_main_content');

// Pobranie wartości z opcji ACF
$g_values = get_field('g_values', 'option');
$r_values = get_field('r_values', 'option');

// Pobranie opisu kategorii / archiwum / sklepu
$description = ($term instanceof WP_Term) ? term_description($term->term_id, $term->taxonomy) : ($g_oshop['description'] ?? '');

// Kafelki kategorii na głównej stronie sklepu.
$category_items = $is_shop_main ? \App\Blocks\Categories::items() : [];
@endphp

<header class="b-herosub relative bg-secondary-light overflow-hidden">

	<div class="__wrapper c-main relative z-20 grid grid-cols-1 md:grid-cols-2 items-center pt-30">
		<div class="pt-20 pb-10">
			@if(function_exists('yoast_breadcrumb'))
			<div class="__breadcrumb [&_a]:!text-body [&_span]:!text-primary  mb-4">
				{!! yoast_breadcrumb('<p id="breadcrumbs">','</p>') !!}
			</div>
			@endif

			<h1 class=""> {!! strip_tags($display_header, '<strong><em><a><br>') !!}</h1>

			@if (!empty($description))
			<div id="category-desc-content" class="mt-4">
				{!! $description !!}
			</div>
			@endif
		</div>

		@if (!empty($hero_image))
		<x-picture
			:image="$hero_image"
			figureClass="__img"
			class="w-full h-auto object-contain" />
		@endif
	</div>

</header>

<div class=" bg-white flex flex-col lg:flex-row gap-10 -spt pb-16">

	<div class="c-main">
		@if (!empty($category_items))
		<div class="__categories grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 py-16">
			@foreach ($category_items as $item)
			@php
			$compact = $loop->count >= 3 && $loop->count % 2 === 1 && $loop->remaining < 2;
				@endphp
				<a href="{{ esc_url($item['url']) }}" aria-label="{{ 'Sprawdź: ' . $item['title'] }}" @class([ '__card group flex flex-col bg-background-light hover:bg-background-light/50 focus-visible:bg-background-light/50 transition-colors duration-200 motion-reduce:transition-none radius p-8' , 'lg:col-span-2'=> !$compact,
				])>
				@if (!empty($item['image']['ID']) || !empty($item['image']['url']))
				<x-picture
					:image="$item['image']"
					:figureClass="$compact ? '__img w-full' : '__img w-full lg:w-1/2'"
					class="w-full img-xs object-contain"
					loading="lazy" />
				@endif
				<div class="__content flex flex-col items-start pt-12">
					<h2 class="text-h6">{{ $item['title'] }}</h2>
					<span class="btn btn-underline group-hover:after:ml-3! group-focus-visible:after:ml-3! motion-reduce:after:transition-none">
						Sprawdź
					</span>
				</div>
				</a>
				@endforeach
		</div>
		@endif

		@if (!$is_shop_main)
		<div data-shop-catalog class="flex flex-col lg:flex-row gap-10">
      <p data-shop-status class="sr-only" role="status"></p>
			@if (is_active_sidebar('sidebar-shop'))
			<aside class="__shop-sidebar w-full lg:w-1/4 shrink-0">
				@php dynamic_sidebar('sidebar-shop') @endphp
			</aside>
			@endif

			<div class="__products min-w-0 flex-1">
				@if (woocommerce_product_loop())
				@php
				do_action('woocommerce_before_shop_loop');
				woocommerce_product_loop_start();
				@endphp

				@if (wc_get_loop_prop('total'))
				@while (have_posts())
				@php
				the_post();
				do_action('woocommerce_shop_loop');
				wc_get_template_part('content', 'product');
				@endphp
				@endwhile
				@endif

				@php
				woocommerce_product_loop_end();
				do_action('woocommerce_after_shop_loop');
				@endphp
				@else
				@php do_action('woocommerce_no_products_found') @endphp
				@endif
			</div>
		</div>
		@endif
	</div>

</div>


<!-- cta -->
@php
$g_octa = get_field('g_octa', 'option');
$form = false;
$sectionClass = '-smt';
$section_id = '';
$section_class = '';
$background = 'none';
@endphp
@include('blocks.cta')
@endsection
