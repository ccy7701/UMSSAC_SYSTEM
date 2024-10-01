import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import './tooltips';
import './flashModal';

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
