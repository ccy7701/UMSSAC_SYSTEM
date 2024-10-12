import {checkForClash, generateTimetable, updateSubjectList} from './helperFunctions.js';

// EDIT SUBJECT MODAL AND FORM OPERATIONS

const editTimetableSlotModalElement = document.getElementById('edit-timetable-slot-modal');
const editTimetableSlotModal = new bootstrap.Modal(editTimetableSlotModalElement);
const editTimetableSlotForm = document.getElementById('edit-timetable-slot-form');

window.editTimetableSlot = function(timetable_slot_id) {
    const timetableSlotRoute = window.getTimetableSlotRouteTemplate
        .replace(':timetable_slot_id', timetable_slot_id);

    fetch(timetableSlotRoute)
        .then(response => response.json())
        .then(data => {
            // Populate modal form fields with fetched data
            document.getElementById('edit-timetable-slot-id').value = data.timetable_slot_id;
            document.getElementById('edit-class-subject-code').value = data.class_subject_code;
            document.getElementById('edit-class-name').value = data.class_name;
            document.getElementById('edit-class-category').value = data.class_category;
            document.getElementById('edit-class-section').value = data.class_section;
            document.getElementById('edit-class-lecturer').value = data.class_lecturer;
            document.getElementById('edit-class-location').value = data.class_location;
            document.getElementById('edit-day').value = data.class_day;
            document.getElementById('edit-start-time').value = data.class_start_time;
            document.getElementById('edit-end-time').value = data.class_end_time;

            const formAction = window.editTimetableSlotRouteTemplate
                .replace(':timetable_slot_id', timetable_slot_id);

            document.getElementById('edit-timetable-slot-form').action = formAction;

            // Open the modal
            editTimetableSlotModal.show();
        })
        .catch(error => console.error('Error fetching timetable slot data:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    const timetableClashModalEdit = new bootstrap.Modal(document.getElementById('timetable-clash-modal-edit'));
    const timeErrorModalEdit = new bootstrap.Modal(document.getElementById('time-error-modal-edit'));

    if (editTimetableSlotForm) {
        editTimetableSlotForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(editTimetableSlotForm);
            const classDay = formData.get('class_day');
            const classStartTime = formData.get('class_start_time');
            const classEndTime = formData.get('class_end_time');
            const profileId = formData.get('profile_id');
            const timetableSlotId = formData.get('timetable_slot_id');

            // First check if the end time is earlier than the start time
            if (classEndTime <= classStartTime) {
                editTimetableSlotModal.hide();
                timeErrorModalEdit.show();

                // After the error modal is closed, show the add timetable modal again
                const timeErrorModalElement = document.getElementById('time-error-modal-edit');
                timeErrorModalElement.addEventListener('hidden.bs.modal', function () {
                    editTimetableSlotModal.show();
                }, { once: true});

                return;
            }
            // If it is not, then proceed
            fetch(`/get-slots-by-day/${String(profileId)}/${String(classDay)}/${String(timetableSlotId)}`)
                .then(response => response.json())
                .then(existingSlots => {
                    if (checkForClash(classStartTime, classEndTime, existingSlots)) {
                        editTimetableSlotModal.hide();
                        timetableClashModalEdit.show();

                        const timetableClashModalElement = document.getElementById('timetable-clash-modal-edit');
                        timetableClashModalElement.addEventListener('hidden.bs.modal', function () {
                            editTimetableSlotModal.show();
                        }, { once: true });
                    } else {
                        fetch(editTimetableSlotForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
                                console.log("Timetable builder refreshed with edited data.");

                                editTimetableSlotModal.hide();
                                document.getElementById('edit-timetable-slot-form').reset();

                                updateSubjectList(data.timetableSlots);
                                generateTimetable(data.timetableSlots);
                            } else {
                                console.error('Error editing timetable slot:', data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                })
        });
    }
});
