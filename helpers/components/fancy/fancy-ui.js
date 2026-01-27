/* eslint-disable */
import { exist } from '../utils';
import { Carousel, Fancybox } from '@fancyapps/ui';
import { Thumbs } from '@fancyapps/ui/dist/carousel/carousel.thumbs.esm.js';

import '@fancyapps/ui/dist/fancybox/fancybox.css';
import '@fancyapps/ui/dist/carousel/carousel.css';
import '@fancyapps/ui/dist/carousel/carousel.thumbs.css';

export const sliderFancy = () => {
	const container = document.querySelector('#myCarousel');

	if (!exist(container)) return;

	const options = {
		infinite: false,
		// Navigation: false,
		Dots: false,
		Thumbs: {
			type: 'classic',
		},
	};

	const slider = new Carousel(container, options, { Thumbs });
};

export const popupFancy = () => {
	Fancybox.bind('[data-fancybox^="gallery-catalog"]', {});
	Fancybox.bind('[data-fancybox="gallery-place"]', {});

	const catalogMapLinks = document.querySelectorAll('.js-catalog-map');

	if (!exist(catalogMapLinks)) return;

	catalogMapLinks.forEach((link) => {
		link.addEventListener('click', (event) => {
			event.preventDefault();

			const mapSrc = link.getAttribute('data-src');

			if (mapSrc) {
				Fancybox.show([
					{
						src: mapSrc,
						type: 'iframe',
						opts: {
							iframe: {
								preload: false,
							},
						},
					},
				]);
			}
		});
	});
};
