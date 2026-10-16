<?php

/**
 * Theme filters.
 */

namespace App;

/*--- REJESTRACJA KLIENTA ---*/

function is_customer_registration_request(): bool
{
	return isset($_POST['huugy_registration'], $_POST['woocommerce-register-nonce'])
		&& $_POST['huugy_registration'] === '1'
		&& is_string($_POST['woocommerce-register-nonce'])
		&& wp_verify_nonce(wp_unslash($_POST['woocommerce-register-nonce']), 'woocommerce-register');
}

function customer_registration_value(string $key): string
{
	return isset($_POST[$key]) && is_string($_POST[$key])
		? sanitize_text_field(wp_unslash($_POST[$key])) : '';
}

// Własny formularz przyjmuje hasło klienta i generuje login z adresu e-mail.
add_filter('option_woocommerce_registration_generate_password', function ($value) {
	return is_customer_registration_request() ? 'no' : $value;
});
add_filter('option_woocommerce_registration_generate_username', function ($value) {
	return is_customer_registration_request() ? 'yes' : $value;
});

add_filter('woocommerce_process_registration_errors', function ($errors) {
	if (!is_customer_registration_request()) {
		return $errors;
	}

	if ('yes' !== get_option('woocommerce_enable_myaccount_registration')) {
		$errors->add('registration_disabled', 'Rejestracja kont jest obecnie niedostępna.');
	}
	$type = customer_registration_value('customer_type');
	if (!in_array($type, ['individual', 'designer'], true)) {
		$errors->add('customer_type', 'Wybierz typ klienta.');
	}
	if (customer_registration_value('full_name') === '') {
		$errors->add('full_name', 'Podaj imię i nazwisko.');
	}
	if (customer_registration_value('privacy_acceptance') !== '1') {
		$errors->add('privacy_acceptance', 'Zaakceptuj politykę prywatności.');
	}
	$password = isset($_POST['password']) && is_string($_POST['password']) ? wp_unslash($_POST['password']) : '';
	if (mb_strlen($password) < 8) {
		$errors->add('password_length', 'Hasło musi mieć co najmniej 8 znaków.');
	}
	if ($type === 'designer') {
		$nip = preg_replace('/[\s-]+/', '', customer_registration_value('billing_nip'));
		$valid = preg_match('/^[0-9]{10}$/D', $nip) === 1;
		if ($valid) {
			$sum = 0;
			foreach ([6, 5, 7, 2, 3, 4, 5, 6, 7] as $index => $weight) {
				$sum += (int) $nip[$index] * $weight;
			}
			$valid = $nip !== '0000000000' && $sum % 11 === (int) $nip[9];
		}
		if (!$valid) {
			$errors->add('billing_nip', 'Podaj poprawny, 10-cyfrowy numer NIP.');
		}
	}

	return $errors;
});

add_action('woocommerce_created_customer', function ($customerId) {
	if (!is_customer_registration_request()) {
		return;
	}

	$name = customer_registration_value('full_name');
	$parts = preg_split('/\s+/u', $name, 2);
	$customer = new \WC_Customer($customerId);
	$customer->set_first_name($parts[0] ?? '');
	$customer->set_last_name($parts[1] ?? '');
	$customer->set_display_name($name);
	$customer->set_billing_first_name($parts[0] ?? '');
	$customer->set_billing_last_name($parts[1] ?? '');
	$customer->update_meta_data('customer_type', customer_registration_value('customer_type'));
	if (customer_registration_value('customer_type') === 'designer') {
		$customer->update_meta_data('billing_nip', preg_replace('/[\s-]+/', '', customer_registration_value('billing_nip')));
	}
	$customer->update_meta_data('privacy_accepted_at', gmdate('c'));
	$customer->save();
});

/*--- NAZWA DOMYŚLNEJ KATEGORII PRODUKTÓW W PANELU ---*/
add_action('admin_footer', function () {
	if (get_current_screen()?->taxonomy !== 'product_cat' || !class_exists('WC_Admin_Taxonomies')) {
		return;
	}

	// WordPress używa teraz <th> dla nazwy, a WooCommerce czyści pierwszy <th> w wierszu.
	remove_action('admin_footer', [\WC_Admin_Taxonomies::get_instance(), 'scripts_at_product_cat_screen_footer']);

	wp_register_script('huugy-product-cat-admin', '', [], null, true);
	wp_enqueue_script('huugy-product-cat-admin');
	wp_add_inline_script('huugy-product-cat-admin', sprintf(
		"(function () {
			const row = document.getElementById('tag-%d');
			const cell = row?.querySelector('.check-column');
			const tooltip = row?.querySelector('td.thumb .woocommerce-help-tip');
			if (cell && tooltip) {
				cell.replaceChildren(tooltip);
			}
		})();",
		absint(get_option('default_product_cat', 0))
	));
}, 9);

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});


add_action('pre_get_posts', function ($q) {
  if (is_admin() || !$q->is_main_query()) {
    return;
  }
  if ($q->is_search()) {
    $allowed_post_types = ['produkty', 'post'];
    if (!empty($_GET['post_type']) && in_array($_GET['post_type'], $allowed_post_types, true)) {
      $q->set('post_type', $_GET['post_type']);
    }
  }
});


/*--- WYRÓŻNIONY WPIS NA POCZĄTKU KATEGORII ---*/
add_action('pre_get_posts', function ($query) {
	if (is_admin() || !$query->is_main_query() || !$query->is_category() || $query->is_feed()) {
		return;
	}

	$query->set('orderby', ['date' => 'DESC', 'ID' => 'DESC']);
	$query->set('ignore_sticky_posts', true);
	$sticky_posts = array_filter(array_map('absint', (array) get_option('sticky_posts', [])));

	if (!$sticky_posts) {
		return;
	}

	$featured = get_posts([
		'post_type' => 'post',
		'post_status' => 'publish',
		'cat' => (int) $query->get_queried_object_id(),
		'post__in' => $sticky_posts,
		'posts_per_page' => 1,
		'orderby' => ['date' => 'DESC', 'ID' => 'DESC'],
		'ignore_sticky_posts' => true,
		'fields' => 'ids',
	]);

	$query->set('category_featured_post', $featured[0] ?? 0);
});

add_filter('posts_orderby', function ($orderby, $query) {
	if (is_admin() || !$query->is_main_query() || !$query->is_category() || $query->is_feed()) {
		return $orderby;
	}

	$featured_id = (int) $query->get('category_featured_post');
	if (!$featured_id) {
		return $orderby;
	}

	global $wpdb;

	return $wpdb->prepare("CASE WHEN {$wpdb->posts}.ID = %d THEN 0 ELSE 1 END, ", $featured_id) . $orderby;
}, 10, 2);


/*--- LICZNIKI FILTRÓW ATRYBUTÓW ---*/
add_filter('woocommerce_layered_nav_count', function ($html, $count) {
	return '<span class="count">' . absint($count) . '</span>';
}, 10, 2);

/*--- SUWAK CENY PO DYNAMICZNEJ ZMIANIE FILTRÓW ---*/
add_action('wp_enqueue_scripts', function () {
	if (!function_exists('is_shop') || (!is_shop() && !is_product_taxonomy())) {
		return;
	}

	// Widget może początkowo nie mieć wyników, a pojawić się dopiero po usunięciu filtra.
	foreach (wp_get_sidebars_widgets()['sidebar-shop'] ?? [] as $widget) {
		if (str_starts_with($widget, 'woocommerce_price_filter-')) {
			wp_enqueue_script('wc-price-slider');
			break;
		}
	}
}, 20);

/*--- USUNIĘCIE BREADCRUMBS WOOCOMMERCE (wszędzie używamy Yoast #breadcrumbs) ---*/
add_action('init', function () {
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
});


/*--- USUNIĘCIE POLECANYCH PRODUKTÓW Z KOSZYKA ---*/
add_action('template_redirect', function () {
	remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10);
});


/*--- UKRYCIE PRZEDZIAŁU CEN NA STRONIE PRODUKTU WARIANTOWEGO / USUNIĘCIE PRODUCT_META / RELATED PRODUCTS ---*/
// Cena konkretnego wariantu i tak pokazuje się nad przyciskiem "Dodaj do koszyka" (single-product/add-to-cart/variation.php).
// SKU pokazuje się teraz nad nazwą produktu (single-product/title.php), więc product_meta (SKU/kategorie/tagi) nie jest potrzebne.
// Related products zastąpione sekcją FAQ produktu (content-single-product.blade.php).
// Hook 'woocommerce_before_single_product' nie jest wywoływany w tym motywie, dlatego sprawdzamy produkt na 'template_redirect'.
add_action('template_redirect', function () {
    if (!is_product()) {
        return;
    }

    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

    $product = wc_get_product(get_queried_object_id());

    if ($product instanceof \WC_Product && $product->is_type('variable')) {
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    }
});


/*--- DODATKOWE ZAKŁADKI PRODUKTU (ACF: product_tabs) ---*/
add_filter('woocommerce_product_tabs', function ($tabs) {
    global $product;

    if (!$product instanceof \WC_Product) {
        return $tabs;
    }

    // Opis wyświetlamy obok dokumentacji technicznej nad zakładkami.
    unset($tabs['description']);

    $rows = get_field('product_tabs', $product->get_id()) ?: [];
    $priority = 12;

    foreach ($rows as $index => $row) {
        if (empty($row['tab_title'])) {
            continue;
        }

        $tabs['product_tab_' . $index] = [
            'title' => $row['tab_title'],
            'priority' => $priority,
            'callback' => function () use ($row) {
                echo \Roots\view('partials.product-tab-' . $row['acf_fc_layout'], ['row' => $row])->render();
            },
        ];

        $priority++;
    }

    return $tabs;
});


/*--- USUNIĘCIE ELEMENTÓW Z ARCHIWUM SKLEPU / KATEGORII ---*/
add_action('wp', function () {
    if (!is_shop() && !is_product_category() && !is_product_tag()) {
        return;
    }

    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
});



/**
 * Override WooCommerce Coming Soon template
 */
add_filter('woocommerce_coming_soon_template', function ($template) {
    $custom_template = get_theme_file_path('resources/views/patterns/coming-soon.php');
    
    if (file_exists($custom_template)) {
        return $custom_template;
    }
    
    return $template;
});


/*--- CHANGE EDIT SECTION ---*/


add_filter('gettext', function ($translated, $text, $domain) {
    if (
        is_admin() &&
        $text === 'Open expanded editor'
    ) {
        return 'Edytuj sekcję';
    }

    return $translated;
}, 10, 3);


add_filter('acf/blocks/default_expanded_editor_button_text', function () {
    return 'Edytuj sekcję';
});


/*--- DYNAMICZNE FRAGMENTY DLA KOSZYKA (SLAJD DRAWER) ---*/

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    // 1. Renderujemy ikonę na pulpit z pliku Blade (jeśli chcemy, lub trzymamy prosty kod w filters)
    ob_start();
    ?>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative hover:opacity-80 transition-opacity cart-custom-location-desktop">
        <img src="<?php echo get_template_directory_uri(); ?>/resources/images/cart.svg" alt="Koszyk" />
        <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
            <span class="absolute -top-2 -right-2 bg-primary text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full cart-count">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        <?php endif; ?>
    </a>
    <?php
    $fragments['a.cart-custom-location-desktop'] = ob_get_clean();

    // 2. Renderujemy ikonę na komórkę
    ob_start();
    ?>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative p-2 text-white hover:opacity-80 transition-opacity cart-custom-location-mobile">
        <img src="<?php echo get_template_directory_uri(); ?>/resources/images/cart.svg" class="w-6 h-6" alt="Koszyk" />
        <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
            <span class="absolute top-1 right-1 bg-secondary text-primary text-[9px] font-bold w-4.5 h-4.5 flex items-center justify-center rounded-full cart-count">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        <?php endif; ?>
    </a>
    <?php
    $fragments['a.cart-custom-location-mobile'] = ob_get_clean();

    // 3. RENDER ZAWARTOSCI SZUFLADY PROSTO Z BLADE! (BEZ ODPALANIA HTML)
    $fragments['div.cart-drawer-ajax-content'] = '<div class="flex-1 flex flex-col overflow-hidden cart-drawer-ajax-content">' . \Roots\view('partials.cart-drawer-content')->render() . '</div>';

    // 4. Cyferka przy nagłówku Drawera
    $fragments['span.cart-count-badge'] = '<span class="bg-secondary/15 text-secondary text-xs px-2.5 py-0.5 rounded-full cart-count-badge">' . WC()->cart->get_cart_contents_count() . '</span>';

    return $fragments;
});


/*--- WYKRYWANIE DODANIA DO KOSZYKA (DLA EMBEDDED REFRESH / POST) ---*/

add_action('woocommerce_add_to_cart', function () {
    if (!defined('JUST_ADDED_TO_CART')) {
        define('JUST_ADDED_TO_CART', true);
    }
}, 10);


add_action('wp_enqueue_scripts', function () {
    if (function_exists('is_woocommerce')) {
        wp_enqueue_script('wc-cart-fragments');
    }
}, 99);


/*--- KONFIGURATOR PRODUKTU (ACF: product_configurator) ---*/

/**
 * Buduje warstwy konfiguratora produktu zmiennego z pola ACF "product_configurator".
 *
 * Klucze to nazwy pól wariantów ("attribute_pa_deska"), w kolejności warstw od spodu.
 * Wartość "current" to opcja domyślna produktu albo pierwsza dodana opcja.
 *
 * @param \WC_Product $product
 * @return array<string, array{current: string, options: array<string, array{src: string, srcset: string}>}>
 */
function product_configurator_layers($product)
{
    if (!$product instanceof \WC_Product || !$product->is_type('variable')) {
        return [];
    }

    $layers = [];

    foreach (get_field('product_configurator', $product->get_id()) ?: [] as $row) {
        $imageId = $row['image']['ID'] ?? 0;

        if (empty($row['configurator_option']) || !$imageId || !str_contains($row['configurator_option'], ':')) {
            continue;
        }

        [$taxonomy, $slug] = explode(':', $row['configurator_option'], 2);

        $layers[$taxonomy][$slug] = [
            'src' => wp_get_attachment_image_url($imageId, 'full'),
            'srcset' => wp_get_attachment_image_srcset($imageId, 'full') ?: '',
        ];
    }

    $defaults = $product->get_default_attributes();

    return collect($layers)
        ->mapWithKeys(fn ($options, $taxonomy) => ['attribute_' . sanitize_title($taxonomy) => [
            'current' => isset($options[$defaults[$taxonomy] ?? '']) ? $defaults[$taxonomy] : array_key_first($options),
            'options' => $options,
        ]])
        ->all();
}

// Opcje budowane z globalnych atrybutów WooCommerce, żeby nowe wartości były dostępne bez przebudowy cache ACF.
// Wartość "pa_deska:bursztynowy-dab" wskazuje atrybut (warstwę) i jego wartość.
add_filter('acf/load_field/name=configurator_option', function ($field) {
    if (!function_exists('wc_get_attribute_taxonomies')) {
        return $field;
    }

    $field['choices'] = [];

    foreach (wc_get_attribute_taxonomies() as $attribute) {
        $taxonomy = wc_attribute_taxonomy_name($attribute->attribute_name);
        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);

        if (is_wp_error($terms)) {
            continue;
        }

        foreach ($terms as $term) {
            $field['choices'][$attribute->attribute_label][$taxonomy . ':' . $term->slug] = $term->name;
        }
    }

    return $field;
});

// Konfigurator zastępuje galerię WooCommerce (content-single-product.blade.php).
add_action('template_redirect', function () {
    if (is_product() && product_configurator_layers(wc_get_product(get_queried_object_id()))) {
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
    }
});
