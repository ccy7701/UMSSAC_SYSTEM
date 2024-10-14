document.addEventListener('DOMContentLoaded', function () {
    const selfView = document.getElementById('self-view');
    const othersView = document.getElementById('others-view');
    const toggleSelfViewBtn = document.getElementById('toggle-self-view');
    const toggleOthersViewBtn = document.getElementById('toggle-others-view');

    // Initially show only the "self view" and hide "others view"
    othersView.style.display = 'none';
    toggleSelfViewBtn.classList.add('active'); // Set the initial active button

    // Add event listener for the "Added by me" button
    toggleSelfViewBtn.addEventListener('click', function () {
        selfView.style.display = 'block'; // Show self view
        othersView.style.display = 'none'; // Hide others view

        // Set the "active" class on the correct button
        toggleSelfViewBtn.classList.add('active');
        toggleOthersViewBtn.classList.remove('active');
    });

    // Add event listener for the "Added by others" button
    toggleOthersViewBtn.addEventListener('click', function () {
        selfView.style.display = 'none'; // Hide self view
        othersView.style.display = 'block'; // Show others view

        // Set the "active" class on the correct button
        toggleOthersViewBtn.classList.add('active');
        toggleSelfViewBtn.classList.remove('active');
    });
});

const deleteConfirmationModalElement = document.getElementById('delete-sp-confirmation-modal');
const deleteConfirmationModal = new bootstrap.Modal(deleteConfirmationModalElement);
const deleteTimetableSlotForm = document.getElementById('delete-sp-form');

deleteConfirmationModalElement.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const studyPartnerName = button.getAttribute('data-study-partner-name');
    const studyPartnerProfileId = button.getAttribute('data-study-partner-profile-id');

    const modalBodyText = document.getElementById('delete-added-sp-body');
    modalBodyText.textContent = `Are you sure you want to remove ${studyPartnerName} from your study partners list?`;

    const studyPartnerProfileIdInput = document.getElementById('study-partner-profile-id');
    studyPartnerProfileIdInput.value = studyPartnerProfileId;
});
