{{-- WooCommerce order-details-customer.php, version 8.7.0 --}}
@php defined('ABSPATH') || exit; @endphp

@if (!is_order_received_page())
  @php
    // Poza podziękowaniem zachowujemy standardowe dane i hooki WooCommerce.
    include WC()->plugin_path() . '/templates/order/order-details-customer.php';
  @endphp
@else
  <section class="woocommerce-customer-details grid gap-6">
    <div class="bg-white border border-primary-100 radius p-6 lg:p-8">
      <h5>Dane {{ $recipient_type === 'shipping' ? 'dostawy i odbiorcy' : 'odbiorcy' }}</h5>
      <dl class="__data">
        @if (!empty($recipient_name))
          <div><dt>Odbiorca</dt><dd>{{ $recipient_name }}</dd></div>
        @endif
        @if (!empty($recipient_address))
          <div><dt>Adres</dt><dd>{{ $recipient_address }}</dd></div>
        @endif
        @if (!empty($recipient_phone))
          <div><dt>Telefon</dt><dd>{{ $recipient_phone }}</dd></div>
        @endif
        @if ($order->get_billing_email())
          <div><dt>Adres e-mail</dt><dd>{{ $order->get_billing_email() }}</dd></div>
        @endif
      </dl>
      @php do_action('woocommerce_order_details_after_customer_address', $recipient_type, $order); @endphp
      @if ($recipient_type === 'shipping')
        <details class="m-btn">
          <summary>Dane rozliczeniowe</summary>
          <address>{!! wp_kses_post($order->get_formatted_billing_address()) !!}</address>
          @php do_action('woocommerce_order_details_after_customer_address', 'billing', $order); @endphp
        </details>
      @endif
    </div>

    <div class="bg-white border border-primary-100 radius p-6 lg:p-8">
      <h5>Informacje o płatności i dostawie</h5>
      <dl class="__data">
        @if ($order->get_payment_method_title())
          <div><dt>Metoda płatności</dt><dd>{{ $order->get_payment_method_title() }}</dd></div>
        @endif
        @if ($order->get_shipping_method())
          <div><dt>Metoda dostawy</dt><dd>{{ $order->get_shipping_method() }}</dd></div>
        @endif
        @if (!empty($delivery_time) && !$order->has_status(['failed', 'cancelled', 'refunded']))
          <div><dt>Przewidywana dostawa</dt><dd class="text-primary">{{ $delivery_time }}</dd></div>
        @endif
        <div>
          <dt>Status płatności</dt>
          <dd>
            <span @class([
              'bg-secondary radius-sm px-3 py-1' => $order->is_paid(),
              'bg-yellow-100 text-yellow-900 radius-sm px-3 py-1' => !$order->is_paid() && $order->needs_payment() && !$order->has_status('failed'),
            ])>{{ $payment_status }}</span>
          </dd>
        </div>
      </dl>
    </div>
    @php do_action('woocommerce_order_details_after_customer_details', $order); @endphp
  </section>
@endif
