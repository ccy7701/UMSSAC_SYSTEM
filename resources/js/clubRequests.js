document.addEventListener('DOMContentLoaded', function () {
    const pendingView = document.getElementById('pending-view');
    const acceptedView = document.getElementById('accepted-view');
    const rejectedView = document.getElementById('rejected-view');

    const togglePendingViewBtn = document.getElementById('toggle-pending-view');
    const toggleAcceptedViewBtn = document.getElementById('toggle-accepted-view');
    const toggleRejectedViewBtn = document.getElementById('toggle-rejected-view');

    // Initially show only the pending view and hide the other views. Also set pending button as active
    acceptedView.style.display = 'none';
    rejectedView.style.display = 'none';
    togglePendingViewBtn.classList.add('active');

    // Add eventListener for the pending button
    togglePendingViewBtn.addEventListener('click', function () {
        pendingView.style.display = 'block';
        acceptedView.style.display = 'none';
        rejectedView.style.display = 'none';

        togglePendingViewBtn.classList.add('active');
        toggleAcceptedViewBtn.classList.remove('active');
        toggleRejectedViewBtn.classList.remove('active');
    });

    // Add eventListener for the accepted button
    toggleAcceptedViewBtn.addEventListener('click', function () {
        acceptedView.style.display = 'block';
        pendingView.style.display = 'none';
        rejectedView.style.display = 'none';

        toggleAcceptedViewBtn.classList.add('active');
        togglePendingViewBtn.classList.remove('active');
        toggleRejectedViewBtn.classList.remove('active');
    });

    // Add eventListener for the rejected button
    toggleRejectedViewBtn.addEventListener('click', function () {
        rejectedView.style.display = 'block';
        pendingView.style.display = 'none';
        acceptedView.style.display = 'none';

        toggleRejectedViewBtn.classList.add('active');
        togglePendingViewBtn.classList.remove('active');
        toggleAcceptedViewBtn.classList.remove('active');
    });
});

const rejectConfirmationModalElement = document.getElementById('reject-confirmation-modal');
const rejectConfirmationModal = new bootstrap.Modal(rejectConfirmationModalElement);
const rejectRequestForm = document.getElementById('reject-request-form');

rejectConfirmationModalElement.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const clubName = button.getAttribute('data-club-name');
    const creationRequestId = button.getAttribute('data-creation-request-id');

    const modalBodyText = document.getElementById('reject-request-body');
    modalBodyText.innerHTML = `
        You are about to reject the request to create ${clubName}. <span class="text-danger">This action cannot be undone.</span>
    `;

    const creationRequestIdInput = document.getElementById('creation-request-id');
    creationRequestIdInput.value = creationRequestId;
    
    console.log(creationRequestIdInput);
});

// Handle accept request form submission
document.querySelector('button[data-bs-target="#accept-confirmation-modal"]').addEventListener('click', function (event) {
    // Prevent the default form submission
    event.preventDefault();

    // Populate the hidden input in the accept request form with the creation request ID
    const creationRequestId = document.querySelector('input[name="creation_request_id"]').value;
    const acceptRequestForm = document.getElementById('accept-request-form');
    acceptRequestForm.querySelector('input[name="creation_request_id"]').value = creationRequestId;

    // Show the modal
    const acceptConfirmationModal = new bootstrap.Modal(document.getElementById('accept-confirmation-modal'));
    acceptConfirmationModal.show();
});
