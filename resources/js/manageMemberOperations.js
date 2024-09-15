document.addEventListener('DOMContentLoaded', function() {
    // Select all membership select elements
    document.querySelectorAll('select[name="new_membership_type"]').forEach(function(selectElement) {
        const profileId = selectElement.id.split('-').pop(); // Extract profile_id from the ID
        const saveButton = document.getElementById('edit-access-level-submit-' + profileId); // Get the corresponding save button
        const currentRole = selectElement.getAttribute('data-current-role'); // Get current role from data attribute

        // Disable the save button initially
        saveButton.disabled = true;

        // Enable the save button only if the role is changed
        selectElement.addEventListener('change', function() {
            const selectedRole = selectElement.value;

            // Enable the save button if the selected role is different from the current one
            if (selectedRole !== currentRole) {
                saveButton.disabled = false;
            } else {
                saveButton.disabled = true;
            }
        });
    });

    // Attach event listener to all save buttons
    document.querySelectorAll('[id^="edit-access-level-submit-"]').forEach(function(button) {
        button.addEventListener('click', function() {
            const profileId = this.getAttribute('data-profile-id'); // Get the profile_id from the button's data attribute
            const selectElement = document.querySelector(`#membership-select-${profileId}`); // Find the corresponding select element
            const selectedRole = selectElement.value; // Get the selected membership type

            // Fill the hidden form fields in the modal
            const form = document.getElementById('edit-access-level-form');
            form.querySelector('input[name="profile_id"]').value = profileId;
            form.querySelector('input[name="new_membership_type"]').value = selectedRole;
        });
    });
});

function confirmRoleChange(button) {
    const formElement = button.closest('form');
    const selectElement = formElement.querySelector('select[name="membership_type"]');
    const currentRole = selectElement.getAttribute('data-current-role');
    const selectedRole = selectElement.value;

    // Confirm role change if the roles differ
    if (selectedRole === '1' && currentRole !== '1') {
        return confirm('Are you sure you want to change this user to Member?');
    } else if (selectedRole === '2' && currentRole !== '2') {
        return confirm('Are you sure you want to change this user to Committee?');
    }
    return true;
}
