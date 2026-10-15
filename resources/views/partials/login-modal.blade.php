<dialog id="login-modal" aria-labelledby="login-modal-title" class="m-auto w-[920px] max-w-[calc(100%-2rem)] max-h-[calc(100dvh-2rem)] overflow-y-auto border-0 p-0 radius bg-white text-primary-dark backdrop:bg-black/60">
  <div class="relative grid md:grid-cols-2">
    <button type="button" data-login-close aria-label="{{ ($login_modal['close_label'] ?? '') ?: 'Zamknij panel logowania' }}" class="absolute right-2 top-2 z-10 flex h-11 w-11 items-center justify-center text-primary-dark md:text-white">
      <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
        <path d="m6 6 12 12M6 18 18 6" />
      </svg>
    </button>

    <div class="flex flex-col p-6 md:p-12">
      <h2 id="login-modal-title">{{ ($login_modal['header'] ?? '') ?: 'Zaloguj się' }}</h2>
      <form method="post" action="{{ esc_url(wc_get_page_permalink('myaccount')) }}" class="flex flex-1 flex-col pt-8">
        @php(do_action('woocommerce_login_form_start'))

        <div class="pb-6">
          <label for="modal-username" class="block text-secondary-800">{{ ($login_modal['email_label'] ?? '') ?: 'Twój adres e-mail' }}</label>
          <input type="email" id="modal-username" name="username" autocomplete="username" placeholder="{{ ($login_modal['email_placeholder'] ?? '') ?: 'nazwa@domena.pl' }}" required class="block w-full border-0 border-b border-primary-300 bg-transparent px-0 py-3 focus:border-primary-900! focus:shadow-none! focus:outline-none!" />
        </div>
        <div class="pb-8">
          <label for="modal-password" class="block text-secondary-800">{{ ($login_modal['password_label'] ?? '') ?: 'Hasło' }}</label>
          <input type="password" id="modal-password" name="password" autocomplete="current-password" required class="block w-full border-0 border-b border-primary-300 bg-transparent px-0 py-3 focus:border-secondary-800! focus:shadow-none! focus:outline-none!" />
        </div>

        @php(do_action('woocommerce_login_form'))
        @php(wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'))
        <input type="hidden" name="redirect" value="{{ esc_url(wc_get_page_permalink('myaccount')) }}" />
        <x-button type="submit" name="login" value="1" variant="primary" class="!w-full text-center">{{ ($login_modal['login_label'] ?? '') ?: 'Zaloguj się' }}</x-button>

        <div class="mt-auto pt-12 md:pt-32">
          <a href="{{ esc_url(wp_lostpassword_url()) }}" class="block border-t border-secondary-300 pt-4 text-center text-secondary-800 underline">{{ ($login_modal['lost_password_label'] ?? '') ?: 'Zapomniałeś hasła?' }}</a>
        </div>
        @php(do_action('woocommerce_login_form_end'))
      </form>
    </div>

    <div class="flex flex-col justify-center bg-primary-900 p-6 text-white md:p-12">
      <h3>{{ ($login_modal['register_header'] ?? '') ?: 'Nie masz konta?' }}</h3>
      <div class="text-primary-200">{!! $login_modal['text'] ?? 'Zarejestruj się i uzyskaj dostęp do:' !!}</div>
      <ul class="[&_span]:text-white flex list-none flex-col gap-5 py-8">
        <li class="flex items-center gap-3">
          <svg class="h-8 w-8 shrink-0" viewBox="0 0 32 32" aria-hidden="true">
            <circle cx="16" cy="16" r="16" fill="white" />
            <path d="m10 12 6-3 6 3v8l-6 3-6-3Zm0 0 6 4 6-4m-6 4v7" fill="none" stroke="currentColor" stroke-width="1.8" class="text-primary-900" />
          </svg>
          <div class="text-white">{!! $login_modal['models_text'] ?? 'modeli 3D naszych produktów' !!}</div>
        </li>
        <li class="flex items-center gap-3">
          <svg class="h-8 w-8 shrink-0" viewBox="0 0 32 32" aria-hidden="true">
            <circle cx="16" cy="16" r="16" fill="white" />
            <path d="M11 9h7l4 4v10H11Zm7 0v5h4" fill="none" stroke="currentColor" stroke-width="1.8" class="text-primary-900" />
          </svg>
          <div class="text-white">{!! $login_modal['documentation_text'] ?? 'specyfikacji technicznej naszych produktów' !!}</div>
        </li>
        <li class="flex items-center gap-3">
          <svg class="h-8 w-8 shrink-0" viewBox="0 0 32 32" aria-hidden="true">
            <circle cx="16" cy="16" r="16" fill="white" />
            <path d="m16 8 2.5 5 5.5.8-4 3.9.9 5.5-4.9-2.6-4.9 2.6.9-5.5-4-3.9 5.5-.8Z" fill="none" stroke="currentColor" stroke-width="1.8" class="text-primary-900" />
          </svg>
          <div class="text-white">{!! $login_modal['news_text'] ?? 'informacji o nowościach i zrealizowanych projektach' !!}</div>
        </li>
      </ul>
      <div class="pt-6">
        @if ('yes' === get_option('woocommerce_enable_myaccount_registration'))
          <x-button :href="wc_get_page_permalink('myaccount') . '#reg_email'" variant="outline-secondary" class="!w-full text-center">{{ ($login_modal['register_label'] ?? '') ?: 'Zarejestruj się' }}</x-button>
        @else
          <div>{!! $login_modal['registration_unavailable_text'] ?? 'Rejestracja kont jest obecnie niedostępna.' !!}</div>
        @endif
      </div>
    </div>
  </div>
</dialog>
