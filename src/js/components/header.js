const desktopHeader = () => {
	const items = document.querySelectorAll(".filters-nav-list .menu-item");

	if (!items.length) return;

	items.forEach(item => {
		const toggle = item.querySelector(".dropdown-toggle--js");
		if (!toggle) return;

		const clickHandler = (e) => {
			e.preventDefault();
			e.stopPropagation();

			items.forEach(i => {
				if (i !== item) {
					i.classList.remove("open");
					i.querySelector(".dropdown-toggle--js")?.classList.remove("active");
				}
			});

			item.classList.toggle("open");
			toggle.classList.toggle("active");
		};

		// сохраняем ссылку, чтобы можно было удалить позже
		toggle._desktopHandler = clickHandler;
		toggle.addEventListener("click", clickHandler);
	});

	document.addEventListener("click", desktopHeader.closeAll = () => {
		items.forEach(i => {
			i.classList.remove("open");
			i.querySelector(".dropdown-toggle--js")?.classList.remove("active");
		});
	});
};

desktopHeader.destroy = () => {
	console.log("desktop header destroyed");

	const items = document.querySelectorAll(".filters-nav-list .menu-item");

	items.forEach(item => {
		const toggle = item.querySelector(".dropdown-toggle--js");
		if (toggle && toggle._desktopHandler) {
			toggle.removeEventListener("click", toggle._desktopHandler);
			delete toggle._desktopHandler;
		}
		item.classList.remove("open");
	});

	document.removeEventListener("click", desktopHeader.closeAll);
};



const mobileHeader = () => {
	console.log("mobile header init");

	const panel = document.querySelector(".js-filters-panel");
	const openBtn = document.querySelector(".js-filters-open");
	const closeBtn = document.querySelector(".js-filters-close");
	const items = document.querySelectorAll(".mobile-filters-list .m-item");

	if (!panel) return;

	openBtn?.addEventListener("click", mobileHeader._open = () => {
		panel.classList.add("open");
		document.body.style.overflow = "hidden";
	});

	closeBtn?.addEventListener("click", mobileHeader._close = () => {
		panel.classList.remove("open");
		document.body.style.overflow = "";
	});

	items.forEach(item => {
		const toggle = item.querySelector(".m-toggle");
		const handler = () => {
			items.forEach(i => i !== item && i.classList.remove("open"));
			item.classList.toggle("open");
		};
		toggle._mobileHandler = handler;
		toggle?.addEventListener("click", handler);
	});
};

mobileHeader.destroy = () => {
	console.log("mobile header destroyed");

	const panel = document.querySelector(".js-filters-panel");
	const items = document.querySelectorAll(".mobile-filters-list .m-item");
	const openBtn = document.querySelector(".js-filters-open");
	const closeBtn = document.querySelector(".js-filters-close");

	openBtn?.removeEventListener("click", mobileHeader._open);
	closeBtn?.removeEventListener("click", mobileHeader._close);

	items.forEach(item => {
		const toggle = item.querySelector(".m-toggle");
		if (toggle && toggle._mobileHandler) {
			toggle.removeEventListener("click", toggle._mobileHandler);
			delete toggle._mobileHandler;
		}
		item.classList.remove("open");
	});

	document.body.style.overflow = "";
};



let currentMode = null;

const header = () => {
	const isMobile = window.innerWidth < 992;

	if (isMobile && currentMode !== "mobile") {
		desktopHeader.destroy();
		mobileHeader();
		currentMode = "mobile";
	}

	if (!isMobile && currentMode !== "desktop") {
		mobileHeader.destroy();
		desktopHeader();
		currentMode = "desktop";
	}
};

// init
window.addEventListener("load", header);
window.addEventListener("resize", () => {
	clearTimeout(window._headerResize);
	window._headerResize = setTimeout(header, 150);
});

export default header;
