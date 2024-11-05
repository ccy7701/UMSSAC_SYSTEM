import {checkForDuplicate, updateCGPAandSGPA, updateSubjectList} from './helperFunctions.js';

// ADD SUBJECT MODAL AND FORM OPERATIONS

const addModalElement = document.getElementById('add-subject-modal');
const addModal = new bootstrap.Modal(addModalElement);
const addSubjectForm = document.getElementById('add-subject-form');

document.addEventListener('DOMContentLoaded', function () {
    const duplicateEntryModal = new bootstrap.Modal(document.getElementById('duplicate-entry-modal'));

    // Handle Add Subject form submission via AJAX
    if (addSubjectForm) {
        addSubjectForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
            const formData = new FormData(addSubjectForm);
            const semProgLogId = formData.get('sem_prog_log_id');
            const subjectCode = formData.get('subject_code');

            // Fetch existing subject_stats_logs for the selected sem_prog_log_id
            const fetchBySemProgLogIdRoute = window.fetchBySemProgLogIdRoute
                .replace(':sem_prog_log_id', semProgLogId);

            // First check if a row with the subject code passed from the form already exists
            fetch(fetchBySemProgLogIdRoute)
                .then(response => response.json())
                .then(subjectStatsLogs => {
                    const subjects = subjectStatsLogs.subjects
                    if (checkForDuplicate(subjectCode, subjects)) {
                        // If a duplicate is detected, show the error modal
                        addModal.hide();
                        duplicateEntryModal.show();

                        // After the error modal is closed, show the add modal again
                        const duplicateEntryModalElement = document.getElementById('duplicate-entry-modal');
                        duplicateEntryModalElement.addEventListener('hidden.bs.modal', function () {
                            addModal.show();
                        }, { once: true });

                        return;
                    } else {
                        // If no duplicate, proceed to submit the form to the server
                        fetch(addSubjectForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Add CSRF token
                            },
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json(); // Attempt to parse JSON
                        })
                        .then(data => {
                            if (data.success) {
                                // Close the modal after success
                                addModal.hide();
                                document.getElementById('add-subject-form').reset();
            
                                // Update CGPA and SGPA and subject list
                                updateCGPAandSGPA(data.cgpa, data.sgpa);
                                updateSubjectList(data.subjects);
                            } else {
                                alert('Failed to add the subject. Please try again.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
        })
    }
});
