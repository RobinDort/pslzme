const redirectionPageAnchor = document.getElementById("unpersonalized-page");

if (redirectionPageAnchor !== null) {
	// get the follow page
	const followPageParam = new URLSearchParams(window.location.search);
	const targetPage = followPageParam.get("pslzme-follow");

	redirectionPageAnchor.href = targetPage;
}
