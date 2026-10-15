import Swiper from 'swiper';
import { A11y, Navigation } from 'swiper/modules';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.querySelectorAll('.product-gallery').forEach((slider) => {
  if (slider.swiper) return;

  const multiple = slider.querySelectorAll('.swiper-slide').length > 1;

  new Swiper(slider, {
    modules: [A11y, Navigation],
    slidesPerView: multiple ? 1.15 : 1,
    spaceBetween: 24,
    speed: reducedMotion ? 0 : 300,
    watchOverflow: true,
    grabCursor: true,
    breakpoints: multiple ? {
      640: { slidesPerView: 1.5 },
      1024: { slidesPerView: 2.2, spaceBetween: 32 },
    } : {},
    navigation: {
      prevEl: slider.querySelector('.__prev'),
      nextEl: slider.querySelector('.__next'),
    },
    a11y: {
      prevSlideMessage: 'Poprzednie zdjęcie',
      nextSlideMessage: 'Następne zdjęcie',
      firstSlideMessage: 'Pierwsze zdjęcie',
      lastSlideMessage: 'Ostatnie zdjęcie',
      slideLabelMessage: 'Zdjęcie {{index}} z {{slidesLength}}',
    },
  });
});
