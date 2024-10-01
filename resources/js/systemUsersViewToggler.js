document.addEventListener('DOMContentLoaded', function () {
    let currentCategory = null;
    let currentAccountRole = null;
    let activeCategoryButton = null;
    let activeRoleButton = null;

    // Handle category button clicks
    document.querySelectorAll('.filter-category').forEach(function(button) {
        button.addEventListener('click', function() {
            // Reset filters before applying new one
            resetFilters();

            currentCategory = this.getAttribute('data-category');

            // Set the clicked button as the active category button
            setActiveButton(this);
            activeCategoryButton = this;

            filterSystemUsers();
            scrollToTop();
        });
    });
    
    // Handle role toggle button clicks
    document.querySelectorAll('.toggle-role-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            // Reset filters before applying new one
            resetFilters();

            currentAccountRole = this.getAttribute('data-account-role');

            // Set the clicked button as the active role button
            setActiveButton(this);
            activeRoleButton = this;

            filterSystemUsers();
            scrollToTop();
        });
    });
    // Filter system users based on category and accountRole
    function filterSystemUsers() {
        document.querySelectorAll('.systemuser-list-item').forEach(function(user) {
            const userCategory = user.getAttribute('data-category');
            const userAccountRole = user.getAttribute('data-account-role');

            // If no filters are applied, show all users
            let showUser = true;

            if (currentCategory) {
                showUser = userCategory === currentCategory;
            }

            if (currentAccountRole) {
                showUser = userAccountRole === currentAccountRole;
            }

            user.style.display = showUser ? 'block' : 'none';
        });
    }

    // Scroll to the top of the page
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Apply active button styles
    function setActiveButton(button) {
        button.classList.add('bg-primary', 'text-white');
    }

    // Reset button styles
    function resetButton(button) {
        if (button) {
            button.classList.remove('bg-primary', 'text-white');
        }
    }

    // Reset all filters both category and account role
    function resetFilters() {
        currentCategory = null;
        currentAccountRole = null;

        resetButton(activeCategoryButton);
        resetButton(activeRoleButton);

        activeCategoryButton = null;
        activeRoleButton = null;
    }
});
