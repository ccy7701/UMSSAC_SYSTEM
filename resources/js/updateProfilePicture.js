// For edit profile picture page; disabling the button until input field is not empty
document.addEventListener('DOMContentLoaded', function () {
    const newProfilePictureInput = document.getElementById('profile-picture-input');
    const saveButton = document.querySelector('.section-button-short');
    const saveButtonCompact = document.getElementById('submit-compact');

    saveButton.disabled = true;
    saveButtonCompact.disabled = true;

    newProfilePictureInput.addEventListener('change', function () {
        if (newProfilePictureInput.files.length > 0) {
            saveButton.disabled = false;
            saveButtonCompact.disabled = false;
        } else {
            saveButton.disabled = true;
            saveButtonCompact.disabled = true;
        }
    });
});
