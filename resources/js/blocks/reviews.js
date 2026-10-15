import Swiper from 'swiper';
import { A11y, Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const initReviewsSwiper = (scope = document) => {
  const sections = scope.matches?.('.b-reviews')
    ? [scope]
    : scope.querySelectorAll('.b-reviews');

  sections.forEach((section) => {
    const slider = section.querySelector('.reviews-swiper');
    if (!slider || slider.swiper) return;

    new Swiper(slider, {
      modules: [A11y, Navigation, Pagination],
      slidesPerView: 1,
      spaceBetween: 32,
      watchOverflow: true,
      speed: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 400,
      navigation: {
        prevEl: section.querySelector('.__prev'),
        nextEl: section.querySelector('.__next'),
      },
      pagination: {
        el: section.querySelector('.__pagination'),
        clickable: true,
      },
      a11y: {
        prevSlideMessage: 'Poprzednia opinia',
        nextSlideMessage: 'Następna opinia',
        paginationBulletMessage: 'Przejdź do opinii {{index}}',
        slideLabelMessage: '{{index}} z {{slidesLength}}',
      },
    });
  });
};

initReviewsSwiper();

if (window.acf) {
  window.acf.addAction('render_block', (el) => {
    const node = el?.[0] ?? el;
    if (node) initReviewsSwiper(node);
  });
}

export default initReviewsSwiper;
