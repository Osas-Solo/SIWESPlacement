function previewPhoto(event) {
    const displayPhotoPreview = document.getElementById("photo-preview");
    const originalImageSource = displayPhotoPreview.src;

    try {
        displayPhotoPreview.src = URL.createObjectURL(event.target.files[0]);
        displayPhotoPreview.onload = () => {
            URL.revokeObjectURL(displayPhotoPreview.src)
        }
    } catch (e) {
        displayPhotoPreview.src = originalImageSource;
    }
}