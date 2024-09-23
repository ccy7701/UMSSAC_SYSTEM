document.addEventListener('DOMContentLoaded', function () {
    let currentCategory = null;
    let currentAccountRole = null;

    // Filter system users based on category and accountRole
    function filterSystemUsers() {
        document.querySelectorAll('.systemuser-list-item').forEach(function(user) {
            const userCategory = user.getAttribute('data-category');
            const userAccountRole = user.getAttribute('data-account-role');

            let matchesCategory = currentCategory === null || userCategory === currentCategory;
            let matchesAccountRole = currentAccountRole === null || userAccountRole === currentAccountRole;

            if (matchesCategory && matchesAccountRole) {
                user.style.display = 'block';
            } else {
                user.style.display = 'none';
            }
        });
    }

    // Handle category button clicks
    document.querySelectorAll('.filter-category').forEach(function(button) {
        button.addEventListener('click', function() {
            currentCategory = this.getAttribute('data-category');
            filterSystemUsers();
            scrollToTop();
        });
    });
    
    // Handle role toggle button clicks
    document.querySelectorAll('.toggle-role-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            currentAccountRole = this.getAttribute('data-account-role');
            filterSystemUsers();
            scrollToTop();
        });
    });
})

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
