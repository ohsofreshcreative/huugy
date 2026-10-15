{{-- WooCommerce my-account.php, version 3.5.0 --}}
@php defined('ABSPATH') || exit; @endphp

<div class="account-panel grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-8 items-start">
  @php do_action('woocommerce_account_navigation'); @endphp
  <div class="woocommerce-MyAccount-content min-w-0">
    @php do_action('woocommerce_account_content'); @endphp
  </div>
</div>
