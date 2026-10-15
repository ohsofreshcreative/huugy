{{-- Warstwy w kolejności od spodu; obrazy mają ten sam kadr, więc kolejne leżą na pierwszym. --}}
<div class="product-configurator relative border-1 border-secondary-100 rounded-3xl overflow-hidden bg-white" data-product-configurator>
  @foreach ($layers as $attribute => $layer)
    @php($image = $layer['options'][$layer['current']])
    <img
      src="{{ $image['src'] }}"
      @if (!empty($image['srcset'])) srcset="{{ $image['srcset'] }}" sizes="(min-width: 1024px) 50vw, 100vw" @endif
      alt="{{ $loop->first ? $product->get_name() : '' }}"
      data-attribute="{{ $attribute }}"
      data-options="{{ wp_json_encode($layer['options']) }}"
      @class(['w-full h-auto', 'absolute inset-0' => !$loop->first])
    >
  @endforeach
</div>
