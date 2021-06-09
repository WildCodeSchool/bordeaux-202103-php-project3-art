import Swiper from 'swiper/bundle';

import 'swiper/swiper-bundle.css';

const swiper = new Swiper('.swiper-container', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
});
