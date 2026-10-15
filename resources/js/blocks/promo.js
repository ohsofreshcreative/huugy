import Swiper from 'swiper';
import { A11y, Navigation } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';

document.querySelectorAll('.b-promo').forEach((section) => {
  const slider = section.querySelector('.swiper');
  if (!slider || slider.swiper) return;

  new Swiper(slider, {
    modules: [A11y, Navigation],
	loop: true,
    slidesPerView: 1,
    spaceBetween: 24,
    watchOverflow: true,
    speed: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 400,
    navigation: {
      prevEl: section.querySelector('.__prev'),
      nextEl: section.querySelector('.__next'),
    },
    a11y: {
      prevSlideMessage: 'Poprzednia promocja',
      nextSlideMessage: 'Następna promocja',
      slideLabelMessage: '{{index}} z {{slidesLength}}',
    },
  });
});
