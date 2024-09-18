document.addEventListener('DOMContentLoaded', function () {
    // Fetch timetable data on page load
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
        } else {
            console.error('Failed to load timetable');
        }
    })
    .catch(error => console.error('Error:', error));
});

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

function getClassIfExists(timetableSlots, day, hour) {
    for (const slot of timetableSlots) {
        const classDay = slot.class_day;
        const startHour = parseInt(slot.class_start_time.split(':')[0], 10);
        const endHour = parseInt(slot.class_end_time.split(':')[0], 10);
        const colspan = endHour - startHour;

        if (classDay == day && startHour == hour) {
            return {
                colspan: colspan,
                // class_name: slot.class_name,
                class_subject_code: slot.class_subject_code,
                class_location: slot.class_location,
                class_category: slot.class_category,
            };
        }
    }
    return null; // No class found
}
