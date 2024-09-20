// TIMETABLE DISPLAY OPERATIONS

// Fetch timetable data on page load
document.addEventListener('DOMContentLoaded', function () {
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
});

// ADD TIMETABLE SLOT MODAL AND FORM OPERATIONS

const addTimetableSlotModalElement = document.getElementById('add-timetable-slot-modal');
const addTimetableSlotModal = new bootstrap.Modal(addTimetableSlotModalElement);
const addTimetableSlotForm = document.getElementById('add-timetable-slot-form');

document.addEventListener('DOMContentLoaded', function () {
    const timetableClashModal = new bootstrap.Modal(document.getElementById('timetable-clash-modal'));
    const timeErrorModal = new bootstrap.Modal(document.getElementById('time-error-modal'));

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
                timeErrorModal.show();

                // After the error modal is closed, show the add timetable modal again
                const timeErrorModalElement = document.getElementById('time-error-modal');
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
                        timetableClashModal.show();

                        // After the clash modal is closed, show the add timetable modal again
                        const timetableClashModalElement = document.getElementById('timetable-clash-modal');
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
    const timetableClashModal = new bootstrap.Modal(document.getElementById('timetable-clash-modal'));
    const timeErrorModal = new bootstrap.Modal(document.getElementById('time-error-modal'));

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
                timeErrorModal.show();

                // After the error modal is closed, show the add timetable modal again
                const timeErrorModalElement = document.getElementById('time-error-modal');
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
                        timetableClashModal.show();

                        const timetableClashModalElement = document.getElementById('timetable-clash-modal');
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

// HELPER FUNCTIONS

// Helper function to convert to AM/PM format
function convertToAMPM(time) {
    let hours = time.split(':');
    hours = parseInt(hours, 10);
    const am_pm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    return `${hours} ${am_pm}`;
}

// Helper function to check for timetable timeslot clashes
function checkForClash(newStartTime, newEndTime, existingSlots) {
    for (const slot of existingSlots) {
        if ((newStartTime >= slot.class_start_time && newStartTime < slot.class_end_time) ||
            (newEndTime > slot.class_start_time && newEndTime <= slot.class_end_time) ||
            (newStartTime <= slot.class_start_time && newEndTime >= slot.class_end_time)) {
            return true; // Clash detected
        }
    }
    return false; // No clash
}

// Helper function to generate the timetable dynamically
function generateTimetable(timetableSlots) {
    const timetableBody = document.getElementById('timetable-body');
    const daysOfTheWeek = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];

    // Clear the current timetable
    timetableBody.innerHTML = '';

    // Loop over each day of the week
    daysOfTheWeek.forEach((dayName, dayIndex) => {
        const dayNumber = dayIndex + 1; // 1 = Monday, 7 = Sunday
        const row = document.createElement('tr');

        // Create the day header (e.g., MON, TUE)
        const dayCell = document.createElement('th');
        dayCell.setAttribute('id', dayName);
        dayCell.textContent = dayName;
        row.appendChild(dayCell);

        // Initialize the start hour at 7 AM
        let hour = 7;

        // Loop through each hour from 7 AM to 10 PM
        while (hour < 22) {
            const classData = getClassIfExists(timetableSlots, dayNumber, hour);
            
            if (classData) {
                // Create a cell for the class
                const classCell = document.createElement('td');
                classCell.colSpan = classData.colspan;
                classCell.innerHTML = `${classData.class_subject_code}<br>${classData.class_location}`;
    
                // Add class based on the category
                switch (classData.class_category) {
                    case 'lecture':
                        classCell.classList.add('bg-primary', 'text-white');
                        break;
                    case 'labprac':
                        classCell.classList.add('bg-warning', 'text-dark');
                        break;
                    case 'tutorial':
                        classCell.classList.add('bg-info', 'text-white');
                        break;
                    case 'cocurricular':
                        classCell.classList.add('bg-success', 'text-white');
                        break;
                    default:
                        classCell.classList.add('bg-secondary', 'text-white'); // Default category style
                }
    
                row.appendChild(classCell);
                // Skip the hours that the class occupies
                hour += classData.colspan;
            } else {
                // Create an empty cell if no class is found
                const emptyCell = document.createElement('td');
                row.appendChild(emptyCell);
                hour++;
            }
        }

        // Append the row to the timetable body
        timetableBody.appendChild(row);
    });
}

// Helper function to handle generation on timeslots with existing classes
function getClassIfExists(timetableSlots, day, hour) {
    for (const slot of timetableSlots) {
        const classDay = slot.class_day;
        const startHour = parseInt(slot.class_start_time.split(':')[0], 10);
        const endHour = parseInt(slot.class_end_time.split(':')[0], 10);
        const colspan = endHour - startHour;

        if (classDay == day && startHour == hour) {
            return {
                colspan: colspan,
                class_subject_code: slot.class_subject_code,
                class_location: slot.class_location,
                class_category: slot.class_category,
            };
        }
    }
    return null;
}

// Helper function to update the subject list dynamically
function updateSubjectList(timetableSlots) {
    const tableBody = document.getElementById('subjects-added-table-body');
    tableBody.innerHTML = '';

    if (timetableSlots.length > 0) {
        timetableSlots.forEach(slot => {
            const row = document.createElement('tr');
            row.className = 'text-left align-middle';

            let class_day = "";
            switch(slot.class_day) {
                case 1: class_day = "Monday"; break;
                case 2: class_day = "Tuesday"; break;
                case 3: class_day = "Wednesday"; break;
                case 4: class_day = "Thursday"; break;
                case 5: class_day = "Friday"; break;
                case 6: class_day = "Saturday"; break;
                case 7: class_day = "Sunday"; break;
            }
            let class_category = "";
            switch(slot.class_category) {
                case 'cocurricular': class_category = "Cocurricular"; break;
                case 'lecture': class_category = "Lecture"; break;
                case 'labprac': class_category = "Lab/Practical"; break;
                case 'tutorial': class_category = "Tutorial"; break;
            }
            row.innerHTML = `
                <td>${slot.class_subject_code}</td>
                <td>${slot.class_name} (${class_category})</td>
                <td>${slot.class_section}</td>
                <td>${slot.class_lecturer}</td>
                <td>${class_day}</td>
                <td>${convertToAMPM(slot.class_start_time)} - ${convertToAMPM(slot.class_end_time)}</td>
                <td>${slot.class_location}</td>
                <td style="width: 1%;">
                    <div class="dropdown">
                        <button class="subject-row btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton${slot.timetable_slot_id}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton${slot.timetable_slot_id}">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="editTimetableSlot(${slot.timetable_slot_id})"
                                data-bs-target="#edit-timetable-slot-modal">Edit</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="text-danger dropdown-item"
                                    data-bs-toggle="modal"
                                    data-bs-target="#delete-confirmation-modal"
                                    data-timetable-slot-id="${slot.timetable_slot_id}">Delete</a>
                            </li>
                        </ul>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="7">No subjects added yet</td>`;
        tableBody.appendChild(row);
    }
}
