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
            const profileId = this.getAttribute('data-profile-id');
            const selectElement = document.querySelector(`#membership-select-standard-${profileId}, #membership-select-${profileId}`);
            const selectedRole = selectElement.value;
            const memberName = selectElement.closest('.card-body').querySelector('p.fw-bold').innerText;

            // Fill the hidden form fields in the modal
            const form = document.getElementById('edit-access-level-form');
            form.querySelector('input[name="profile_id"]').value = profileId;
            form.querySelector('input[name="new_membership_type"]').value = selectedRole;

            // Update modal content dynamically
            const modalBodyText = `Are you sure you want to change access level for ${memberName}?`;
            document.querySelector('#edit-confirmation-modal .modal-body').innerText = modalBodyText;
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
