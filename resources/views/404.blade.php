@extends('layouts.app')

@section('content')
@include('partials.page-header')

<section data-gsap-anim="section" class="contact bg-secondary relative py-50">
	<div class="c-main relative z-10">
		<div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10">
			<img data-gsap-element="img" src="{{ get_template_directory_uri() }}/resources/images/404.png" />
			<div>
				<h2 data-gsap-element="title" class=""> Ta strona nie istnieje.</h2>
				<p data-gsap-element="txt"> Być może adres został zmieniony lub strona została przeniesiona. Wróć na stronę główną lub przejdź do naszych produktów.</p>
				<div class="inline-buttons mt-6">
					<x-button :href="'/'" variant="primary" class="" data-gsap-element="btn">
						Wróć na stronę główną
					</x-button>
					<x-button :href="'/sklep'" variant="white" class="group inline-flex! items-center text-secondary-dark! gap-4 whitespace-normal! pl-6! p-3!" data-gsap-element="btn">
						Przejdź do naszych produktów
						<span class="flex shrink-0 items-center justify-center w-12 h-12 rounded-full bg-primary text-white" aria-hidden="true">
							<x-icon.arrow-up class="-rotate-135 group-hover:-rotate-90 transition-transform duration-300 motion-reduce:transition-none" />
						</span>
					</x-button>
				</div>
			</div>
		</div>
	</div>


</section>
@endsection