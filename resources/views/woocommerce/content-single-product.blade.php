@php
/**
* Szablon pojedynczego produktu nadpisany w Blade.
* Klasy Tailwinda dodane są bezpośrednio do sekcji galerii i opisu.
*/
defined('ABSPATH') || exit;

$current_product = wc_get_product(get_the_ID());
if (!$current_product instanceof \WC_Product) {
return;
}


// Pobranie wartości z opcji ACF
$g_values = get_field('g_values', 'option');
$r_values = get_field('r_values', 'option');

// FAQ produktu (nad sekcją powiązanych produktów, sama sekcja related jest usunięta)
$product_faq = get_field('product_faq') ?: [];

$product_description = $current_product->get_description();
$product_documentation = array_values(array_filter(
get_field('product_documentation', $current_product->get_id()) ?: [],
fn ($document) => !empty($document['title']) && !empty($document['file']['url'])
));
$configurator_layers = \App\product_configurator_layers($current_product);
$product_gallery = array_map(fn ($image_id) => [
'ID' => $image_id,
'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
], $current_product->get_gallery_image_ids());

// Akcje wywoływane przed strukturą produktu
if (post_password_required()) {
echo get_the_password_form(); // WPCS: XSS ok.
return;
}
@endphp

<div id="product-{{ the_ID() }}" {{ wc_product_class('', $current_product) }}>

	<div class="__product grid grid-cols-1 lg:grid-cols-2 gap-10">

		<div class="min-w-0">
			@if (!empty($configurator_layers))
			@include('partials.product-configurator', ['layers' => $configurator_layers, 'product' => $current_product])
			@endif

			@php
			/**
			* Hook: woocommerce_before_single_product_summary.
			*
			* @hooked woocommerce_show_product_sale_flash - 10
			* @hooked woocommerce_show_product_images - 20 (Galeria)
			*/
			do_action('woocommerce_before_single_product_summary');
			@endphp
		</div>

		{{-- KOLUMNA PRAWA: Tytuł, Cena, Opis, Przycisk koszyka --}}
		<div class="">

			@php
			/**
			* Hook: woocommerce_single_product_summary.
			*
			* @hooked woocommerce_template_single_title - 5
			* @hooked woocommerce_template_single_rating - 10
			* @hooked woocommerce_template_single_price - 10
			* @hooked woocommerce_template_single_excerpt - 20
			* @hooked woocommerce_template_single_add_to_cart - 30
			* @hooked woocommerce_template_single_meta - 40
			* @hooked woocommerce_template_single_sharing - 50
			* @hooked WC_Structured_Data::generate_product_data() - 60
			*/
			do_action('woocommerce_single_product_summary');
			@endphp
		</div>

	</div>

	@include('partials.product-details')

	<div class="w-full bg-white">
		@php
		/**
		* Hook: woocommerce_after_single_product_summary.
		*
		* @hooked woocommerce_output_product_data_tabs - 10
		* @hooked woocommerce_upsell_display - 15
		*/
		do_action('woocommerce_after_single_product_summary');
		@endphp
	</div>

	@if (!empty($product_faq))
	<section class="b-faq relative -smt">
		<div class="__wrapper c-main">
			<div class="__top text-center">
				<p>FAQ</p>
				<p class="text-h5">Najczęściej zadawane pytania</p>
			</div>
			<div class="tabs-wrapper flex flex-col mt-8">
				@foreach ($product_faq as $item)
				<div class="tabs bg-white border border-primary-light rounded-xl h-max">
					<input class="tab-check" type="checkbox" name="radio-product-faq" id="product-faq-check{{ $loop->index }}">
					<label class="tabs-label flex items-center justify-between" for="product-faq-check{{ $loop->index }}">
						<div class="flex items-center gap-4">
							<p class="!text-lg font-header">{{ $item['question'] }}</p>
						</div>

						<span class="__icon" aria-hidden="true">
							<span class="__plus text-primary">+</span>
							<span class="__minus text-primary">−</span>
						</span>
					</label>

					<div class="tabs-content">
						{!! $item['answer'] !!}
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif

</div>

@php do_action('woocommerce_after_single_product'); @endphp

<!-- cta -->
@php
$g_octa = get_field('g_octa', 'option');
$form = false;
$sectionClass = '-smt';
$section_id = '';
$section_class = 'bg-white left-1/2 w-screen -translate-x-1/2 section-py';
$background = 'none';
@endphp
@include('blocks.cta')
