import {dayToString, dayToInt, convertToAMPM, checkForClash, generateTimetable, updateSubjectList, downloadTimetable} from './helperFunctions.js';
import './editTimetableSlot.js';
import './deleteTimetableSlot.js';

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

        createSuggestionsList(subjectList, filteredSubjects);

        // If there are no matching subjects, hide the list
        if (filteredSubjects.length === 0) {
            subjectList.style.display = 'none';
        } else {
            subjectList.style.display = 'block';
        }
    }

    // Create a list of suggestions
    function createSuggestionsList(subjectList, filteredSubjects) {
        filteredSubjects.forEach(subject => {
            const item = document.createElement('a');
            item.classList.add('list-group-item', 'list-group-item-action');
            item.href = '#';
            item.textContent = `${subject.subject_code} - ${subject.subject_name}`;
            item.onclick = () => {
                // Fill the form with the selected subject
                document.getElementById('class-subject-code').value = subject.subject_code;
                document.getElementById('class-name').value = subject.subject_name;
                subjectList.innerHTML = '';

                // Then clear all the formfields below it
                document.getElementById('class-category').innerHTML = '<option selected disabled value="">Choose...</option>';
                document.getElementById('class-section').value = '';
                document.getElementById('class-lecturer').value = '';
                document.getElementById('class-location').value = '';
                // THE FIELDS BELOW THROW ERRORS
                // document.getElementById('class-day').value = '';
                // document.getElementById('class-start-time').value = '';
                // document.getElementById('class-end-time').value = '';
     
                // Call the webservice to retrive the timetable slot data
                callSubjectDetailsFetcher(subject);
            };
            subjectList.appendChild(item);
        });
    }

    function callSubjectDetailsFetcher(subject) {
        // Call the subject_details_fetcher Python webservice with subject.href
        fetch(`/timetable-builder/get-subject-details-list?source_link=${encodeURIComponent(subject.href)}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log("(PASS) Response received from webservice");

            // Populate class category select with unique occurences
            const classCategorySelect = document.getElementById('class-category');
            classCategorySelect.innerHTML = '<option selected disabled value="">Choose...</option>';
            const uniqueCategories = [...new Set(data.subjectDetailsList.map(slot => slot.class_category))];
            uniqueCategories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                switch(category) {
                    case 'lecture': option.textContent = 'Lecture'; break;
                    case 'labprac': option.textContent ='Lab/Practical'; break;
                    case 'tutorial': option.textContent = 'Tutorial'; break;
                    case 'cocurricular': option.textContent = 'Co-curricular'; break;
                }
                classCategorySelect.appendChild(option);
            });

            // Set up event listener for when a category is selected
            classCategorySelect.addEventListener('change', function() {
                // Clear all the formfields below it first
                document.getElementById('class-section').value = '';
                document.getElementById('class-lecturer').value = '';
                document.getElementById('class-location').value = '';
                // THE FIELDS BELOW THROW ERRORS
                // document.getElementById('class-day').value = '';
                // document.getElementById('class-start-time').value = '';
                // document.getElementById('class-end-time').value = '';

                const selectedCategory = this.value;
                
                // Modify class-section to a <select> and populate with available sections
                const classSectionSelect = document.createElement('select');
                classSectionSelect.id = 'class-section';
                classSectionSelect.name = 'class_section';
                classSectionSelect.classList.add('form-select');
                classSectionSelect.required = true;

                const filteredSlots = data.subjectDetailsList.filter(slot => slot.class_category === selectedCategory);

                // Populate the select element with both section and time information
                classSectionSelect.innerHTML = '<option selected disabled value="">Choose...</option>';
                filteredSlots.forEach((slot, index) => {
                    const option = document.createElement('option');
                    option.value = slot.class_section;
                    option.id = `slot-${index}`;
                    option.textContent = `Section ${slot.class_section} (${dayToString(slot.class_day)}, ${convertToAMPM(slot.class_start_time)} - ${convertToAMPM(slot.class_end_time)})`;
                    classSectionSelect.appendChild(option);

                    // Store slot information in a data attribute for easy retrieval
                    option.dataset.startTime = slot.class_start_time;
                    option.dataset.endTime = slot.class_end_time;
                    option.dataset.lecturer = slot.class_lecturer;
                    option.dataset.location = slot.class_location;
                    option.dataset.day = slot.class_day;
                });

                // Replace input field with select field
                const classSectionInput = document.getElementById('class-section');
                classSectionInput.replaceWith(classSectionSelect);

                // Add event listener for section selection
                classSectionSelect.addEventListener('change', function() {
                    const selectedOption = classSectionSelect.options[classSectionSelect.selectedIndex];  // Get the selected option

                    // Use the data attributes to fill in the remaining fields
                    document.getElementById('class-lecturer').value = selectedOption.dataset.lecturer;
                    document.getElementById('class-location').value = selectedOption.dataset.location;
                    document.getElementById('day').value = dayToString(selectedOption.dataset.day);
                    document.getElementById('start-time').value = selectedOption.dataset.startTime;
                    document.getElementById('end-time').value = selectedOption.dataset.endTime;
                });
            });
        })
        .catch(error => {
            console.error("(FAIL) AJAX request to webservice failed:", error);
        });
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
            const classDay = dayToInt(formData.get('class_day'));
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
