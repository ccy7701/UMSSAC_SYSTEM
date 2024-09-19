// SEMESTER AND SUBJECTS DISPLAY OPERATIONS

document.addEventListener('DOMContentLoaded', function() {
    const initialiserForm = document.getElementById('initialiser-form');

    if (initialiserForm) {
        initialiserForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately
            if (confirm("Confirm if the details are correct before submission. They cannot be changed afterwards.")) {
                this.submit(); // Submit the form if confirmed
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const selectSemester = document.getElementById('select-semester');
    const semesterTitle = document.getElementById('semester-results-title');

    if (selectSemester) {
        selectSemester.addEventListener('change', function () {
            const semProgLogId = this.value;
            console.log('semProgLogId = ', semProgLogId);
            if (semProgLogId) {
                const url = `${window.fetchSubjectStatsRoute}/${semProgLogId}`;
                console.log('Fetching data from:', url);

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

// ADD SUBJECT MODAL AND FORM OPERATIONS

const addModalElement = document.getElementById('add-subject-modal');
const addModal = new bootstrap.Modal(addModalElement);
const addSubjectForm = document.getElementById('add-subject-form');

document.addEventListener('DOMContentLoaded', function () {
    // Handle Add Subject form submission via AJAX
    if (addSubjectForm) {
        addSubjectForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
            const formData = new FormData(addSubjectForm);  // Gather form data
            
            fetch(addSubjectForm.action, {
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
                    console.log('New subject added successfully!');

                    // Close the modal after success
                    console.log(addModal);
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
        })
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
            document.getElementById('edit-subject-name').value = data.subject_name;
            document.getElementById('edit-subject-credit-hours').value = data.subject_credit_hours;
            document.getElementById('edit-subject-grade').value = data.subject_grade;
            document.getElementById('edit-selected-semester').value = sem_prog_log_id;

            // Dynamically update the form action to point to the update route
            const formAction = window.editSubjectRouteTemplate
                .replace(':sem_prog_log_id', sem_prog_log_id)
                .replace(':subject_code', subject_code);

            console.log("NEW_FORM_ACTION:", formAction);

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
                    console.log('Subject updated successfully!');

                    // Close the modal after success
                    console.log('Model instance:', editModal);
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
const deleteConfirmationModal = new bootstrap.Modal(deleteConfirmationModalElement);const deleteSubjectForm = document.getElementById('delete-subject-form');

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

    console.log("Delete Route:", deleteRoute); // Debugging
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
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
                console.log('Subject deleted successfully.');
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

// HELPER FUNCTIONS

// Helper function to update CGPA and SGPA dynamically
function updateCGPAandSGPA(cgpa, sgpa) {
    // Update CGPA in the view
    const cgpaValue = cgpa ? cgpa.toFixed(2) : '0.00';
    document.querySelector('#cgpa-value').textContent = cgpaValue;

    // Update SGPA in the view
    const sgpaValue = sgpa ? (Math.round(sgpa * 100) / 100).toFixed(2) : '0.00';
    document.querySelector('#sgpa-value').textContent = sgpaValue;

    // Update CGPA message and color based on the value
    const cgpaMessageElement = document.querySelector('#cgpa-message');
    if (cgpa >= 3.67) {
        cgpaMessageElement.textContent = 'On track to first class';
        cgpaMessageElement.style.color = '#15AA07';
    } else if (cgpa >= 2.00 && cgpa < 3.67) {
        cgpaMessageElement.textContent = 'You\'re on the right path!';
        cgpaMessageElement.style.color = '#B4C75C';
    } else if (cgpa < 2.00 && cgpa > 0.00) {
        cgpaMessageElement.textContent = 'Needs improvement';
        cgpaMessageElement.style.color = '#FF0000';
    } else {
        cgpaMessageElement.textContent = 'No data available';
        cgpaMessageElement.style.color = '#BBBBBB';
    }

    // Update SGPA message and color based on the value
    const sgpaMessageElement = document.querySelector('#sgpa-message');
    if (sgpa >= 3.50) {
        sgpaMessageElement.textContent = 'On track to dean\'s list';
        sgpaMessageElement.style.color = '#15AA07';
    } else if (sgpa >= 2.00 && sgpa < 3.50) {
        sgpaMessageElement.textContent = 'Good effort, keep pushing!';
        sgpaMessageElement.style.color = '#B4C75C';
    } else if (sgpa < 2.00 && sgpa > 0.00) {
        sgpaMessageElement.textContent = 'Needs improvement';
        sgpaMessageElement.style.color = '#FF0000';
    } 
    else {
        sgpaMessageElement.textContent = 'No data available';
        sgpaMessageElement.style.color = '#BBBBBB';
    }
}

// Helper function to generate the subject list dynamically
function generateSubjectListRow(subject, row, tableBody) {
    row.className = 'text-left align-middle';
    row.innerHTML = `
        <td>${subject.subject_code}</td>
        <td>${subject.subject_name}</td>
        <td>${subject.subject_credit_hours}</td>
        <td>${subject.subject_grade}</td>
        <td>${subject.subject_grade_point.toFixed(2)}</td>
        <td style="width: 1%;">
            <div class="dropdown">
                <button class="subject-row btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton${subject.subject_code}" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton${subject.subject_code}">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="editSubject(${subject.sem_prog_log_id}, '${subject.subject_code}')" data-bs-target="#editSubjectModal">Edit</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="text-danger dropdown-item"
                            data-bs-toggle="modal"
                            data-bs-target="#delete-confirmation-modal"
                            data-sem-prog-log-id="${subject.sem_prog_log_id}"
                            data-subject-code="${subject.subject_code}">Delete</a>
                    </li>
                </ul>
            </div>
        </td>
    `;
    tableBody.appendChild(row);
}

// Helper function to update the subject list dynamically
function updateSubjectList(subjects) {
    const tableBody = document.getElementById('subjects-taken-table-body');
    tableBody.innerHTML = ''; // Clear previous data

    if (subjects.length > 0) {
        subjects.forEach(subject => {
            const row = document.createElement('tr');
            generateSubjectListRow(subject, row, tableBody);
        });
    } else {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="6">No subjects added yet</td>`;
        tableBody.appendChild(row);
    }
}
