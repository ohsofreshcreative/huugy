{{-- WooCommerce thankyou.php, version 8.1.0 --}}
@php defined('ABSPATH') || exit; @endphp

<div class="woocommerce-order order-confirmation">
	@if ($order)
	@php do_action('woocommerce_before_thankyou', $order->get_id()); @endphp

	@if ($order->has_status('failed'))
	<div class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
		<h1>Płatność nie powiodła się</h1>
		<p>Nie udało się zrealizować płatności za zamówienie. Spróbuj ponownie.</p>
		<div class="inline-buttons m-btn">
			<x-button :href="esc_url($order->get_checkout_payment_url())">Zapłać ponownie</x-button>
			@if (is_user_logged_in())
			<x-button :href="esc_url(wc_get_page_permalink('myaccount'))" variant="outline-primary">Moje konto</x-button>
			@endif
		</div>
	</div>
	@else
	<header class="text-center m-header">
		<h4 class="text-primary">{{ $order->has_status('cancelled') ? 'Zamówienie anulowane' : 'Dziękujemy za zamówienie!' }}</h4>
		<h4>Numer zamówienia: #{{ $order->get_order_number() }}</h4>
		@if (!$order->has_status('cancelled'))
		<p class="mt-3">Potwierdzenie oraz faktura zamówienia zostały wysłane na adres: {{ $order->get_billing_email() }}</p>
		@endif
	</header>
	@endif

	<div class="__payment-instructions">
		@php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); @endphp
	</div>
	<div class="__details grid grid-cols-1 lg:grid-cols-[1.8fr_1fr] gap-8 items-start">
		@php do_action('woocommerce_thankyou', $order->get_id()); @endphp
	</div>
	<div class="text-center m-btn">
		<x-button :href="esc_url(wc_get_page_permalink('shop'))">Kontynuuj zakupy</x-button>
	</div>
	@else
	@php wc_get_template('checkout/order-received.php', ['order' => false]); @endphp
	@endif
</div>