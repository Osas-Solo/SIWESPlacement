function previewMedia(event, elementID) {
    const mediaPreview = document.getElementById(elementID);
    const originalMediaSource = mediaPreview.src;

    try {
        mediaPreview.src = URL.createObjectURL(event.target.files[0]);
        mediaPreview.onload = () => {
            URL.revokeObjectURL(mediaPreview.src)
        }
    } catch (e) {
        mediaPreview.src = originalMediaSource;
    }
}