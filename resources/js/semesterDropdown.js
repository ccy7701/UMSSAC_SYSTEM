document.addEventListener('DOMContentLoaded', function () {
    const semesterDropdown = document.getElementById('select-semester');
    const addButton = document.getElementById('add-subject-button');

    function checkSemesterSelection() {
        const selectedSemester = semesterDropdown.value;
        if (selectedSemester) {
            addButton.disabled = false;
        } else {
            addButton.disabled = true;
        }
    }

    semesterDropdown.addEventListener('change', checkSemesterSelection);
});
