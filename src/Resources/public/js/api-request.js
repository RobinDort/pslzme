function handleAPIRequest(requestObject) {
	return new Promise(function (resolve, reject) {
		var csrfToken = window.CONTROLLER_REQUEST_TOKEN || document.querySelector('meta[name="csrf-token"]').content;
		// Send the second AJAX request
		$.ajax({
			type: "POST",
			url: "/requestHandler",
			dataType: "json",
			encode: true,
			data: { ...requestObject, REQUEST_TOKEN: csrfToken },
			success: function (response) {
				console.log(response);
				resolve(response);
			},
			error: function (error) {
				console.log(error);
				reject(error);
			},
		});
	});
}
