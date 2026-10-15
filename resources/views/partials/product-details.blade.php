@if (!empty($product_description) || !empty($product_documentation) || !empty($product_gallery))
<section class="product-details relative left-1/2 w-screen -translate-x-1/2 overflow-hidden -smt -spt -spb bg-background-light" data-gsap-anim="section">
	<div class="__wrapper c-main">
		@if (!empty($product_description) || !empty($product_documentation))
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 items-start">
			@if (!empty($product_description))
			<div class="__content bg-white radius p-8" data-gsap-element="txt">
				<h5 class="text-primary">Opis produktu</h5>
				<div class="__txt mt-3">
					{!! apply_filters('the_content', $product_description) !!}
				</div>
			</div>
			@endif

			@if (!empty($product_documentation))
			<div class="__documents bg-white radius p-8" data-gsap-element="txt">
				<h5 class="text-primary">Dokumentacja techniczna</h5>
				<ul class="flex flex-col gap-4 mt-3">
					@foreach ($product_documentation as $document)
					<li class="flex flex-wrap items-center justify-between border-b border-primary-light pb-3">
						<span>{{ $document['title'] }}</span>
						<x-button
							:href="esc_url($document['file']['url'])"
							variant="underline"
							class="!flex gap-2 shrink-0 after:hidden"
							:aria-label="'Pobierz: ' . $document['title']"
							download>
							Pobierz
							<img src="{{ get_template_directory_uri() }}/resources/images/download.svg" class="w-4 h-4" alt="" aria-hidden="true" />
						</x-button>
					</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
		@endif

		@if (!empty($product_gallery))
		<div class="product-gallery swiper relative overflow-visible! -smt" aria-label="Galeria produktu">
			<div class="swiper-wrapper">
				@foreach ($product_gallery as $image)
				<div class="swiper-slide">
					<x-picture :image="$image" figureClass="__img" class="w-full aspect-5/4 object-cover radius-img" loading="lazy" />
				</div>
				@endforeach
			</div>

			@if (count($product_gallery) > 1)
			<div class="absolute inset-x-0 top-1/2 -translate-y-1/2 z-10 flex justify-between px-4 pointer-events-none">
				<button type="button" aria-label="Poprzednie zdjęcie" class="__prev rounded-full bg-white text-black h-14 w-14 flex items-center justify-center pointer-events-auto cursor-pointer transition-all duration-400 shrink-0 disabled:opacity-35 disabled:pointer-events-none">
					<svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none" aria-hidden="true">
						<path d="M0.270429 5.31498C0.270706 5.31469 0.270937 5.31435 0.27126 5.31406L5.08882 0.281803C5.44973 -0.0951806 6.03348 -0.0937777 6.39273 0.285093C6.75194 0.663916 6.75055 1.27664 6.38964 1.65367L3.15514 5.03226L12.078 5.03226C12.5872 5.03226 13 5.46552 13 6C13 6.53448 12.5872 6.96774 12.078 6.96774L3.15518 6.96774L6.3896 10.3463C6.75051 10.7234 6.75189 11.3361 6.39269 11.7149C6.03344 12.0938 5.44963 12.0951 5.08877 11.7182L0.271213 6.68594C0.270936 6.68565 0.270706 6.68531 0.270383 6.68502C-0.0907122 6.30673 -0.08956 5.69202 0.270429 5.31498Z" fill="currentColor" />
					</svg>
				</button>
				<button type="button" aria-label="Następne zdjęcie" class="__next rounded-full bg-white text-black h-14 w-14 flex items-center justify-center pointer-events-auto cursor-pointer transition-all duration-400 shrink-0 disabled:opacity-35 disabled:pointer-events-none">
					<svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none" aria-hidden="true">
						<path d="M12.7296 5.31498C12.7293 5.31469 12.7291 5.31435 12.7287 5.31406L7.91118 0.281803C7.55027 -0.0951806 6.96652 -0.0937777 6.60727 0.285093C6.24806 0.663916 6.24945 1.27664 6.61036 1.65367L9.84486 5.03226L0.921985 5.03226C0.412773 5.03226 0 5.46552 0 6C0 6.53448 0.412773 6.96774 0.921985 6.96774L9.84482 6.96774L6.6104 10.3463C6.24949 10.7234 6.24811 11.3361 6.60731 11.7149C6.96657 12.0938 7.55037 12.0951 7.91123 11.7182L12.7288 6.68594C12.7291 6.68565 12.7293 6.68531 12.7296 6.68502C13.0907 6.30673 13.0896 5.69202 12.7296 5.31498Z" fill="currentColor" />
					</svg>
				</button>
			</div>
			@endif
		</div>
		@endif
	</div>
</section>
@endif