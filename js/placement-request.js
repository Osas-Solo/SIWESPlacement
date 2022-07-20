function sendPlacementRequest(placementReference) {
    const placementRequest = new XMLHttpRequest();

    placementRequest.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.includes("view-placement-request.php")) {
                const viewPlacementRequestURL = this.responseText;

                if (confirm("Placement request sent successfully.")) {
                    window.location.replace(viewPlacementRequestURL);
                } else {
                    window.location.replace(viewPlacementRequestURL);
                }
            } else if (this.responseText.includes("upload-documents.php")) {
                const uploadDocumentsURL = this.responseText;

                if (confirm("Sorry you'd need to upload both your student ID card and IT placement letter before " +
                    "sending a placement request.")) {
                    window.location.replace(uploadDocumentsURL);
                } else {
                    window.location.replace(uploadDocumentsURL);
                }
            } else {
                alert(this.responseText);
            }
        }
    };

    placementRequest.open("POST", "send-placement-request.php", true);
    placementRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    placementRequest.send("placement-reference=" + placementReference);
}