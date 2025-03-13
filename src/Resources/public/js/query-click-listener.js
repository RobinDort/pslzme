function pslzmeQueryClickListener() {
	const queryParams = queryParamsSet();

	if (queryParams.isSet === true) {
		// Attach a click event listener to the document
		document.addEventListener("click", function (event) {
			// Check if the clicked element matches the selector
			const eventTarget = event.target;

			if (eventTarget.matches("a[href$='.html']") || eventTarget.matches("a img") || eventTarget.matches("a canvas")) {
				//event.preventDefault();

				let hrefOfEventTarget;

				if (eventTarget.matches("a canvas")) {
					hrefOfEventTarget = eventTarget.parentElement.parentElement.parentElement.href;
				} else if (eventTarget.matches("a img")) {
					hrefOfEventTarget = eventTarget.parentElement.href;
				} else {
					hrefOfEventTarget = event.target.href;
				}

				// check if the user clicked on the page logo and thus would be redirected to the base url without a pathname.
				if (hrefOfEventTarget === window.location.origin + "/") {
					// redirect the user to the homepage
					hrefOfEventTarget = window.location.origin + "/home.html";
				}

				if (isSameDomain(hrefOfEventTarget)) {
					window.location.href =
						hrefOfEventTarget +
						"?q1=" +
						queryParams.params.linkCreator +
						"&q2=" +
						queryParams.params.title +
						"&q3=" +
						queryParams.params.firstname +
						"&q4=" +
						queryParams.params.lastname +
						"&q5=" +
						queryParams.params.company +
						"&q6=" +
						queryParams.params.gender +
						"&q7=" +
						queryParams.params.position +
						"&q8=" +
						queryParams.params.curl +
						"&q9=" +
						queryParams.params.fc +
						"&q10=" +
						queryParams.params.timestamp +
						"&q11=" +
						queryParams.params.companyGender;
				} else {
					// remove click listener
					event.target.removeEventListener("click", arguments.callee);
				}
			}
		});
	}
}

function isSameDomain(url) {
	const currentDomain = window.location.hostname;
	const clickedDomain = new URL(url).hostname;
	return currentDomain === clickedDomain;
}
