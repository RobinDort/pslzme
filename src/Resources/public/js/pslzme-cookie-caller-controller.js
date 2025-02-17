const addVisibleClassesToElement = (element) => {
	element.style.visibility = "visible";

	element.classList.remove("animation", "slideOutRight", "slow");
	element.classList.add("animation", "slideInRight", "slow");
};

const addHiddenClassesToElement = (element) => {
	element.classList.remove("animation", "slideInRight", "slow");
	element.classList.add("animation", "slideOutRight", "slow");
};

const addCookieCallerClickListener = () => {
	$("#pslzme-cookie-caller").click(function (event) {
		$("#pslzme-cookiebar").css({
			display: "flex",
			"align-items": "center",
			"justify-content": "center",
		});
	});
};

const controlCookieCaller = () => {
	let html = document.querySelector("html");
	const pslzmeCookieCaller = document.getElementById("pslzme-cookie-caller");

	const queriesAreSet = queryParamsSet();

	// Add listener so the cookiebar can be displayed when clicking on the caller.
	addCookieCallerClickListener();

	// Add another listener to scroll behavior to display the caller when the user browses the page.
	window.addEventListener("scroll", function (event) {
		if (html.scrollTop >= 110) {
			if (queriesAreSet.isSet === true) {
				addVisibleClassesToElement(pslzmeCookieCaller);
			}
		} else if (html.scrollTop <= 110) {
			if (queriesAreSet.isSet === true) {
				addHiddenClassesToElement(pslzmeCookieCaller);
			}
		}
	});
};
