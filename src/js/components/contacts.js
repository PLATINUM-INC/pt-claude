const contacts = () => {
	const CONTACT_API = "/wp-json/site/v1/contacts";
	let cached = null;

	const preload = () => {
		fetch(CONTACT_API, { cache: "no-cache" })
			.then((r) => r.ok ? r.json() : null)
			.then((data) => { cached = data; })
			.catch(() => {});
	};

	const buildMessage = () => {
		return pt_bunny?.contact_message || '';
	};

	document.addEventListener("click", (e) => {
		const btn = e.target.closest(".model-contact-js");
		if (!btn) return;
		e.preventDefault();

		const id = btn.id;
		const map = { tg: "telegram", wa: "whatsapp" };
		const key = map[id];
		if (!key) return;

		if (!cached) {
			console.warn("Contacts not loaded yet");
			return;
		}

		let url = cached[key];
		if (!url) return;

		const message = buildMessage();
		const encoded = encodeURIComponent(message);
		url = url.includes("?") ? `${url}&text=${encoded}` : `${url}?text=${encoded}`;

		window.open(url, "_blank", "noopener,noreferrer");
	});

	preload();
};

export default contacts;