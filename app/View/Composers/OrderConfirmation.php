<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class OrderConfirmation extends Composer
{
	protected static $views = ['woocommerce.order.order-details-customer'];

	public function with(): array
	{
		$order = $this->data->get('order');
		if (!$order instanceof \WC_Order) {
			return [];
		}

		$shipping = $order->needs_shipping_address() && $order->get_shipping_address_1();
		$type = $shipping ? 'shipping' : 'billing';
		$address = $order->get_address($type);
		$name = trim(($address['first_name'] ?? '') . ' ' . ($address['last_name'] ?? ''));
		unset($address['first_name'], $address['last_name']);
		$settings = get_field('thankyou_settings', 'option') ?: [];

		return [
			'recipient_name' => $name,
			'recipient_address' => WC()->countries->get_formatted_address($address, ', '),
			'recipient_phone' => ($shipping ? $order->get_shipping_phone() : '') ?: $order->get_billing_phone(),
			'recipient_type' => $type,
			'delivery_time' => $order->needs_shipping_address() ? ($settings['delivery_time'] ?? '') : '',
			'payment_status' => $order->is_paid() ? 'Opłacone' : ($order->needs_payment() && !$order->has_status('failed') ? 'Oczekuje na płatność' : wc_get_order_status_name($order->get_status())),
		];
	}
}
