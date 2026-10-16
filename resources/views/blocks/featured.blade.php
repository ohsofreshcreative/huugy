<!--- featured -->

@if (!empty($block->preview))
@include('blocks.previews.preview-featured')
@else

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([
    'b-featured relative -smt',
    $sectionClass => filled($sectionClass),
    $section_class => filled($section_class),
    $background => filled($background) && $background !== 'none',
  ])>
  <div class="__wrapper c-main flex flex-col gap-12">
    <div class="__top flex flex-col gap-8 md:flex-row md:items-end md:justify-between">
      @if (!empty($g_featured['header']) || !empty($g_featured['text']))
        <div class="__content w-full md:w-2/3 flex flex-col">
          @if (!empty($g_featured['header']))
            <h2 data-gsap-element="header">{{ $g_featured['header'] }}</h2>
          @endif
          @if (!empty($g_featured['text']))
            <div class="__txt" data-gsap-element="txt">{!! $g_featured['text'] !!}</div>
          @endif
        </div>
      @endif
      @if (!empty($items))
        <div class="flex shrink-0 gap-4">
          <x-button tag="button" type="button" class="__prev w-12! h-12! inline-flex! [&.swiper-button-lock]:hidden! items-center justify-center p-0! disabled:opacity-40" aria-label="Poprzedni produkt">
            <x-icon.arrow-up class="rotate-90" />
          </x-button>
          <x-button tag="button" type="button" class="__next w-12! h-12! inline-flex! [&.swiper-button-lock]:hidden! items-center justify-center p-0! disabled:opacity-40" aria-label="Następny produkt">
            <x-icon.arrow-up class="-rotate-90" />
          </x-button>
        </div>
      @endif
    </div>

    @if (!empty($items))
      <div class="swiper w-full min-w-0">
        <div class="swiper-wrapper">
          @foreach ($items as $item)
            <div class="swiper-slide h-auto!">
              <a href="{{ esc_url($item['url']) }}" class="__card group flex flex-col h-full bg-white radius p-8">
                @if (!empty($g_featured['badge']))
                  <span class="absolute top-4 right-4 w-max border-1 border-dashed border-primary-dark bg-secondary rounded-full px-5 py-2">{{ $g_featured['badge'] }}</span>
                @endif
                <div class="__img flex items-center justify-center aspect-square">
                  @if (!empty($item['image']['ID']) || !empty($item['image']['url']))
                    <x-picture :image="$item['image']" class="w-full h-full object-contain" figureClass="w-full h-full" loading="lazy" />
                  @endif
                </div>
                <div class="__content flex flex-col items-start gap-4 mt-5">
                  @if (!empty($item['title']))
                    <p class="text-h6">{{ $item['title'] }}</p>
                  @endif
                  <span class="btn btn-underline group-hover:after:ml-3! group-focus-visible:after:ml-3!">Sprawdź</span>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
      <div class="__pagination swiper-pagination static!" aria-label="Paginacja produktów"></div>
    @endif

    @if (!empty($button['url']))
      <div class="__bottom flex justify-center">
        <x-button :href="esc_url($button['url'])" variant="primary" :target="$button['target'] ?? '_self'">
          {{ $button['title'] ?: 'Zobacz wszystkie produkty' }}
        </x-button>
      </div>
    @endif
  </div>
</section>

@endif
