<div @class(['__card relative grid w-full overflow-hidden radius-img', 'aspect-square' => !empty($promo['image'])])>
  @if (!empty($promo['image']))
    <x-picture :image="$promo['image']" figureClass="absolute inset-0" class="absolute inset-0 w-full h-full object-cover" loading="lazy" />
  @endif
  @if (!empty($promo['header']) || !empty($promo['text']) || !empty($promo['button']['url']))
    <div @class([
      '__content z-10 self-end flex items-center gap-4 bg-white radius p-4',
      'm-4' => !empty($promo['image']),
    ])>
      <div class="min-w-0 flex-1">
        @if (!empty($promo['header']))
          <h6>{{ $promo['header'] }}</h6>
        @endif
        @if (!empty($promo['text']))
          <div class="__txt text-base">{!! $promo['text'] !!}</div>
        @endif
      </div>
      @if (!empty($promo['button']['url']))
        <x-button
          :href="esc_url($promo['button']['url'])"
          :target="$promo['button']['target'] ?? '_self'"
          :rel="($promo['button']['target'] ?? '') === '_blank' ? 'noopener noreferrer' : null"
          :aria-label="($promo['button']['title'] ?? '') ?: (($promo['header'] ?? '') ?: 'Zobacz promocję')"
          class="flex! items-center justify-center w-12! h-12! p-0! shrink-0 after:absolute after:inset-0 after:content-['']">
          <x-icon.arrow-up class="-rotate-90" aria-hidden="true" />
        </x-button>
      @endif
    </div>
  @endif
</div>
