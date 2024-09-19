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
    if (addTimetableSlotForm) {
        addTimetableSlotForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(addTimetableSlotForm);

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
                    console.log(addTimetableSlotModal);
                    addTimetableSlotModal.hide();
                    document.getElementById('add-timetable-slot-form').reset();

                    updateSubjectList(data.timetableSlots);
                    generateTimetable(data.timetableSlots);
                } else {
                    console.error('Error adding timetable slot:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});

// EDIT SUBJECT MODAL AND FORM OPERATIONS

const editTimetableSlotModalElement = document.getElementById('edit-timetable-slot-modal');
const editTimetableSlotModal = new bootstrap.Modal(editTimetableSlotModalElement);
const editTimetableSlotForm = document.getElementById('edit-timetable-slot-form');

window.editTimetableSlot = function(profile_id, class_subject_code) {
    const subjectDataRoute = window.getSubjectDataRouteTemplate
        .replace(':profile_id', profile_id)
        .replace(':class_subject_code', class_subject_code);

    fetch(subjectDataRoute)
        .then(response => response.json())
        .then(data => {
            // Populate modal form fields with fetched data
            document.getElementById('edit-class-subject-code').value = data.class_subject_code;
            document.getElementById('edit-class-name').value = data.class_name;
            document.getElementById('edit-class-category').value = data.class_category;
            document.getElementById('edit-class-section').value = data.class_section;
            document.getElementById('edit-class-lecturer').value = data.class_lecturer;
            document.getElementById('edit-class-location').value = data.class_location;
            document.getElementById('edit-day').value = data.class_day;
            document.getElementById('edit-start-time').value = data.class_start_time;
            document.getElementById('edit-end-time').value = data.class_end_time;

            const formAction = window.editSubjectRouteTemplate
                .replace(':profile_id', profile_id)
                .replace(':class_subject_code', class_subject_code);

            console.log("NEW_FORM_ACTION", formAction);

            document.getElementById('edit-timetable-slot-form').action = formAction;

            // Open the modal
            editTimetableSlotModal.show();
        })
        .catch(error => console.error('Error fetching timetable slot data:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    if (editTimetableSlotForm) {
        editTimetableSlotForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(editTimetableSlotForm);
            const formAction = editTimetableSlotForm.action;

            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log("Timetable slot updated successfully!");

                    console.log('Modal instance:', editTimetableSlotModal);
                    editTimetableSlotModal.hide();
                    document.getElementById('edit-timetable-slot-form').reset();

                    updateSubjectList(data.timetableSlots);
                    generateTimetable(data.timetableSlots);
                } else {
                    alert('Failed to update the timetable slot. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error))
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
    const profileId = button.getAttribute('data-profile-id');
    const classSubjectCode = button.getAttribute('data-class-subject-code');

    // Populate the form fields with the new data
    document.getElementById('profile-id').value = profileId;
    document.getElementById('class-subject-code').value = classSubjectCode;

    // Update the form action URL dynamically
    const deleteRoute = window.deleteRouteTemplate
        .replace(':profile_id', profileId)
        .replace(':class_subject_code', classSubjectCode);

    deleteTimetableSlotForm.action = deleteRoute;

    console.log("Delete Route:", deleteRoute);
});

deleteConfirmationModalElement.addEventListener('hidden.bs.modal', function () {
    deleteTimetableSlotForm.reset();
    deleteTimetableSlotForm.action = '';

    console.log(deleteTimetableSlotForm.action);
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
            row.innerHTML = `
                <td>${slot.class_subject_code}</td>
                <td>${slot.class_name}</td>
                <td>${slot.class_section}</td>
                <td>${slot.class_lecturer}</td>
                <td>${class_day}</td>
                <td>${convertToAMPM(slot.class_start_time)} - ${convertToAMPM(slot.class_end_time)}</td>
                <td>${slot.class_location}</td>
                <td style="width: 1%;">
                    <div class="dropdown">
                        <button class="subject-row btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton${slot.class_subject_code}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton${slot.class_subject_code}">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="editTimetableSlot(${slot.profile_id}, '${slot.class_subject_code}')"
                                data-bs-target="#edit-timetable-slot-modal">Edit</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="text-danger dropdown-item"
                                    data-bs-toggle="modal"
                                    data-bs-target="#delete-confirmation-modal"
                                    data-profile-id="${slot.profile_id}"
                                    data-class-subject-code="${slot.class_subject_code}">Delete</a>
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