const $ = window.jQuery;
const configurator = document.querySelector('[data-product-configurator]');
const form = document.querySelector('.variations_form');

if ($ && configurator && form) {
  const layers = Array.from(configurator.querySelectorAll('img[data-attribute]')).map((img) => ({
    img,
    attribute: img.dataset.attribute,
    options: JSON.parse(img.dataset.options || '{}'),
    requested: null,
  }));

  const update = () => {
    layers.forEach((layer) => {
      const image = layer.options[form.querySelector(`[name="${layer.attribute}"]`)?.value];
      if (!image || layer.requested === image.src) return;
      layer.requested = image.src;

      // Podmiana dopiero po pobraniu obrazu, żeby warstwa nie znikała na czas ładowania.
      const next = new Image();
      next.sizes = layer.img.sizes;
      next.srcset = image.srcset;
      next.src = image.src;
      next.decode().catch(() => {}).then(() => {
        if (layer.requested !== image.src) return;
        layer.img.srcset = image.srcset;
        layer.img.src = image.src;
      });
    });
  };

  // Selecty zmieniają się przez jQuery (WooCommerce, swatche), więc nasłuchujemy też przez jQuery.
  $(form).on('change.huugyConfigurator', 'select', update);
  update();
}
