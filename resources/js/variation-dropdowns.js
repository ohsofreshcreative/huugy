const $ = window.jQuery;

if ($) {
  const initialize = () => {
    document.querySelectorAll('.variations_form .variations select').forEach((select) => {
      if (select.closest('.variation-dropdown')) return;
      let list = select.parentElement.querySelector('.variable-items-wrapper');
      if (list?.querySelector('.radio-variable-item')) return;
      const native = !list;
      if (native) {
        list = document.createElement('div');
        list.className = 'variation-dropdown__options';
        select.hidden = true;
      }

      const dropdown = document.createElement('details');
      dropdown.className = 'variation-dropdown';
      const summary = document.createElement('summary');
      summary.className = 'variation-dropdown__selection';
      const label = select.closest('tr')?.querySelector('label')?.textContent.trim() || '';
      const preview = document.createElement('span');
      preview.className = 'variation-dropdown__preview';
      preview.setAttribute('aria-hidden', 'true');
      const title = document.createElement('span');
      summary.append(preview, title);
      select.before(dropdown);
      dropdown.append(summary, select, list);

      list.querySelectorAll('.variable-item').forEach((item) => {
        if (!item.querySelector('.variable-item-span-button')) {
          const text = document.createElement('span');
          text.className = 'variation-dropdown__label';
          text.textContent = item.dataset.title || item.title || item.dataset.value;
          item.querySelector('.variable-item-contents')?.append(text);
        }
      });

      const update = () => {
        if (native) {
          list.replaceChildren();
          Array.from(select.options).filter((option) => option.value).forEach((option) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'variable-item button-variable-item';
            button.dataset.value = option.value;
            button.disabled = option.disabled || select.disabled;
            button.classList.toggle('selected', option.selected);
            button.setAttribute('aria-pressed', String(option.selected));
            const content = document.createElement('span');
            content.className = 'variable-item-contents';
            const text = document.createElement('span');
            text.className = 'variable-item-span-button';
            text.textContent = option.textContent;
            content.append(text);
            button.append(content);
            button.addEventListener('click', () => {
              $(select).val(option.value).trigger('change');
              dropdown.open = false;
              summary.focus();
            });
            list.append(button);
          });
        }
        const selected = Array.from(list.querySelectorAll('.variable-item')).find(
          (item) => item.dataset.value === select.value,
        );
        title.textContent = select.selectedOptions[0]?.textContent || 'Wybierz opcję';
        summary.setAttribute('aria-label', `${label}: ${title.textContent}`);
        preview.replaceChildren();
        const swatch = selected?.querySelector('img, .variable-item-span-color');
        if (swatch) {
          const clone = swatch.cloneNode(true);
          clone.removeAttribute('id');
          preview.append(clone);
        }
        preview.hidden = !swatch;
      };

      $(select).on('change.huugyDropdown', update);
      $(select.closest('form')).on(
        'woocommerce_update_variation_values.huugyDropdown reset_data.huugyDropdown',
        () => queueMicrotask(update),
      );
      dropdown.addEventListener('click', (event) => {
        const item = event.target.closest('.variable-item');
        if (!item || item.classList.contains('disabled') || item.getAttribute('aria-disabled') === 'true') return;
        setTimeout(() => {
          update();
          dropdown.open = false;
          summary.focus();
        }, 0);
      }, true);
      dropdown.addEventListener('keydown', (event) => {
        if (native && ['ArrowDown', 'ArrowUp', 'Home', 'End'].includes(event.key)) {
          event.preventDefault();
          dropdown.open = true;
          const options = Array.from(list.querySelectorAll('button:not(:disabled)'));
          const current = options.indexOf(document.activeElement);
          let next = event.key === 'ArrowUp' ? current - 1 : current + 1;
          if (event.key === 'Home') next = 0;
          if (event.key === 'End' || next < 0) next = options.length - 1;
          options[Math.min(next, options.length - 1)]?.focus();
        }
        if (event.key === 'Escape') {
          dropdown.open = false;
          summary.focus();
        }
      });
      dropdown.addEventListener('toggle', () => {
        if (!dropdown.open) return;
        document.querySelectorAll('.variation-dropdown[open]').forEach((other) => {
          if (other !== dropdown) other.open = false;
        });
      });
      update();
    });
  };

  initialize();
  $(document).on('woo_variation_swatches_loaded.huugyDropdown', initialize);
  document.addEventListener('click', (event) => {
    document.querySelectorAll('.variation-dropdown[open]').forEach((dropdown) => {
      if (!dropdown.contains(event.target)) dropdown.open = false;
    });
  });
}
