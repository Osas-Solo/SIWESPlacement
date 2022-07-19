function sendPlacementRequest(placementReference) {
    const placementRequest = new XMLHttpRequest();

    placementRequest.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
        }
    };

    placementRequest.open("POST", "send-placement-request.php", true);
    placementRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    placementRequest.send("placement-reference=" + placementReference);
}