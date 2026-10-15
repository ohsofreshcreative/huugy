import Swiper from 'swiper';
import { A11y, Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

document.querySelectorAll('.b-featured').forEach((section) => {
  const slider = section.querySelector('.swiper');
  if (!slider || slider.swiper) return;

  new Swiper(slider, {
    modules: [A11y, Navigation, Pagination],
    slidesPerView: 1,
    spaceBetween: 24,
    watchOverflow: true,
    navigation: {
      prevEl: section.querySelector('.__prev'),
      nextEl: section.querySelector('.__next'),
    },
    pagination: {
      el: section.querySelector('.__pagination'),
      clickable: true,
    },
    a11y: {
      prevSlideMessage: 'Poprzedni produkt',
      nextSlideMessage: 'Następny produkt',
      paginationBulletMessage: 'Przejdź do slajdu {{index}}',
      slideLabelMessage: '{{index}} z {{slidesLength}}',
    },
    breakpoints: {
      640: { slidesPerView: 2 },
      1024: { slidesPerView: 4, spaceBetween: 32 },
    },
  });
});
