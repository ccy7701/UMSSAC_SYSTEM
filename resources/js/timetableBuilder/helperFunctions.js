import html2pdf from 'html2pdf.js';

// HELPER FUNCTIONS

// Helper function to get string of day of the week
export function dayToString(day) {
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    return daysOfWeek[day - 1];
}

export function dayToInt(day) {
    switch(day) {
        case 'Monday': return 1;
        case 'Tuesday': return 2;
        case 'Wednesday': return 3;
        case 'Thursday': return 4;
        case 'Friday': return 5;
        case 'Saturday': return 6;
        case 'Sunday': return 7;
    }
}

// Helper function to convert to AM/PM format
export function convertToAMPM(time) {
    let hours = time.split(':');
    hours = parseInt(hours, 10);
    const am_pm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    return `${hours} ${am_pm}`;
}

// Helper function to handle generation on timeslots with existing classes
export function getClassIfExists(timetableSlots, day, hour) {
    for (const slot of timetableSlots) {
        const classDay = slot.class_day;
        const startHour = parseInt(slot.class_start_time.split(':')[0], 10);
        const endHour = parseInt(slot.class_end_time.split(':')[0], 10);
        const colspan = endHour - startHour;

        if (classDay == day && startHour == hour) {
            return {
                colspan: colspan,
                class_subject_code: slot.class_subject_code,
                class_name: slot.class_name,
                class_location: slot.class_location,
                class_category: slot.class_category,
                class_section: slot.class_section,
            };
        }
    }
    return null;
}

// Helper function to check for timetable timeslot clashes
export function checkForClash(newStartTime, newEndTime, existingSlots) {
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
export function generateTimetable(timetableSlots) {
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

                // Determine the class category to output in the bootstrap popover
                let class_category_and_section = "";
                switch(classData.class_category) {
                    case 'cocurricular': class_category_and_section = `Cocurricular Section ${classData.class_section}`; break;
                    case 'lecture': class_category_and_section = `Lecture Section ${classData.class_section}`; break;
                    case 'labprac': class_category_and_section = `Lab/Practical Group ${classData.class_section}`; break;
                    case 'tutorial': class_category_and_section = `Tutorial Group ${classData.class_section}`; break;
                }

                // Add bootstrap popover attributes
                classCell.setAttribute('data-bs-toggle', 'popover');
                classCell.setAttribute('data-bs-trigger', 'hover');
                classCell.setAttribute('data-bs-content', `
                    <strong>${classData.class_subject_code}</strong><br>
                    ${classData.class_name}<br>
                    ${class_category_and_section}<br>
                    <i class="fas fa-map-marker-alt me-1"></i> ${classData.class_location}
                `);
                classCell.setAttribute('data-bs-html', 'true');
    
                // Add class based on the category
                switch (classData.class_category) {
                    case 'lecture':
                        classCell.classList.add('filled-slot', 'bg-primary', 'text-white');
                        break;
                    case 'labprac':
                        classCell.classList.add('filled-slot', 'bg-warning', 'text-dark');
                        break;
                    case 'tutorial':
                        classCell.classList.add('filled-slot', 'bg-info', 'text-white');
                        break;
                    case 'cocurricular':
                        classCell.classList.add('filled-slot', 'bg-success', 'text-white');
                        break;
                    default:
                        classCell.classList.add('filled-slot', 'bg-secondary', 'text-white'); // Default category style
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

    // Initialise all Bootstrap popovers, after the DOM elements have been created
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.forEach(function (popoverTriggerEl) {
        let popover = new bootstrap.Popover(popoverTriggerEl);
        console.log("Popover:", popover);
    });
}

// Helper function to update the subject list dynamically
export function updateSubjectList(timetableSlots) {
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

// Helper function to download the timetable
export function downloadTimetable() {
    document.getElementById('download-timetable').addEventListener('click', function () {
        const timetableCore = document.getElementById('timetable-core').cloneNode(true);
        const timetableSubjectsList = document.getElementById('timetable-subjects-list').cloneNode(true);

        // Create a temporary container for combining both elements
        const tempContainer = document.createElement('div');

        // Append a style tag for PDF-specific styles
        const style = document.createElement('style');
        style.textContent = `
            .text-white {
                color: black !important;
            }
            #add-subject-button {
                display: none;
            }
            #timetable-core {
                margin-bottom: 20px;
            }
            .dropdown {
                display: none !important;
            }
        `;

        // Append the styles and both timetable sections to the temp container
        tempContainer.appendChild(style);
        tempContainer.appendChild(timetableCore);
        tempContainer.appendChild(timetableSubjectsList);
        
        // Ensure html2pdf.js is correctly called
        html2pdf()
            .from(tempContainer)
            .set({
                margin: 20,
                filename: 'umssacs_timetable.pdf',
                html2canvas: {
                    scale: 2,
                    logging: true
                },
                jsPDF: {
                    orientation: 'landscape',
                    unit: 'pt',
                    format: [1123, 794]
                }
            })
            .toPdf()
            .get('pdf')
            .then(function (pdf) {
                // Reduce the page to one page (scale down the content)
                const totalPages = pdf.internal.getNumberOfPages();
                for (let i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    pdf.setFontSize(8);
                }
            })
            .save();
    });
}
