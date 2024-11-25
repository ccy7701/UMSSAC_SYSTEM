document.addEventListener('DOMContentLoaded', function() {
    // Get the modal element
    const flashModal = document.getElementById('flashModal');
    
    // Check if the modal element exists
    if (flashModal) {
        // Initialise the modal using Bootstrap's Modal class
        const modalInstance = new bootstrap.Modal(flashModal);
        // Show the modal
        modalInstance.show();
        // Set a timeout to hide the modal after 5 seconds
        setTimeout(function() {
            modalInstance.hide();
        }, 10000);
    } else {
        console.error('Flash modal element not found');
    }
});
