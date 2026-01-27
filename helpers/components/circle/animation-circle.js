/* eslint-disable */
import { gsap } from '../vendors/gsap';
import { ScrollTrigger } from 'gsap/dist/ScrollTrigger';

const animationCircle = (wrapper) => {
	gsap.registerPlugin(ScrollTrigger);

	const SELECTORS = {
		wrapper: wrapper,
		item: '.js-circle-item',
	};

	const $wrapper = document.querySelector(SELECTORS.wrapper);

	if (!$wrapper) return;

	let circles = gsap.utils.toArray(SELECTORS.item);

	function mouseMoveFunc(e) {
		// Получаем позицию контейнера
		const rect = $wrapper.getBoundingClientRect();

		circles.forEach((circle, index) => {
			let depth = 5;
			if (index !== 0) depth * 2;

			// Изменение для координат относительно контейнера, инвертировано
			const moveX = -(e.clientX - rect.left - rect.width / 2) / (depth + index);
			const moveY = -(e.clientY - rect.top - rect.height / 2) / (depth + 4 + index);

			index++; // Этот индекс используется для создания эффекта "глубины"

			gsap.to(circle, {
				x: moveX * index,
				y: moveY * index,
				duration: 0.6, // Плавность движения
			});
		});
	}

	ScrollTrigger.create({
		trigger: $wrapper,
		start: 'top-=90 top',
		end: 'bottom top',
		// markers: true,
		onEnter: () => {
			$wrapper.addEventListener('mousemove', mouseMoveFunc);
		},
		onEnterBack: () => {
			$wrapper.addEventListener('mousemove', mouseMoveFunc);
		},
		onLeave: () => {
			$wrapper.removeEventListener('mousemove', mouseMoveFunc);
		},
		onLeaveBack: () => {
			$wrapper.removeEventListener('mousemove', mouseMoveFunc);
		},
	});
};

export default animationCircle;
