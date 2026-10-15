<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Header extends Composer
{
	protected static $views = ['sections.header'];

	public function with(): array
	{
		if (!has_nav_menu('primary_navigation') || !function_exists('wc_get_page_id') || !taxonomy_exists('product_cat')) {
			return ['product_menu' => []];
		}

		$terms = get_terms([
			'taxonomy' => 'product_cat',
			'hide_empty' => true,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		]);
		$byParent = [];
		$defaultCategory = (int) get_option('default_product_cat', 0);

		foreach (is_wp_error($terms) ? [] : $terms as $term) {
			if ((int) $term->term_id === $defaultCategory) {
				continue;
			}
			$url = get_term_link($term);
			if (!is_wp_error($url)) {
				$byParent[(int) $term->parent][] = [
					'id' => (int) $term->term_id,
					'title' => $term->name,
					'url' => $url,
				];
			}
		}

		return ['product_menu' => [
			'shop_id' => (int) wc_get_page_id('shop'),
			'shop_url' => wc_get_page_permalink('shop'),
			'categories' => $this->categoryTree($byParent),
			'promo' => get_field('megamenu_promo', 'option') ?: [],
		]];
	}

	protected function categoryTree(array $byParent, int $parent = 0): array
	{
		$items = $byParent[$parent] ?? [];
		foreach ($items as &$item) {
			$item['children'] = $this->categoryTree($byParent, $item['id']);
		}
		return $items;
	}
}
