import IMask from 'imask';
import { exist } from '../utils';

const formMask = () => {
	const SELECTORS = {
		phone: '.js-phone-mask',
		number: '.js-number-mask',
	};

	const CLASSNAMES = {};

	const $phone = document.querySelectorAll(SELECTORS.phone);
	const $number = document.querySelectorAll(SELECTORS.number);

	const initPhoneMask = () => {
		const maskOptions = {
			mask: '+{8}(000)000-00-00',
		};

		if (!exist($phone)) return;
		$phone.forEach((item) => {
			let mask = IMask(item, maskOptions);
		});
	};
	const initNumberMask = () => {
		if (!exist($number)) return;
		$number.forEach((item) => {
			let mask = IMask(item, {
				mask: Number,
			});
		});
	};

	initPhoneMask();
	initNumberMask();
};

export default formMask;
