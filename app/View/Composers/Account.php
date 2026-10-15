<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Account extends Composer
{
	protected static $views = [
		'woocommerce.myaccount.navigation',
		'woocommerce.myaccount.dashboard',
	];

	public function with(): array
	{
		$icons = [];
		foreach (get_field('account_icons', 'option') ?: [] as $item) {
			if (!empty($item['endpoint']) && !empty($item['image']['url'])) {
				$icons[$item['endpoint']] = $item['image']['url'];
			}
		}

		return ['account_icons' => $icons, 'account_menu' => wc_get_account_menu_items()];
	}
}
