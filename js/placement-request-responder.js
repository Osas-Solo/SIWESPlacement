function respondToPlacementRequestResponderRequest(response, placementRequestId) {
    const responseMessage = response.toLowerCase().substring(0, response.length - 2);
    if (confirm("Are you sure you want to " + responseMessage + " placement request?")) {
        const placementRequestResponderRequest = new XMLHttpRequest();

        placementRequestResponderRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (confirm(this.responseText)) {
                    window.location.reload();
                } else {
                    window.location.reload();
                }
            }
        };

        placementRequestResponderRequest.open("POST", "placement-request-responder.php", true);
        placementRequestResponderRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        placementRequestResponderRequest.send("id=" + placementRequestId + "&status=" + response);
    }
}