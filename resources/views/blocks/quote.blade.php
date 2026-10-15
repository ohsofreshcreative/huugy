<!--- quote -->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([
    'b-quote relative -smt -spt -spb',
    $sectionClass => filled($sectionClass),
    $section_class => filled($section_class),
    $background => filled($background) && $background !== 'none',
  ])>
  <div class="__wrapper c-main">
    @if (!empty($g_quote['header']) || !empty($g_quote['text']))
      <figure class="__content grid text-primary-800 w-full md:w-2/3 mx-auto">
        <blockquote class="grid">
          <img data-gsap-element="icon" src="{{ get_template_directory_uri() }}/resources/images/quote-icon.svg" />

          @if (!empty($g_quote['header']))
            <div data-gsap-element="header" class="__header text-h5">{!! $g_quote['header'] !!}</div>
          @endif

          @if (!empty($g_quote['text']))
            <div data-gsap-element="txt" class="__txt mt-2">
              {!! $g_quote['text'] !!}
            </div>
          @endif
        </blockquote>

        @if (!empty($g_quote['author']) || !empty($g_quote['image']))
          <figcaption data-gsap-element="figcaption" class="flex flex-wrap items-center justify-center gap-3 text-center mt-4">
            @if (!empty($g_quote['author']))
              <span>~ {{ $g_quote['author'] }}</span>
            @endif

            @if (!empty($g_quote['image']))
              <x-picture :image="$g_quote['image']" figureClass="__img shrink-0" class="w-6 h-6 object-contain" loading="lazy" />
            @endif
          </figcaption>
        @endif
      </figure>
    @endif
  </div>
</section>
