// Dynamically toggle between the -standard and -compact search bars based on viewport width
window.addEventListener('load', function() {
    const standardInput = document.getElementById('search-standard');
    const compactInput = document.getElementById('search-compact');

    function toggleInput() {
        if (window.innerWidth >= 768) {
            standardInput.disabled = false;
            compactInput.disabled = true;
        } else {
            standardInput.disabled = true;
            compactInput.disabled = false;
        }
    }

    // Run on load and resize
    toggleInput();
    window.addEventListener('resize', toggleInput);
});
