import {isValidSubjectCode, dayToString, dayToInt, timeToAMPM, timeTo24Hour, checkForClash, generateTimetable, updateSubjectList} from './helperFunctions.js';

// ADD TIMETABLE SLOT MODAL AND FORM OPERATIONS

document.addEventListener('DOMContentLoaded', function () {
    const addTimetableSlotAutoElement = document.getElementById('add-ttslot-auto');
    const addTimetableSlotAuto = new bootstrap.Modal(addTimetableSlotAutoElement);
    const addTimetableSlotAutoForm = document.getElementById('add-ttslot-auto-form');
    
    const addTimetableSlotManualElement = document.getElementById('add-ttslot-manual');
    const addTimetableSlotManual = new bootstrap.Modal(addTimetableSlotManualElement);
    const addTimetableSlotManualForm = document.getElementById('add-ttslot-manual-form');

    const timetableClashModalAdd = new bootstrap.Modal(document.getElementById('timetable-clash-modal-add'));
    const timeErrorModalAdd = new bootstrap.Modal(document.getElementById('time-error-modal-add'));

    const invalidSubjectCodeModal = new bootstrap.Modal(document.getElementById('invalid-subject-code-modal'));

    // Initialise the all subjects list
    let subjects = [];

    fetch('/resources/data/all_subjects_data.json')
        .then(response => response.json())
        .then(data => {
            subjects = data;
        });

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

    // Create a list of suggested subjects based on input
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
                document.getElementById('class-day').value = '';
                document.getElementById('class-start-time').value = '';
                document.getElementById('class-end-time').value = '';
     
                // Call the webservice to retrive the timetable slot data
                callSubjectDetailsFetcher(subject);
            };
            subjectList.appendChild(item);
        });
    }

    // Call the subject_details_fetcher Python webservice with subject.href
    async function callSubjectDetailsFetcher(subject) {
        const classCategorySelect = document.getElementById('class-category');
        let subjectData = null;

        try {
            const response = await fetch(`/timetable-builder/get-subject-details-list?source_link=${encodeURIComponent(subject.href)}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            });

            subjectData = await response.json();
            console.log("(PASS) Response received from webservice");
        } catch (error) {
            console.error("(FAIL) AJAX request to webservice failed:", error);
        }

        // Populate class category select with unique occurences
        classCategorySelect.innerHTML = '<option selected disabled value="">Choose...</option>';
        const uniqueCategories = [...new Set(subjectData.subjectDetailsList.map(slot => slot.class_category))];
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
            document.getElementById('class-day').value = '';
            document.getElementById('class-start-time').value = '';
            document.getElementById('class-end-time').value = '';

            const selectedCategory = this.value;
            
            // Modify class-section to a <select> and populate with available sections
            const classSectionSelect = document.createElement('select');
            classSectionSelect.id = 'class-section';
            classSectionSelect.name = 'class_section';
            classSectionSelect.classList.add('form-select');
            classSectionSelect.required = true;

            const filteredSlots = subjectData.subjectDetailsList.filter(slot => slot.class_category === selectedCategory);

            // Populate the select element with both section and time information
            classSectionSelect.innerHTML = '<option selected disabled value="">Choose...</option>';
            filteredSlots.forEach((slot, index) => {
                const option = document.createElement('option');
                option.value = slot.class_section;
                option.id = `slot-${index}`;
                option.textContent = `Section ${slot.class_section} (${dayToString(slot.class_day)}, ${timeToAMPM(slot.class_start_time)} - ${timeToAMPM(slot.class_end_time)})`;
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
                document.getElementById('class-day').value = dayToString(selectedOption.dataset.day);
                document.getElementById('class-start-time').value = timeToAMPM(selectedOption.dataset.startTime);
                document.getElementById('class-end-time').value = timeToAMPM(selectedOption.dataset.endTime);
            });
        });
    }

    // Add event listener for filtering subjects in the modal form
    const subjectCodeInput = document.getElementById('class-subject-code');
    if (subjectCodeInput) {
        subjectCodeInput.addEventListener('input', filterSubjects);
    }

    if (addTimetableSlotAutoForm) {
        addTimetableSlotAutoForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(addTimetableSlotAutoForm);
            const profileId = formData.get('profile_id');
            const classDay = dayToInt(formData.get('class_day'));
            const classStartTime = timeTo24Hour(formData.get('class_start_time'));
            const classEndTime = timeTo24Hour(formData.get('class_end_time'));

            // Fetch existng timetable slots for the selected day and profile
            const getSlotsByDayRouteTemplate = window.getSlotsByDayRouteTemplate
                .replace(':class_day', classDay)
                .replace(':profile_id', profileId);

            // First check if the end time is earlier than the start time
            if (classEndTime <= classStartTime) {
                addTimetableSlotAuto.hide();
                timeErrorModalAdd.show();

                // After the error modal is closed, show the add timetable modal again
                const timeErrorModalElement = document.getElementById('time-error-modal-add');
                timeErrorModalElement.addEventListener('hidden.bs.modal', function () {
                    addTimetableSlotAuto.show();
                }, { once: true });

                return;
            }
            // If it is not, then proceed
            fetch(getSlotsByDayRouteTemplate)
                .then(response => response.json())
                .then(existingSlots => {
                    if (checkForClash(classStartTime, classEndTime, existingSlots)) {
                        // If a clash is detected, show the timetable clash error modal
                        addTimetableSlotAuto.hide();
                        timetableClashModalAdd.show();

                        // After the clash modal is closed, show the add timetable modal again
                        const timetableClashModalElement = document.getElementById('timetable-clash-modal-add');
                        timetableClashModalElement.addEventListener('hidden.bs.modal', function () {
                            addTimetableSlotAuto.show();
                        }, { once: true });
                    } else {
                        // If no clash, first parse the start time and end time to the required format
                        formData.set('class_start_time', timeTo24Hour(formData.get('class_start_time')));
                        formData.set('class_end_time', timeTo24Hour(formData.get('class_end_time')));
                          
                        // Then, proceed to submit the form to the server
                        fetch(addTimetableSlotAutoForm.action, {
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
                                // Close the modal after success
                                addTimetableSlotAuto.hide();
                                document.getElementById('add-ttslot-auto-form').reset();
            
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
    
    if (addTimetableSlotManualForm) {
        addTimetableSlotManualForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(addTimetableSlotManualForm);
            const classSubjectCode = formData.get('class_subject_code');
            const profileId = formData.get('profile_id');
            const classDay = formData.get('class_day');
            const classStartTime = formData.get('class_start_time');
            const classEndTime = formData.get('class_end_time');

            // Fetch existng timetable slots for the selected day and profile
            const getSlotsByDayRouteTemplate = window.getSlotsByDayRouteTemplate
                .replace(':class_day', classDay)
                .replace(':profile_id', profileId);

            // First check if the subject code fits requirement
            if (!isValidSubjectCode(classSubjectCode)) {
                addTimetableSlotManual.hide();
                invalidSubjectCodeModal.show();

                const invalidSubjectCodeModalElement = document.getElementById('invalid-subject-code-modal');
                invalidSubjectCodeModalElement.addEventListener('hidden.bs.modal', function() {
                    addTimetableSlotManual.show();
                }, { once: true });

                return;
            }
            // Then check if the end time is earlier than the start time
            if (classEndTime <= classStartTime) {
                addTimetableSlotManual.hide();
                timeErrorModalAdd.show();

                // After the error modal is closed, show the add timetable modal again
                const timeErrorModalElement = document.getElementById('time-error-modal-add');
                timeErrorModalElement.addEventListener('hidden.bs.modal', function () {
                    addTimetableSlotManual.show();
                }, { once: true });

                return;
            }
            // If it is not, then proceed
            fetch(getSlotsByDayRouteTemplate)
                .then(response => response.json())
                .then(existingSlots => {
                    if (checkForClash(classStartTime, classEndTime, existingSlots)) {
                        // If a clash is detected, show the timetable clash error modal
                        addTimetableSlotManual.hide();
                        timetableClashModalAdd.show();

                        // After the clash modal is closed, show the add timetable modal again
                        const timetableClashModalElement = document.getElementById('timetable-clash-modal-add');
                        timetableClashModalElement.addEventListener('hidden.bs.modal', function () {
                            addTimetableSlotManual.show();
                        }, { once: true });
                    } else {
                        // If no clash, proceed to submit the form to the server
                        fetch(addTimetableSlotManualForm.action, {
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
                                // Close the modal after success
                                addTimetableSlotManual.hide();
                                document.getElementById('add-ttslot-manual-form').reset();
            
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
