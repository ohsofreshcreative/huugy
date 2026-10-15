<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Registration extends Composer
{
	protected static $views = ['woocommerce.myaccount.form-login'];

	public function with(): array
	{
		$values = [];
		foreach (['customer_type', 'full_name', 'email', 'billing_nip'] as $key) {
			$values[$key] = isset($_POST[$key]) && is_string($_POST[$key])
				? sanitize_text_field(wp_unslash($_POST[$key])) : '';
		}

		return [
			'registration_values' => $values,
			'privacy_url' => get_privacy_policy_url(),
		];
	}
}
