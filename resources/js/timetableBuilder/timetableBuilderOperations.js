import {checkForClash, generateTimetable, updateSubjectList, downloadTimetable} from './helperFunctions';

// TIMETABLE DISPLAY AND DOWNLOAD OPERATIONS

// Fetch timetable data on page load
document.addEventListener('DOMContentLoaded', function () {
    // Initialise the timetable builder
    fetch('/timetable-builder/initialise', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if (data.success) {
            generateTimetable(data.timetableSlots);
            updateSubjectList(data.timetableSlots);
        } else {
            console.error('Failed to load timetable');
        }
    })
    .catch(error => console.error('Error:', error));

    downloadTimetable();
});

// ADD TIMETABLE SLOT MODAL AND FORM OPERATIONS

const addTimetableSlotModalElement = document.getElementById('add-timetable-slot-modal');
const addTimetableSlotModal = new bootstrap.Modal(addTimetableSlotModalElement);
const addTimetableSlotForm = document.getElementById('add-timetable-slot-form');

document.addEventListener('DOMContentLoaded', function () {
    // Initialise the all subjects list
    let subjects = [];

    fetch('/resources/data/all_subjects_data.json')
        .then(response => response.json())
        .then(data => {
            subjects = data;
        });

    const timetableClashModalAdd = new bootstrap.Modal(document.getElementById('timetable-clash-modal-add'));
    const timeErrorModalAdd = new bootstrap.Modal(document.getElementById('time-error-modal-add'));

    // Function to filter subjects based on input
    function filterSubjects() {
        const input = document.getElementById('class-subject-code').value.toUpperCase();
        const subjectList = document.getElementById('subject-list');
        subjectList.innerHTML = '';  // Clear the list

        // Filter the subjects based on the input
        const filteredSubjects = subjects.filter(subject => subject.subject_code.startsWith(input));

        // Create a list of suggestions
        filteredSubjects.forEach(subject => {
            const item = document.createElement('a');
            item.classList.add('list-group-item', 'list-group-item-action');
            item.href = '#';
            item.textContent = `${subject.subject_code} - ${subject.subject_name}`;
            item.onclick = () => {
                // Fill the form with the selected subject
                document.getElementById('class-subject-code').value = subject.subject_code;
                document.getElementById('class-name').value = subject.subject_name;
                subjectList.innerHTML = '';  // Clear the list
            };
            subjectList.appendChild(item);
        });

        // If there are no matching subjects, hide the list
        if (filteredSubjects.length === 0) {
            subjectList.style.display = 'none';
        } else {
            subjectList.style.display = 'block';
        }
    }

    // Add event listener for filtering subjects in the modal form
    const subjectCodeInput = document.getElementById('class-subject-code');
    if (subjectCodeInput) {
        subjectCodeInput.addEventListener('input', filterSubjects);
    }

    if (addTimetableSlotForm) {
        addTimetableSlotForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(addTimetableSlotForm);
            const profileId = formData.get('profile_id');
            const classDay = formData.get('class_day');
            const classStartTime = formData.get('class_start_time');
            const classEndTime = formData.get('class_end_time');

            // Fetch existng timetable slots for the selected day and profile
            const getSlotsByDayRouteTemplate = window.getSlotsByDayRouteTemplate
                .replace(':class_day', classDay)
                .replace(':profile_id', profileId);

            // First check if the end time is earlier than the start time
            if (classEndTime <= classStartTime) {
                addTimetableSlotModal.hide();
                timeErrorModalAdd.show();

                // After the error modal is closed, show the add timetable modal again
                const timeErrorModalElement = document.getElementById('time-error-modal-add');
                timeErrorModalElement.addEventListener('hidden.bs.modal', function () {
                    addTimetableSlotModal.show();
                }, { once: true });

                return;
            }
            // If it is not, then proceed
            fetch(getSlotsByDayRouteTemplate)
                .then(response => response.json())
                .then(existingSlots => {
                    if (checkForClash(classStartTime, classEndTime, existingSlots)) {
                        // If a clash is detected, show the timetable clash error modal
                        addTimetableSlotModal.hide();
                        timetableClashModalAdd.show();

                        // After the clash modal is closed, show the add timetable modal again
                        const timetableClashModalElement = document.getElementById('timetable-clash-modal-add');
                        timetableClashModalElement.addEventListener('hidden.bs.modal', function () {
                            addTimetableSlotModal.show();
                        }, { once: true });
                    } else {
                        // If no clash, proceed to submit the form to the server
                        fetch(addTimetableSlotForm.action, {
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
                                console.log("Timetable builder refreshed with newly added data.");
                
                                // Close the modal after success
                                addTimetableSlotModal.hide();
                                document.getElementById('add-timetable-slot-form').reset();
            
                                updateSubjectList(data.timetableSlots);
                                generateTimetable(data.timetableSlots);
                            } else {
                                console.error('Error adding timetable slot:', data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
        });
    }
});

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
})

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
})
