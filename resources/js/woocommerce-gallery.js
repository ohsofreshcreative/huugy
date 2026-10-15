const $ = window.jQuery;

if ($) {
  const observed = new WeakSet();
  let resizeFrame;

  const setupThumbnails = (gallery) => {
    const list = gallery.querySelector('.flex-control-thumbs');
    if (!list || list.closest('.gallery-thumbs-wrapper')) return;

    const wrapper = document.createElement('div');
    wrapper.className = 'gallery-thumbs-wrapper';
    list.before(wrapper);
    wrapper.append(list);
    list.setAttribute('aria-label', 'Miniatury zdjęć produktu');

    if (list.children.length <= 5) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const buttons = [-1, 1].map((direction) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = `${direction < 0 ? '__prev left-0' : '__next right-0'} absolute top-1/2 -translate-y-1/2 z-10 rounded-full bg-white text-black h-8 w-8 flex items-center justify-center pointer-events-auto cursor-pointer transition-all duration-400 shrink-0 disabled:opacity-35 disabled:pointer-events-none`;
      button.setAttribute('aria-label', direction < 0 ? 'Poprzednie miniatury' : 'Następne miniatury');
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.setAttribute('width', '13');
      svg.setAttribute('height', '12');
      svg.setAttribute('viewBox', '0 0 13 12');
      svg.setAttribute('fill', 'none');
      svg.setAttribute('aria-hidden', 'true');
      const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttribute('d', direction < 0
        ? 'M0.270429 5.31498C0.270706 5.31469 0.270937 5.31435 0.27126 5.31406L5.08882 0.281803C5.44973 -0.0951806 6.03348 -0.0937777 6.39273 0.285093C6.75194 0.663916 6.75055 1.27664 6.38964 1.65367L3.15514 5.03226L12.078 5.03226C12.5872 5.03226 13 5.46552 13 6C13 6.53448 12.5872 6.96774 12.078 6.96774L3.15518 6.96774L6.3896 10.3463C6.75051 10.7234 6.75189 11.3361 6.39269 11.7149C6.03344 12.0938 5.44963 12.0951 5.08877 11.7182L0.271213 6.68594C0.270936 6.68565 0.270706 6.68531 0.270383 6.68502C-0.0907122 6.30673 -0.08956 5.69202 0.270429 5.31498Z'
        : 'M12.7296 5.31498C12.7293 5.31469 12.7291 5.31435 12.7287 5.31406L7.91118 0.281803C7.55027 -0.0951806 6.96652 -0.0937777 6.60727 0.285093C6.24806 0.663916 6.24945 1.27664 6.61036 1.65367L9.84486 5.03226L0.921985 5.03226C0.412773 5.03226 0 5.46552 0 6C0 6.53448 0.412773 6.96774 0.921985 6.96774L9.84482 6.96774L6.6104 10.3463C6.24949 10.7234 6.24811 11.3361 6.60731 11.7149C6.96657 12.0938 7.55037 12.0951 7.91123 11.7182L12.7288 6.68594C12.7291 6.68565 12.7293 6.68531 12.7296 6.68502C13.0907 6.30673 13.0896 5.69202 12.7296 5.31498Z');
      path.setAttribute('fill', 'currentColor');
      svg.append(path);
      button.append(svg);
      button.addEventListener('click', () => list.scrollBy({
        left: direction * list.clientWidth,
        behavior: reducedMotion ? 'instant' : 'smooth',
      }));
      wrapper.append(button);
      return button;
    });

    const update = () => {
      buttons[0].disabled = list.scrollLeft <= 1;
      buttons[1].disabled = list.scrollLeft + list.clientWidth >= list.scrollWidth - 1;
    };
    list.addEventListener('scroll', update, { passive: true });
    new ResizeObserver(update).observe(list);
    list.addEventListener('focusin', (event) => {
      event.target.closest('li')?.scrollIntoView({ block: 'nearest', inline: 'nearest' });
    });
    update();
  };

  const observeGalleries = () => {
    document.querySelectorAll('.__product .woocommerce-product-gallery').forEach((gallery) => {
      setupThumbnails(gallery);
      if (observed.has(gallery)) return;
      observed.add(gallery);
      let previousWidth = 0;

      // FlexSlider musi przeliczyć slajdy także po zmianie CSS lub szerokości kolumny.
      const observer = new ResizeObserver(([entry]) => {
        const width = entry.contentRect.width;
        if (!width || Math.abs(width - previousWidth) < 1) return;
        previousWidth = width;
        cancelAnimationFrame(resizeFrame);
        resizeFrame = requestAnimationFrame(() => $(window).trigger('resize'));
      });
      observer.observe(gallery);
    });
  };

  observeGalleries();
  $(document).on('wc-product-gallery-after-init.huugyGallery', observeGalleries);
}
