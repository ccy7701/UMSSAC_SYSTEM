document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.toggle-details');

    toggleButtons.forEach(button => {
        const icon = button.querySelector('i');
        const targetId = button.getAttribute('data-bs-target');
        const targetElement = document.querySelector(targetId);

        // Rotate the chevron when the collapse starts showing
        targetElement.addEventListener('show.bs.collapse', function () {
            icon.classList.add('rotate-chevron');
        });

        // Reset the chevron when the collapse starts hiding
        targetElement.addEventListener('hide.bs.collapse', function () {
            icon.classList.remove('rotate-chevron');
        });
    });
});
