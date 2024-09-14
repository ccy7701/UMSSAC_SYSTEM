// Club new image preview
document.addEventListener('DOMContentLoaded', function () {
    // Club new image preview
    const newImageInput = document.getElementById('new-image-input');
    const newImageSubmit = document.getElementById('new-image-submit');
    const newClubImagePreview = document.getElementById('new-club-image-preview');

    // Disable the submit button initially
    newImageSubmit.disabled = true;

    // Club image preview and button enable/disable
    newImageInput.addEventListener('change', function(event) {
        const [file] = event.target.files;

        // If a file is selected, update the preview and enable the button
        if (file) {
            newClubImagePreview.src = URL.createObjectURL(file);
            newImageSubmit.disabled = false;
        } else {
            // Disable the button if no file is selected
            newImageSubmit.disabled = true;
        }
    });
});
