<footer @class([
	'footer bg-primary-900 relative z-10',
	'-smt' => !get_field('no_footer_margin'),
])>
	<div class="relative not-visited:flex flex-col pt-12">

		<div class="c-main relative grid grid-cols-1 lg:grid-cols-2 items-center gap-10 border-b border-dotted border-secondary pb-12">
			@if (!empty($logo_footer['url']))
			<a href="{{ home_url('/') }}" class="block w-64" aria-label="{{ get_bloginfo('name') }} — strona główna">
				<img src="{{ esc_url($logo_footer['url']) }}" alt="{{ $logo_footer['alt'] ?: get_bloginfo('name') }}" class="w-full h-auto" loading="lazy" />
			</a>
			@endif
			@if (!empty($footer_newsletter['shortcode']))
			<div class="__newsletter flex flex-col gap-3">
				@if (!empty($footer_newsletter['header']))
				<h2>{{ $footer_newsletter['header'] }}</h2>
				@endif
				{!! do_shortcode($footer_newsletter['shortcode']) !!}
			</div>
			@endif
		</div>
		<div class="c-main relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pt-10 pb-40">

			<img class="absolute left-1/2 -translate-x-1/2 bottom-0 mix-blend-overlay pointer-events-none" src="{{ get_template_directory_uri() }}/resources/images/glow.svg" />
			@for ($i = 1; $i <= 3; $i++)
				<div>
				@if (is_active_sidebar('sidebar-footer-' . $i))
				@php(dynamic_sidebar('sidebar-footer-' . $i))
				@endif
		</div>
		@endfor
		<div class="__contact relative flex flex-col gap-4 z-10">

			<div class="__contact-links">
				@if(!empty($footer_contact['phone']))
				<a href="tel:{{ str_replace(' ', '', $footer_contact['phone']) }}" class="__contact-link">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.79 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
					</svg>
					{{ $footer_contact['phone'] }}
				</a>
				@endif
				@if(!empty($footer_contact['email']))
				<a href="mailto:{{ $footer_contact['email'] }}" class="__contact-link">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
						<polyline points="22,6 12,13 2,6"></polyline>
					</svg>
					{{ $footer_contact['email'] }}
				</a>
				@endif
			</div>
			@if (!empty($footer_contact['social_links']))
			<div class="__social-links flex items-center gap-3">
				@foreach ($footer_contact['social_links'] as $social)
				@if (!empty($social['link']))
				<a href="{{ $social['link'] }}" target="_blank" rel="noopener" class="__social-link">
					@if (!empty($social['icon']['url']))
					<img src="{{ $social['icon']['url'] }}" alt="{{ $social['icon']['alt'] ?? '' }}" class="w-6 h-6 object-contain" />
					@endif
				</a>
				@endif
				@endforeach
			</div>
			@endif
			@if (!empty($footer_contact['hours']))
			<div class="__hours">
				{!! $footer_contact['hours'] !!}
			</div>
			@endif
			@if (!empty($footer_contact['address']))
			<div>{!! $footer_contact['address'] !!}</div>
			@endif
			@if (is_active_sidebar('sidebar-footer-4'))
			@php(dynamic_sidebar('sidebar-footer-4'))
			@endif
		</div>
	</div>
	<div class="border-t border-secondary">
		<div class="c-main flex flex-col md:flex-row items-center justify-between gap-6 py-8">
			<p>Copyright ©{{ wp_date('Y') }} {{ get_bloginfo('name') }}. All rights reserved.</p>
			<p class="flex flex-wrap items-center gap-4">Designed &amp; Developed by
				<a target="_blank" rel="nofollow noopener" href="https://www.ohsofresh.pl" title="OhSoFresh">
					<img class="w-28 h-auto" src="{{ get_template_directory_uri() }}/resources/images/ohsofresh.svg" alt="OhSoFresh" loading="lazy" />
				</a>
			</p>
		</div>
	</div>
</footer>