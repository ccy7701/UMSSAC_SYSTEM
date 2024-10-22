import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import './tooltips';
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

// Study Partners submenu dropdown
document.addEventListener('DOMContentLoaded', function () {
    const studyPartnersToggleLink = document.getElementById('study-partners-toggle');
    const studyPartnersSubmenu = document.getElementById('study-partners-submenu');
    const studyPartnersChevronIcon = document.getElementById('study-partners-chevron');

    studyPartnersToggleLink.addEventListener('click', function (event) {
        event.preventDefault();
        
        if (studyPartnersSubmenu.classList.contains('collapse')) {
            studyPartnersSubmenu.classList.remove('collapse');
            studyPartnersChevronIcon.classList.add('rotate-chevron');
        } else {
            studyPartnersSubmenu.classList.add('collapse');
            studyPartnersChevronIcon.classList.remove('rotate-chevron');
        }
    });
});

// Events submenu dropdown
document.addEventListener('DOMContentLoaded', function () {
    const eventsToggleLink = document.getElementById('events-toggle');
    const eventsSubmenu = document.getElementById('events-submenu');
    const eventsChevronIcon = document.getElementById('events-chevron');

    eventsToggleLink.addEventListener('click', function (event) {
        event.preventDefault();
        
        if (eventsSubmenu.classList.contains('collapse')) {
            eventsSubmenu.classList.remove('collapse');
            eventsChevronIcon.classList.add('rotate-chevron');
        } else {
            eventsSubmenu.classList.add('collapse');
            eventsChevronIcon.classList.remove('rotate-chevron');
        }
    });
});
