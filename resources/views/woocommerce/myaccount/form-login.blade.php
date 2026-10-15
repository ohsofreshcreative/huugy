{{-- WooCommerce form-login.php, version 9.9.0 --}}
@if ('yes' !== get_option('woocommerce_enable_myaccount_registration'))
  @php include WC()->plugin_path() . '/templates/myaccount/form-login.php'; @endphp
@else
  <header class="bg-primary-900 text-secondary -menu-pt">
    <div class="c-main py-12">
      <nav aria-label="Ścieżka nawigacji" class="flex items-center gap-2 pb-8">
        <a href="{{ esc_url(home_url('/')) }}" class="text-white">Homepage</a>
        <span aria-hidden="true">›</span>
        <span aria-current="page" class="text-primary">Rejestracja</span>
      </nav>
      <h1>Zarejestruj się</h1>
    </div>
  </header>

  <section class="bg-background-light py-12" aria-label="Rejestracja konta">
    <div class="c-main grid md:grid-cols-4">
      <div class="md:col-start-2 md:col-span-2">
        @php(do_action('woocommerce_before_customer_login_form'))

        <form method="post" action="{{ esc_url(wc_get_page_permalink('myaccount')) }}" class="account-registration flex flex-col gap-6" x-data="{ customerType: @js($registration_values['customer_type'] === 'designer' ? 'designer' : 'individual') }" @php(do_action('woocommerce_register_form_tag'))>
          @php(do_action('woocommerce_register_form_start'))
          <input type="hidden" name="huugy_registration" value="1" />
          <input type="hidden" name="redirect" value="{{ esc_url(wc_get_page_permalink('myaccount')) }}" />

          <fieldset class="flex flex-wrap gap-4">
            <legend class="sr-only">Typ klienta</legend>
            <label class="flex items-center gap-2">
              <input type="radio" name="customer_type" value="individual" x-model="customerType" @checked($registration_values['customer_type'] !== 'designer') required class="text-primary focus:ring-primary" />
              Jestem klientem indywidualnym
            </label>
            <label class="flex items-center gap-2">
              <input type="radio" name="customer_type" value="designer" x-model="customerType" @checked($registration_values['customer_type'] === 'designer') required class="text-primary focus:ring-primary" />
              Jestem projektantem
            </label>
          </fieldset>

          <div>
            <label for="reg_full_name" class="block">Imię i nazwisko</label>
            <input id="reg_full_name" name="full_name" type="text" autocomplete="name" value="{{ $registration_values['full_name'] }}" placeholder="Jan Kowalski" required class="block w-full border border-primary-200 bg-white p-4 radius-sm focus:border-primary-900! focus:shadow-none! focus:outline-none!" />
          </div>
          <div>
            <label for="reg_email" class="block">Twój adres e-mail</label>
            <input id="reg_email" name="email" type="email" autocomplete="email" value="{{ $registration_values['email'] }}" placeholder="nazwa@domena.pl" required class="block w-full border border-primary-200 bg-white p-4 radius-sm focus:border-primary-900! focus:shadow-none! focus:outline-none!" />
          </div>
          <div x-show="customerType === 'designer'">
            <label for="reg_nip" class="block">NIP</label>
            <input id="reg_nip" name="billing_nip" type="text" inputmode="numeric" value="{{ $registration_values['billing_nip'] }}" placeholder="Numer NIP" :required="customerType === 'designer'" :disabled="customerType !== 'designer'" class="block w-full border border-primary-200 bg-white p-4 radius-sm focus:border-primary-900! focus:shadow-none! focus:outline-none!" />
          </div>
          <div>
            <label for="reg_password" class="block">Hasło</label>
            <input id="reg_password" name="password" type="password" autocomplete="new-password" required minlength="8" aria-describedby="reg_password_hint" class="block w-full border border-primary-200 bg-white p-4 radius-sm focus:border-primary-900! focus:shadow-none! focus:outline-none!" />
            <p id="reg_password_hint">Minimum 8 znaków.</p>
          </div>

          @php(do_action('woocommerce_register_form'))
          <label class="flex items-center gap-2">
            <input name="privacy_acceptance" type="checkbox" value="1" required class="text-primary focus:ring-primary" />
            <span>Akceptuję @if ($privacy_url)<a href="{{ esc_url($privacy_url) }}" target="_blank" rel="noopener" class="underline">politykę prywatności</a>@else politykę prywatności @endif</span>
          </label>
          @php(wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'))
          <x-button type="submit" name="register" value="1" variant="primary" class="!w-full text-center">Zarejestruj się</x-button>
          @php(do_action('woocommerce_register_form_end'))
          <div class="border-t border-secondary-300 pt-4 text-center">
            <a href="{{ esc_url(wp_login_url(wc_get_page_permalink('myaccount'))) }}" data-login-open aria-haspopup="dialog" aria-controls="login-modal" class="text-secondary-800 underline">Masz już konto? Zaloguj się</a>
          </div>
        </form>

        @php(do_action('woocommerce_after_customer_login_form'))
      </div>
    </div>
  </section>
@endif
