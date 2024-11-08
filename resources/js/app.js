import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import './flashModal';

// Filters checkbox click effect
document.addEventListener('DOMContentLoaded', () => {
    const clickableWrappers = document.querySelectorAll('.clickable-wrapper');

    clickableWrappers.forEach(wrapper => {
        wrapper.addEventListener('click', function (event) {
            const checkbox = this.querySelector('input[type="checkbox"]');
            
            // Stop the label's default toggle behavior
            event.stopPropagation();
            event.preventDefault();

            // Toggle the checkbox state manually
            checkbox.checked = !checkbox.checked;
        });
    });
});

// For pages that have the search filters, this block applies
document.addEventListener("DOMContentLoaded", function() {
    let filterCollapse = document.getElementById("filter-collapse");
    let filterBtnText = document.getElementById("filter-btn-text");
    let filterBtnIcon = document.getElementById("filter-btn-icon");

    // Listen for the collapse state change
    filterCollapse.addEventListener('shown.bs.collapse', function () {
        // When collapsed section is visible (expanded)
        filterBtnText.textContent = "Hide Filters";
        filterBtnIcon.classList.add('rotate-chevron');
    });

    filterCollapse.addEventListener('hidden.bs.collapse', function () {
        // When collapsed section is hidden
        filterBtnText.textContent = "Show Filters";
        filterBtnIcon.classList.remove('rotate-chevron');
    });
});

// For views that have password fields
document.addEventListener('DOMContentLoaded', () => {
    const toggleIcons = document.querySelectorAll('.password-toggle');

    toggleIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const targetId = icon.getAttribute('data-target');
            const targetField = document.getElementById(targetId);
            const eyeIcon = icon.querySelector('i');

            if (targetField.type === 'password') {
                targetField.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                targetField.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
});

// For controlling the chevron icon in views that contain it excluding the topnav
document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.toggle-details');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const chevronIcon = this.querySelector('.chevron-icon');
            if (chevronIcon) {
                chevronIcon.classList.toggle('rotate-chevron');
            }
        });
    });
});

// For initialising each submenu dropdown in the topnav
document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = [
        { toggleId: 'study-partners-toggle', submenuId: 'study-partners-submenu', chevronId: 'study-partners-chevron' },
        { toggleId: 'clubs-toggle', submenuId: 'clubs-submenu', chevronId: 'clubs-chevron' },
        { toggleId: 'events-toggle', submenuId: 'events-submenu', chevronId: 'events-chevron' }
    ];

    dropdowns.forEach(dropdown => {
        const toggleLink = document.getElementById(dropdown.toggleId);
        const submenu = document.getElementById(dropdown.submenuId);
        const chevronIcon = document.getElementById(dropdown.chevronId);

        if (toggleLink && submenu && chevronIcon) {
            toggleLink.addEventListener('click', function (event) {
                event.preventDefault();

                if (submenu.classList.contains('collapse')) {
                    submenu.classList.remove('collapse');
                    chevronIcon.classList.add('rotate-chevron');
                } else {
                    submenu.classList.add('collapse');
                    chevronIcon.classList.remove('rotate-chevron');
                }
            });
        } else {
            console.warn(`One or more elements are missing for dropdown with toggleId: ${dropdown.toggleId}`);
        }
    });
});
