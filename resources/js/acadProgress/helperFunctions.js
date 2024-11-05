// Helper function to check if inputted subject code fits requirement
export function isValidSubjectCode(subjectCode) {
    const regex = /^[A-Za-z]{2}\d{5}$/;
    return regex.test(subjectCode);
}

// Helper function to check for duplicate on add/edit form submission
export function checkForDuplicate(subjectCode, subjectStatsLogs, currentSubjectCode = null) {
    for (const log of subjectStatsLogs) {
        // If editing, skip checcking the current subject_code itself
        if (currentSubjectCode && log.subject_code === currentSubjectCode) {
            continue;
        }
        // Check for duplicates
        if (subjectCode === log.subject_code) {
            return true;
        }
    }
    return false;
}

// Helper function to update CGPA and SGPA dynamically
export function updateCGPAandSGPA(cgpa, sgpa) {
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
export function generateSubjectListRow(subject, row, tableBody) {
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
export function updateSubjectList(subjects) {
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
