{{-- WooCommerce navigation.php, version 9.3.0 --}}
@php
  defined('ABSPATH') || exit;
  do_action('woocommerce_before_account_navigation');
@endphp

<nav class="woocommerce-MyAccount-navigation bg-white radius p-6 lg:p-8" aria-label="Podstrony konta">
  <ul class="flex flex-col gap-4">
    @foreach ($account_menu as $endpoint => $label)
      <li @class([wc_get_account_menu_item_classes($endpoint), 'lg:mt-20' => $endpoint === 'customer-logout'])>
        <a href="{{ esc_url(wc_get_account_endpoint_url($endpoint)) }}"
          @if (wc_is_current_account_menu_item($endpoint)) aria-current="page" @endif
          @class([
            'flex items-center gap-3 px-6 py-4 radius',
            'bg-primary-800 !text-white' => wc_is_current_account_menu_item($endpoint),
            'text-primary hover:bg-secondary' => !wc_is_current_account_menu_item($endpoint),
            'border border-primary-100 bg-secondary-50' => $endpoint === 'customer-logout',
          ])>
          <x-account-icon :endpoint="$endpoint" :icons="$account_icons" />
          <span>{{ $label }}</span>
        </a>
      </li>
    @endforeach
  </ul>
</nav>

@php do_action('woocommerce_after_account_navigation'); @endphp
