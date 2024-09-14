// Profile picture preview
document.getElementById('profile-picture-input').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('profile-picture-preview').src = URL.createObjectURL(file);
    }
});
