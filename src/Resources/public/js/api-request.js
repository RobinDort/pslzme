function handleAPIRequest(requestObject) {
	try {
		return new Promise(function (resolve, reject) {
			// Send the second AJAX request
			$.ajax({
				url: "/requestHandler",
				type: "POST",
				data: requestObject,
				success: function (response) {
					console.log("Action called: " + requestObject.request);
					console.log(response);
					resolve(response);
				},
				error: function (error) {
					console.log("Action failed: " + requestObject.request);
					console.log(error);
					reject(error);
				},
			});
		});
	} catch (error) {
		console.error(error);
	}
}
