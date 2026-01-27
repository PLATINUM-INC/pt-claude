import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

const modelGallery = () => {
	const el = document.querySelector('[data-model-gallery="1"]');
	if (!el) return;

	const slides = el.querySelectorAll(".swiper-slide");
	if (slides.length <= 1) return;

	// eslint-disable-next-line no-new
	new Swiper(el, {
		modules: [Navigation, Pagination],
		loop: true,
		speed: 450,
		grabCursor: true,

		navigation: {
			nextEl: el.querySelector(".swiper-button-next"),
			prevEl: el.querySelector(".swiper-button-prev"),
		},

		pagination: {
			el: el.querySelector(".swiper-pagination"),
			clickable: true,
		},

		observer: true,
		observeParents: true,
	});
};

export default modelGallery;
