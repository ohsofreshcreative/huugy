@php
$categories = get_the_category();
$category = !empty($categories) ? $categories[0] : null;
@endphp

<section data-gsap-anim="section" class="hero-blog relative flex flex-col overflow-hidden bg-gradient -spt">

	<div class="__wrapper c-main relative z-10">
		<div class="__content w-full md:w-1/2 pb-20">
			@if (function_exists('yoast_breadcrumb'))
			<div data-gsap-element="bread" class="__breadcrumb text-primary [&_#breadcrumbs]:flex-wrap [&_a]:text-white">
				{!! yoast_breadcrumb('<p id="breadcrumbs" class="!pt-4 !mt-0">', '</p>', false) !!}
			</div>
			@endif

			<div class="__top mt-20">
				<h1 data-gsap-element="header" class="text-h2 text-white mt-6">{!! get_the_title() !!}</h1>
			</div>
		</div>
	</div>
</section>

@php
$content = apply_filters('the_content', get_the_content());

preg_match_all('/<h([1-5])[^>]*>(.*?)<\/h\1>/is', $content, $matches, PREG_SET_ORDER);

		$toc = '<nav class="toc">
			<ul>';
				$used_ids = [];
				foreach ($matches as $match) {
				$level = $match[1];
				$title = strip_tags($match[2]);
				$id = sanitize_title($title);
				$base_id = $id;
				$i = 2;
				while (in_array($id, $used_ids)) {
				$id = $base_id . '-' . $i;
				$i++;
				}
				$used_ids[] = $id;
				$content = preg_replace(
				'/<h' . $level . '[^>]*>' . preg_quote($match[2], '/' ) . '<\/h' . $level . '>/' , '<h' . $level . ' id="' . $id . '">' . $match[2] . '</h' . $level . '>' ,
					$content,
					1
					);
					$toc .='<li class="toc-h' . $level . '"><a href="#' . $id . '">' . $title . '</a></li>' ;
					}
					$toc .='</ul></nav>' ;
					@endphp

					<div data-gsap-anim="section" id="tresc" class="__content c-main -smt">

					<div class="__entry">
						@if(has_post_thumbnail())
						<figure data-gsap-element="img" class="">
							<picture class="w-full h-full">
								<img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'large') }}" alt="{{ get_the_title() }}" class="w-full h-full max-h-[400px] object-cover radius" />
							</picture>
						</figure>
						@endif

						<div class="w-full md:w-2/3 mx-auto mt-10">
							@if(has_excerpt())
							<div data-gsap-element="excerpt" class="mt-4">
								{!! get_the_excerpt() !!}
							</div>
							@endif
							<div data-gsap-element="toc" class="my-10">
								<p class="text-h5">Spis treści</p>
								@if(count($matches))
								{!! $toc !!}
								@endif
							</div>

							<div data-gsap-element="content">
								{!! $content !!}
							</div>
						</div>
					</div>

					</div>

					<!-- related-posts -->
					@include('partials.related-posts')


					<script>
						document.addEventListener('DOMContentLoaded', function() {
							const headings = document.querySelectorAll('h1[id], h2[id], h3[id], h4[id], h5[id]'); // Select all headings with IDs
							const tocLinks = document.querySelectorAll('.toc ul li a'); // Select all links in the TOC

							function updateActiveLink() {
								headings.forEach((heading) => {
									const headingTop = heading.getBoundingClientRect().top;
									const windowHeight = window.innerHeight;

									if (headingTop < windowHeight - 300) {
										// Remove the 'active' class from all TOC links
										tocLinks.forEach((link) => {
											link.parentNode.classList.remove('active');
										});

										// Add the 'active' class to the corresponding TOC link
										const id = heading.id;
										const activeLink = document.querySelector(`.toc ul li a[href="#${id}"]`);
										if (activeLink) {
											activeLink.parentNode.classList.add('active');
										}
									}
								});
							}
							updateActiveLink();

							window.addEventListener('scroll', updateActiveLink);
						});
					</script>