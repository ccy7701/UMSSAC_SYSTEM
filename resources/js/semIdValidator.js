document.addEventListener('DOMContentLoaded', function() {
    function handleSubjectForm(formId) {
        const form = document.getElementById(formId);

        if (form) {
            form.addEventListener('submit', function(event) {
                const selectedSemesterID = document.getElementById('select-semester').value;

                if (!selectedSemesterID) {
                    alert('Please select a semester.');
                    event.preventDefault();  // Stop form submission if no semester is selected
                    return;
                }

                // Set the hidden semester ID field
                document.getElementById('selected-semester').value = selectedSemesterID;
            });
        }
    }

    // Apply the function to the form(s)
    handleSubjectForm('add-subject-form');
    handleSubjectForm('edit-subject-form');
})