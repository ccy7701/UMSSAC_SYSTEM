import {updateCGPAandSGPA, updateSubjectList} from './helperFunctions.js';
import './addSubject.js';
import './semesterDropdown.js';
import './semIdValidator.js';

// SEMESTER AND SUBJECTS DISPLAY OPERATIONS

document.addEventListener('DOMContentLoaded', function() {
    const enrolmentSessionField = document.getElementById('select-enrolment-session');
    const courseDurationField = document.getElementById('select-course-duration');
    const btnPassForm = document.getElementById('btn-pass-form');
    const hiddenEnrolmentSessionField = document.getElementById('received_profile_enrolment_sesion');
    const hiddenCourseDurationField = document.getElementById('received_course_duration');

    function checkFieldsFilled() {
        if (enrolmentSessionField.value !== "" && courseDurationField.value !== "") {
            btnPassForm.removeAttribute('disabled'); // Enable the button
        } else {
            btnPassForm.setAttribute('disabled', 'disabled'); // Keep it disabled
        }
    }

    enrolmentSessionField.addEventListener('change', checkFieldsFilled);
    courseDurationField.addEventListener('change', checkFieldsFilled);

    // Handle the click of the "Confirm" button
    btnPassForm.addEventListener('click', function (event) {
        // Prevent default form submission
        event.preventDefault();
            
        // Transfer the values from the form to the hidden fields
        hiddenEnrolmentSessionField.value = enrolmentSessionField.value;
        hiddenCourseDurationField.value = courseDurationField.value;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const selectSemester = document.getElementById('select-semester');
    const semesterTitle = document.getElementById('semester-results-title');

    if (selectSemester) {
        selectSemester.addEventListener('change', function () {
            const semProgLogId = this.value;
            if (semProgLogId) {
                const url = window.fetchBySemProgLogIdRoute
                    .replace(':sem_prog_log_id', semProgLogId);

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update the semester title with the selected semester
                        semesterTitle.textContent = `S${data.semester}-${data.academic_session} results at a glance`;

                        // Update CGPA value in the view
                        const cgpa = data.cgpa ? data.cgpa.toFixed(2) : '0.00';
                        document.querySelector('#cgpa-value').textContent = cgpa;

                        // Update SGPA values in the view
                        const sgpa = data.sgpa ? data.sgpa.toFixed(2) : '0.00';
                        document.querySelector('#sgpa-value').textContent = sgpa;

                        // Update CGPA message and color based on the value
                        updateCGPAandSGPA(data.cgpa, data.sgpa);

                        // Handle subject list and populate table
                        const subjects = data.subjects || [];
                        updateSubjectList(subjects);
                    })
                    .catch(error => console.error('Error fetching subject stats:', error));
            }
        });
    }
});

// EDIT SUBJECT MODAL AND FORM OPERATIONS

const editModalElement = document.getElementById('edit-subject-modal');
const editModal = new bootstrap.Modal(editModalElement);
const editSubjectForm = document.getElementById('edit-subject-form');

window.editSubject = function(sem_prog_log_id, subject_code) {
    const subjectDataRoute = window.getSubjectDataRouteTemplate
        .replace(':sem_prog_log_id', sem_prog_log_id)
        .replace(':subject_code', subject_code);

    fetch(subjectDataRoute)
        .then(response => response.json())
        .then(data => {
            // Populate modal form fields with fetched data
            document.getElementById('edit-subject-code').value = data.subject_code;
            document.getElementById('edit-subject-code-readonly').value = data.subject_code;
            document.getElementById('edit-subject-name').value = data.subject_name;
            document.getElementById('edit-subject-credit-hours').value = data.subject_credit_hours;
            document.getElementById('edit-subject-grade').value = data.subject_grade;
            document.getElementById('edit-selected-semester').value = sem_prog_log_id;

            // Dynamically update the form action to point to the update route
            const formAction = window.editSubjectRouteTemplate
                .replace(':sem_prog_log_id', sem_prog_log_id)
                .replace(':subject_code', subject_code);

            document.getElementById('edit-subject-form').action = formAction;

            // Open the modal
            editModal.show();
        })
        .catch(error => console.error('Error fetching subject data:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    // Handle Edit Subject form submission via AJAX
    if (editSubjectForm) {
        editSubjectForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
            const formData = new FormData(editSubjectForm);  // Gather form data
            const formAction = editSubjectForm.action; // The action attribute of the form contains the URL for the edit operation

            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Add CSRF token
                },
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
                    editModal.hide();
                    document.getElementById('edit-subject-form').reset();

                    // Update CGPA and SGPA and subject list
                    updateCGPAandSGPA(data.cgpa, data.sgpa);
                    updateSubjectList(data.subjects); // Re-fetch and update the subject list dynamically
                } else {
                    alert('Failed to update the subject. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});

// DELETE SUBJECT MODAL AND FORM OPERATIONS

const deleteConfirmationModalElement = document.getElementById('delete-confirmation-modal');
const deleteConfirmationModal = new bootstrap.Modal(deleteConfirmationModalElement);
const deleteSubjectForm = document.getElementById('delete-subject-form');

// Update the form fields every time the modal is shown
deleteConfirmationModalElement.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const semProgLogId = button.getAttribute('data-sem-prog-log-id');
    const subjectCode = button.getAttribute('data-subject-code');

    // Populate the form fields with the new data
    document.getElementById('sem-prog-log-id').value = semProgLogId;
    document.getElementById('subject-code').value = subjectCode;

    // Update the form action URL dynamically
    const deleteRoute = window.deleteRouteTemplate
        .replace(':sem_prog_log_id', semProgLogId)
        .replace(':subject_code', subjectCode);

    deleteSubjectForm.action = deleteRoute;
});

// Reset the form when the modal is hidden to avoid stale data
deleteConfirmationModalElement.addEventListener('hidden.bs.modal', function () {
    deleteSubjectForm.reset(); // Clear the form fields
    deleteSubjectForm.action = ''; // Reset the form action URL
});

document.addEventListener('DOMContentLoaded', function () {
    deleteSubjectForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(deleteSubjectForm);
        const formAction = deleteSubjectForm.action;

        fetch(formAction, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
                deleteConfirmationModal.hide();
                deleteSubjectForm.reset();
                updateCGPAandSGPA(data.cgpa, data.sgpa);
                updateSubjectList(data.subjects);
            } else {
                alert('Failed to delete the subject. Please try again.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
