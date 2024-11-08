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
        Are you sure you want to reject the request to create ${clubName}? <span class="text-danger">This action cannot be undone!</span>
    `;

    const creationRequestIdInput = document.getElementById('creation-request-id');
    creationRequestIdInput.value = creationRequestId;
});
