<ul>
  @foreach ($items as $child)
    <li>
      <a href="{{ esc_url($child['url']) }}" class="block py-3 hover:text-primary">{{ $child['title'] }}</a>
      @if (!empty($child['children']))
        <div class="pl-4">
          @include('partials.product-menu-children', ['items' => $child['children']])
        </div>
      @endif
    </li>
  @endforeach
</ul>
