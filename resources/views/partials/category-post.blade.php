@php
$image = get_post_thumbnail_id();
$categories = get_the_category();
$category = !empty($categories) ? $categories[0] : null;
@endphp

<article @class([ '__card group' , 'md:col-span-2 lg:col-span-3 bg-primary-800 text-white radius overflow-hidden'=> $featured,
	'border-b border-dotted border-primary pb-10' => !$featured,
	])>
	<a href="{{ get_permalink() }}" @class([ 'flex h-full' , 'flex-col md:flex-row'=> $featured,
		'flex-col gap-6' => !$featured,
		])>
		@if ($image)
		<x-picture
			:image="$image"
			:figureClass="$featured ? 'w-full md:w-1/2 shrink-0' : 'w-full'"
			:class="$featured ? 'w-full h-full aspect-[2/1] object-cover radius' : 'w-full aspect-[3/2] object-cover radius'"
			:loading="$featured ? 'eager' : 'lazy'" />
		@endif
		<div @class([ '__content flex flex-col flex-1 gap-6' , 'p-6 lg:p-10'=> $featured,
			])>
			<div class="flex flex-wrap items-center justify-between gap-3">
				@if (!empty($category->name))
				<span @class([ 'px-3 py-2 radius' , 'bg-primary-100 text-primary-800'=> $featured,
					'bg-primary-800 text-white' => !$featured,
					])>{{ $category->name }}</span>
				@endif
				<time datetime="{{ get_the_date('c') }}" @class(['flex items-center gap-2', 'text-white'=> $featured, 'text-primary-800' => !$featured])>
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" @class(['text-primary'=> !$featured, 'text-primary-100' => $featured]) aria-hidden="true">
						<rect x="3" y="5" width="18" height="16" rx="2" />
						<path d="M7 3v4M17 3v4M3 10h18" />
					</svg>
					{{ get_the_date('d.m.Y') }}
				</time>
			</div>
			<h2 @class([ 'text-h4 text-white'=> $featured,
				'text-h7 text-primary-800' => !$featured,
				])>{{ get_the_title() }}</h2>
			<div class="mt-auto">
				<span class="btn btn-primary group-hover:bg-primary-700! w-12! h-12! p-0! inline-flex! items-center justify-center" aria-hidden="true">
					<x-icon.arrow-up class="-rotate-135 group-hover:-rotate-90 transition-transform duration-300" />
				</span>
			</div>
		</div>
	</a>
</article>