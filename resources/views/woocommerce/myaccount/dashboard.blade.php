{{-- WooCommerce dashboard.php, version 4.4.0 --}}
@php
  defined('ABSPATH') || exit;
  $cards = [
    'orders' => ['title' => 'Zamówienia', 'text' => 'Sprawdź historię zakupów oraz status realizacji.'],
    'edit-address' => ['title' => 'Adresy', 'text' => 'Dodaj lub edytuj zapisane adresy.'],
    'edit-account' => ['title' => 'Szczegóły konta', 'text' => 'Zmień dane kontaktowe oraz hasło.'],
  ];
@endphp

<h4>Witaj w Panelu Klienta!</h4>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 m-btn">
  @foreach ($cards as $endpoint => $card)
    @if (isset($account_menu[$endpoint]))
      <a href="{{ esc_url(wc_get_account_endpoint_url($endpoint)) }}" @class([
        '__card flex items-center gap-6 bg-white radius p-6 lg:p-8',
        'md:col-span-2' => $endpoint === 'orders',
      ])>
        <span class="flex items-center justify-center bg-secondary text-primary-800 radius-sm p-3">
          <x-account-icon :endpoint="$endpoint" :icons="$account_icons" />
        </span>
        <div class="flex-1 min-w-0">
          <h5 class="text-primary-800">{{ $card['title'] }}</h5>
          <p>{{ $card['text'] }}</p>
        </div>
        <span aria-hidden="true">›</span>
      </a>
    @endif
  @endforeach
</div>

@php
  do_action('woocommerce_account_dashboard');
  do_action('woocommerce_before_my_account');
  do_action('woocommerce_after_my_account');
@endphp

            
          