const $ = window.jQuery;

export function initializePriceFilters(root = document) {
  if ($) {
    root.querySelectorAll('.__shop-sidebar .widget_price_filter').forEach((widget) => {
      const amount = widget.querySelector('.price_slider_amount');
      const slider = widget.querySelector('.price_slider');
      const minInput = widget.querySelector('[name="min_price"]');
      const maxInput = widget.querySelector('[name="max_price"]');

      if (!amount || !slider || !minInput || !maxInput || amount.querySelector('.price-inputs')) return;

      const inputs = document.createElement('div');
      inputs.className = 'price-inputs';
      const separator = document.createElement('span');
      separator.textContent = '–';
      separator.setAttribute('aria-hidden', 'true');

      [minInput, maxInput].forEach((input, index) => {
        input.inputMode = 'decimal';
        input.placeholder = index === 0 ? 'Cena od' : 'Cena do';
        const label = widget.querySelector(`label[for="${input.id}"]`);
        if (label) label.textContent = input.placeholder;

        input.addEventListener('change', () => {
          if (!$(slider).hasClass('ui-slider')) return;

          const values = $(slider).slider('values');
          const lower = index === 0 ? $(slider).slider('option', 'min') : values[0];
          const upper = index === 0 ? values[1] : $(slider).slider('option', 'max');
          const raw = input.value.trim().replace(',', '.');
          const value = raw === '' ? (index === 0 ? lower : upper) : Number(raw);

          if (Number.isFinite(value)) {
            $(slider).slider('values', index, Math.min(upper, Math.max(lower, value)));
          }

          const [min, max] = $(slider).slider('values');
          minInput.value = min;
          maxInput.value = max;
          $(document.body).trigger('price_slider_slide', [min, max]);
        });
      });

      inputs.append(minInput, separator, maxInput);
      amount.prepend(inputs);
      inputs.after(slider);
      widget.classList.add('price-filter-ready');
    });
  }
}

if ($) $(() => initializePriceFilters());
