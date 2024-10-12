import {generateTimetable, updateSubjectList} from './helperFunctions.js';

// DELETE SUBJECT MODAL AND FORM OPERATIONS

const deleteConfirmationModalElement = document.getElementById('delete-confirmation-modal');
const deleteConfirmationModal = new bootstrap.Modal(deleteConfirmationModalElement);
const deleteTimetableSlotForm = document.getElementById('delete-timetable-slot-form');

// Update the form fields every time the modal is shown
deleteConfirmationModalElement.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const timetableSlotId = button.getAttribute('data-timetable-slot-id');

    // Populate the form fields with the new data
    document.getElementById('timetable-slot-id').value = timetableSlotId;

    // Update the form action URL dynamically
    const deleteRoute = window.deleteTimetableSlotRouteTemplate
        .replace(':timetable_slot_id', timetableSlotId)

    deleteTimetableSlotForm.action = deleteRoute;
});

deleteConfirmationModalElement.addEventListener('hidden.bs.modal', function () {
    deleteTimetableSlotForm.reset();
    deleteTimetableSlotForm.action = '';
})

document.addEventListener('DOMContentLoaded', function () {
    deleteTimetableSlotForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(deleteTimetableSlotForm);
        const formAction = deleteTimetableSlotForm.action;

        fetch(formAction, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log("Timetable slot deleted successfully.");
                deleteConfirmationModal.hide();
                deleteTimetableSlotForm.reset();
                updateSubjectList(data.timetableSlots);
                generateTimetable(data.timetableSlots);
            } else {
                alert('Failed to delete timetable slot. Please try again.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
