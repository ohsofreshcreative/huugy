@props(['endpoint', 'icons' => []])

@if (!empty($icons[$endpoint]))
  <img src="{{ esc_url($icons[$endpoint]) }}" class="w-6 h-6 shrink-0 object-contain" alt="" aria-hidden="true" />
@else
  <svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($endpoint)
      @case('dashboard')
        <path d="M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z" />
        @break
      @case('orders')
        <path d="M5 7h14l2 14H3L5 7Zm3 1V6a4 4 0 0 1 8 0v2" />
        @break
      @case('edit-address')
        <path d="M19 10c0 5-7 12-7 12S5 15 5 10a7 7 0 1 1 14 0Z" /><circle cx="12" cy="10" r="2.5" />
        @break
      @case('edit-account')
        <circle cx="12" cy="7" r="4" /><path d="M8 13a7 7 0 0 0-3 6v2h14v-2a7 7 0 0 0-3-6" />
        @break
      @case('customer-logout')
        <path d="M10 3H4v18h6M9 12h12m-4-4 4 4-4 4" />
        @break
      @case('downloads')
        <path d="M12 3v12m-4-4 4 4 4-4M3 15v6h18v-6" />
        @break
      @default
        <circle cx="12" cy="12" r="8" /><path d="m10 8 4 4-4 4" />
    @endswitch
  </svg>
@endif
