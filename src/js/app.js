import layout from './layout/layout';
import header from './components/header';
import contacts from './components/contacts';
import modelGallery from "./components/model-gallery";
import { documentReady, pageLoad } from './utils';
const app = () => {
	layout();
	pageLoad(() => {
		contacts();
		header();
		modelGallery();
	});
};

// -------------------  init App
documentReady(() => {
	app();
});
// -------------------  init App##
