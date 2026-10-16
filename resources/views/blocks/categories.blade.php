<!--- categories -->

@if (!empty($block->preview))
@include('blocks.previews.preview-categories')
@else

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([
    'b-categories relative -smt',
    $sectionClass => filled($sectionClass),
    $section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
  ])>
  <div class="__wrapper c-main flex flex-col gap-12">
    @if (!empty($g_categories['subtitle']) || !empty($g_categories['header']))
      <div class="__top flex flex-col gap-4" data-gsap-element="header">
        @if (!empty($g_categories['subtitle']))
          <p>{{ $g_categories['subtitle'] }}</p>
        @endif
        @if (!empty($g_categories['header']))
          <h2>{{ $g_categories['header'] }}</h2>
        @endif
      </div>
    @endif

    @if (!empty($items))
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($items as $item)
          <a
            href="{{ esc_url($item['url']) }}"
            aria-label="{{ 'Sprawdź: ' . $item['title'] }}"
            @class([
              '__card group flex flex-col gap-8 bg-background-light hover:bg-background-light/50 radius p-8',
              'lg:col-span-2' => $loop->first,
            ])
            data-gsap-element="card">
            @if (!empty($item['image']['ID']) || !empty($item['image']['url']))
              <x-picture
                :image="$item['image']"
                :figureClass="$loop->first ? '__img w-full lg:w-1/2' : '__img w-full'"
                class="w-full img-xs object-contain"
                loading="lazy" />
            @endif

            <div class="__content flex flex-col items-start gap-4 mt-auto">
              @if (!empty($item['title']))
                <p class="text-h6">{{ $item['title'] }}</p>
              @endif
              @if (!empty($item['url']))
                <span class="btn btn-underline group-hover:after:ml-3! group-focus-visible:after:ml-3!">
                  Sprawdź
                </span>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    @endif
  </div>
</section>

@endif
