document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role-select');
    const matricNumberField = document.querySelector('input[name="account_matric_number"]');
    
    if (roleSelect && matricNumberField) { // Check if elements exist
        const matricNumberFormGroup = matricNumberField.closest('.mb-3');

        function toggleMatricNumberField() {
            if (roleSelect.value === '1') {
                matricNumberFormGroup.style.display = 'block';
                matricNumberField.required = true;
            } else {
                matricNumberFormGroup.style.display = 'none';
                matricNumberField.required = false;
                matricNumberField.value = ''; // Clear the field if hidden
            }
        }

        // Hide the matric number field initially
        matricNumberFormGroup.style.display = 'none';

        // Add event listener to role select
        roleSelect.addEventListener('change', toggleMatricNumberField);
    }
});
