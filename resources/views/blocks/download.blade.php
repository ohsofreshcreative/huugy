<!--- download -->

@if (!empty($block->preview))
@include('blocks.previews.preview-download')
@else

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([
    'b-download relative -smt',
    $sectionClass => filled($sectionClass),
    $section_class => filled($section_class),
    $background => filled($background) && $background !== 'none',
  ])>
  <div class="__wrapper c-main">
    @if (!empty($r_download))
      <ul class="grid gap-4">
        @foreach ($r_download as $item)
          @if (!empty($item['title']) && !empty($item['file']['url']))
            <li data-gsap-element="card" class="__card flex flex-wrap items-center justify-between gap-4 bg-white rounded-full border border-secondary px-6 py-4 md:px-8">
              <span class="__title text-h7 min-w-0 break-words">{{ $item['title'] }}</span>
              <x-button
                :href="esc_url($item['file']['url'])"
                variant="underline"
                class="flex! items-center gap-4 shrink-0 after:hidden"
                :aria-label="'Pobierz: ' . $item['title']"
                download>
                Pobierz
                <span class="flex items-center justify-center w-12 h-12 bg-primary radius" aria-hidden="true">
                  <img src="{{ get_template_directory_uri() }}/resources/images/download.svg" class="w-5 h-5 brightness-0 invert" alt="" />
                </span>
              </x-button>
            </li>
          @endif
        @endforeach
      </ul>
    @endif
  </div>
</section>

@endif
