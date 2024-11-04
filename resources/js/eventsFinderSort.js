// Events sort modal operations
document.getElementById('event-sort-form').addEventListener('submit', function (event) {
    event.preventDefault();
    const sortOption = document.querySelector('input[name="sort"]:checked').value;
    console.log(sortOption);

    // Redirect to the events-finder route with the correct query parameter
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sortOption);
    window.location.href = url.toString();
});
