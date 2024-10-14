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
