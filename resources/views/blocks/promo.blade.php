<!--- promo -->

@if (!empty($block->preview))
@include('blocks.previews.preview-promo')
@else

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([
    'b-promo relative -smt',
    $sectionClass => filled($sectionClass),
    $section_class => filled($section_class),
    $background => filled($background) && $background !== 'none',
  ])>
  <div class="__wrapper c-main flex flex-col gap-10">
    @if (!empty($g_promo['header']))
      <h2 data-gsap-element="header">{{ $g_promo['header'] }}</h2>
    @endif

    @if (!empty($r_promo))
      <div class="relative">
        <div class="swiper w-full min-w-0">
          <div class="swiper-wrapper">
            @foreach ($r_promo as $item)
              <div class="swiper-slide h-auto!">
                <div class="__card relative isolate overflow-hidden bg-primary text-white h-full flex items-center radius  px-10 py-16 lg:px-40 lg:py-40">
                  @if (!empty($item['image']))
                    <x-picture :image="$item['image']" figureClass="absolute inset-0 -z-20" class="absolute inset-0 w-full h-full object-cover" loading="lazy" />
                  @endif
                  <div class="absolute inset-0 -z-10 bg-linear-to-r from-primary-dark via-primary-dark/90 to-primary-dark/20" aria-hidden="true"></div>
                  <div class="__content w-full lg:w-1/2 flex flex-col items-start gap-6">
                    @if (!empty($item['header']))
                      <h3>{{ $item['header'] }}</h3>
                    @endif
                    @if (!empty($item['text']))
                      <div class="__txt">{!! $item['text'] !!}</div>
                    @endif
                    @if (!empty($item['button']['url']))
                      <x-button :href="esc_url($item['button']['url'])" variant="secondary" :target="$item['button']['target'] ?? '_self'">
                        {{ $item['button']['title'] }}
                      </x-button>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @if (count($r_promo) > 1)
          <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 z-10 flex justify-between pointer-events-none">
            <x-button tag="button" type="button" class="__prev -translate-x-1/2 w-12! h-12! p-0! inline-flex! items-center justify-center pointer-events-auto disabled:opacity-40" aria-label="Poprzednia promocja">
              <x-icon.arrow-up class="rotate-90" />
            </x-button>
            <x-button tag="button" type="button" class="__next translate-x-1/2 w-12! h-12! p-0! inline-flex! items-center justify-center pointer-events-auto disabled:opacity-40" aria-label="Następna promocja">
              <x-icon.arrow-up class="-rotate-90" />
            </x-button>
          </div>
        @endif
      </div>
    @endif
  </div>
</section>

@endif
