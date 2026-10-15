@php
  $menu_id = ($mobile ? 'mobile-products-' : 'desktop-products-') . $menu_item->ID;
  $categories = $product_menu['categories'];
  $promo = $product_menu['promo'];
  $has_promo = !empty($promo['image']) || !empty($promo['header']) || !empty($promo['text']) || !empty($promo['button']['url']);
@endphp

@if ($mobile)
  <li x-data="{ open: false }">
    <button
      type="button"
      @click="open = !open"
      :aria-expanded="open"
      aria-controls="{{ $menu_id }}"
      class="product-menu-toggle flex w-full items-center justify-between gap-4 py-1 text-left">
      <span>{{ $menu_item->title }}</span>
      <svg class="w-6 h-6 shrink-0 text-primary" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
      </svg>
    </button>
    <div id="{{ $menu_id }}" x-show="open" x-cloak class="product-menu-panel bg-white radius-sm px-4">
      <a href="{{ esc_url($product_menu['shop_url']) }}" class="block py-3">Wszystkie kategorie</a>
      <ul>
        @foreach ($categories as $category)
          <li>
            @if (!empty($category['children']))
              <div x-data="{ open: false }">
                <button
                  type="button"
                  @click="open = !open"
                  :aria-expanded="open"
                  aria-controls="{{ $menu_id }}-{{ $category['id'] }}"
                  class="product-menu-toggle flex w-full items-center justify-between gap-4 py-1 text-left">
                  <span>{{ $category['title'] }}</span>
                  <svg class="w-6 h-6 shrink-0 text-primary" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                  </svg>
                </button>
                <div id="{{ $menu_id }}-{{ $category['id'] }}" x-show="open" x-cloak class="pl-4">
                  <a href="{{ esc_url($category['url']) }}" class="block py-3">Zobacz wszystkie: {{ $category['title'] }}</a>
                  @include('partials.product-menu-children', ['items' => $category['children']])
                </div>
              </div>
            @else
              <a href="{{ esc_url($category['url']) }}" class="block py-3">{{ $category['title'] }}</a>
            @endif
          </li>
        @endforeach
      </ul>
    </div>
  </li>
@else
  <li
    @class(array_merge(['product-menu flex h-full items-center'], (array) ($menu_item->classes ?? [])))
    x-data="{ open: false, active: {{ $categories[0]['id'] }} }"
    :data-open="open"
    @mouseenter="if (window.matchMedia('(hover: hover)').matches) open = true"
    @mouseleave="if (!$el.contains(document.activeElement)) open = false"
    @focusout="if (!$el.contains($event.relatedTarget)) open = false"
    @click.outside="open = false"
    @keydown.escape.window="if (open) { open = false; if ($el.contains(document.activeElement)) $refs.toggle.focus() }">
    <a class="text-sm font-medium hover:text-indigo-600" href="{{ esc_url($menu_item->url) }}" @if (!empty($menu_item->current)) aria-current="page" @endif>{{ $menu_item->title }}</a>
    <button
      type="button"
      x-ref="toggle"
      @click="open = !open"
      @keydown.arrow-down.prevent="open = true; $nextTick(() => $refs.panel.querySelector('a').focus())"
      :aria-expanded="open"
      aria-controls="{{ $menu_id }}"
      aria-label="Rozwiń kategorie produktów"
      class="pl-1 py-3">
      <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
      </svg>
    </button>

    <div id="{{ $menu_id }}" x-ref="panel" x-show="open" x-cloak class="absolute inset-x-0 top-full pt-4">
      <div @class([
        '__inside grid bg-white radius p-8 xl:p-12 gap-8 xl:gap-12 pt-4 overflow-y-auto max-h-[calc(100dvh-var(--menu-height)-3rem)]',
        'grid-cols-3' => $has_promo,
        'grid-cols-2' => !$has_promo,
      ])>
        <div class="__categories min-w-0 border-r border-gray-200 pr-8 xl:pr-12">
          <h6 class="text-primary-800">Kategorie produktów</h6>
          <ul>
            <li><a href="{{ esc_url($product_menu['shop_url']) }}" class="flex items-center justify-between px-4 py-3">Wszystkie kategorie <span aria-hidden="true">›</span></a></li>
            @foreach ($categories as $category)
              <li @mouseenter="active = {{ $category['id'] }}" :class="active === {{ $category['id'] }} ? 'bg-background-light text-primary' : 'text-primary-dark'" class="flex items-center radius-sm">
                <a href="{{ esc_url($category['url']) }}" @focus="active = {{ $category['id'] }}" class="flex-1 min-w-0 px-4 py-3">{{ $category['title'] }}</a>
                <button
                  type="button"
                  @click="active = {{ $category['id'] }}; $nextTick(() => document.getElementById('{{ $menu_id }}-{{ $category['id'] }}').querySelector('a').focus())"
                  :aria-expanded="active === {{ $category['id'] }}"
                  aria-controls="{{ $menu_id }}-{{ $category['id'] }}"
                  aria-label="Pokaż podkategorie: {{ $category['title'] }}"
                  class="p-3">
                  <span aria-hidden="true">›</span>
                </button>
              </li>
            @endforeach
          </ul>
        </div>
        <div class="__subcategories min-w-0">
          @foreach ($categories as $category)
            <div id="{{ $menu_id }}-{{ $category['id'] }}" x-show="active === {{ $category['id'] }}">
              <h6 class="text-primary-800">{{ $category['title'] }}</h6>
              <a href="{{ esc_url($category['url']) }}" class="block py-3">Zobacz wszystkie: {{ $category['title'] }}</a>
              @if (!empty($category['children']))
                @include('partials.product-menu-children', ['items' => $category['children']])
              @endif
            </div>
          @endforeach
        </div>
        @if ($has_promo)
          <div class="__promo min-w-0 border-l border-gray-200 pl-8 xl:pl-12 flex items-center">
            @include('partials.product-menu-promo')
          </div>
        @endif
      </div>
    </div>
  </li>
@endif
