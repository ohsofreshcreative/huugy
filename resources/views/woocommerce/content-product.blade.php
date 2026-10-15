@php
global $product;

if (!$product instanceof \WC_Product || !$product->is_visible()) {
  return;
}

$image_id = $product->get_image_id();
$image = [
  'ID' => $image_id,
  'url' => $image_id ? wp_get_attachment_image_url($image_id, 'woocommerce_thumbnail') : wc_placeholder_img_src(),
  'alt' => $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '',
];

// Karta ma własny link i obraz; pomijamy standardowy przycisk koszyka i cenę.
$card_callbacks = [
  ['woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open'],
  ['woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail'],
  ['woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price'],
  ['woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close'],
  ['woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart'],
];
$removed_callbacks = [];
foreach ($card_callbacks as [$hook, $callback]) {
  $priority = has_action($hook, $callback);
  if ($priority !== false) {
    remove_action($hook, $callback, $priority);
    $removed_callbacks[] = [$hook, $callback, $priority];
  }
}
@endphp

<li class="h-full">
  @php do_action('woocommerce_before_shop_loop_item') @endphp

  <a href="{{ esc_url($product->get_permalink()) }}" aria-label="{{ 'Sprawdź: ' . $product->get_name() }}" class="__card group flex flex-col h-full bg-background-light hover:bg-background-light/50 focus-visible:bg-background-light/50 radius p-8">
    <x-picture :image="$image" figureClass="__thumb" class="w-full aspect-square object-contain" loading="lazy" />

    @php do_action('woocommerce_before_shop_loop_item_title') @endphp

    <div class="__content flex flex-col items-start pt-12">
      <h2 class="text-h7 line-clamp-2 min-h-14">{{ $product->get_name() }}</h2>
      @php do_action('woocommerce_after_shop_loop_item_title') @endphp
      <span class="btn btn-underline group-hover:after:ml-3! group-focus-visible:after:ml-3! motion-reduce:after:transition-none">
        Sprawdź
      </span>
    </div>
  </a>

  @php do_action('woocommerce_after_shop_loop_item') @endphp
</li>

@php
foreach ($removed_callbacks as [$hook, $callback, $priority]) {
  add_action($hook, $callback, $priority);
}
@endphp
