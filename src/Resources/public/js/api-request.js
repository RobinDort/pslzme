function handleAPIRequest(requestObject) {
	return new Promise(function (resolve, reject) {
		// Send the second AJAX request
		$.ajax({
			type: "POST",
			url: "/requestHandler",
			dataType: "json",
			encode: true,
			data: requestObject,
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
