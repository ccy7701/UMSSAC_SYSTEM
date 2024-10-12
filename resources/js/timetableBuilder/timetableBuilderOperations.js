import {generateTimetable, updateSubjectList, downloadTimetable} from './helperFunctions.js';
import './addTimetableSlot.js';
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
