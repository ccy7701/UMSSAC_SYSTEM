// Club new image preview
document.addEventListener('DOMContentLoaded', function () {
    // Club new image preview
    const newImageInput = document.getElementById('new-image-input');
    const newImageSubmit = document.getElementById('new-image-submit');
    const newImagePreview = document.getElementById('new-image-preview');
    const viewImageModal = document.getElementById('view-image-modal');
    const deleteConfirmationModal = document.getElementById('delete-confirmation-modal');

    // Disable the submit button initially, if it exists
    if (newImageSubmit) {
        newImageSubmit.disabled = true;
    }

    // Club image preview and button enable/disable
    newImageInput.addEventListener('change', function(event) {
         const [file] = event.target.files;

         // If a file is selected, update the preview and enable the button
         if (file) {
            newImagePreview.src = URL.createObjectURL(file);
             newImageSubmit.disabled = false;
        } else {
             // Disable the button if no file is selected
             newImageSubmit.disabled = true;
         }
    });

    // Update modal image
    if (viewImageModal) {
        viewImageModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const imageUrl = button.getAttribute('data-image');
            const imageIndex = button.getAttribute('data-index');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
            const modalImageIndex = document.getElementById('image-index');
            modalImageIndex.textContent = `Club image ${imageIndex}`;
        });
    }
    
    if (deleteConfirmationModal) {
        deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const key = button.getAttribute('data-key');
            const deleteKeyInput = document.getElementById('delete-key');
            deleteKeyInput.value = key;
        });
    }
});
