<!doctype html>
<html @php(language_attributes())>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@php(do_action('get_header'))
	@php(wp_head())

	{{-- Fonts --}}
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&family=Varela+Round&display=swap" rel="stylesheet">

	{{-- Styles --}}
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
		integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
		integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body @php(body_class())>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5TV295L"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	@php(wp_body_open())

	<div id="app">

		@include('sections.header')

		@if (function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag()))

		@yield('content')

    @elseif (function_exists('is_account_page') && is_account_page() && !is_user_logged_in() && !is_wc_endpoint_url() && 'yes' === get_option('woocommerce_enable_myaccount_registration'))

    <main id="main" class="main">
      @yield('content')
    </main>

		@elseif (function_exists('is_woocommerce') && (is_product() || is_cart() || is_checkout() || is_account_page()))

		<main id="main" class="c-main -menu-mt py-10">
			@yield('content')
		</main>

		@elseif (is_home() || is_singular('post') || is_category() || is_tag())

		<main id="main" class="main">
			@yield('content')
		</main>

		@else

		<main id="main" class="main -menu-mt">
			@yield('content')
		</main>

		@endif

		@include('sections.footer')
	</div>

    {{-- Załączenie wysuwanego koszyka (Drawer) --}}
    @if (function_exists('WC'))
        @include('partials.cart-drawer')
    @endif

  @if (function_exists('WC') && !is_user_logged_in())
    @include('partials.login-modal')
  @endif

	@php(do_action('get_footer'))
	@php(wp_footer())

</body>

</html>