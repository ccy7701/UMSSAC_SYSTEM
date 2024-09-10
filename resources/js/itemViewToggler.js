document.getElementById('toggle-grid-view').addEventListener('click', function() {
    toggleView('toggle-grid-view', 'toggle-list-view', '#grid-view', '#list-view');
    updateItemViewPreference(1); // 1 = grid view
});

document.getElementById('toggle-list-view').addEventListener('click', function() {
    toggleView('toggle-list-view', 'toggle-grid-view', '#list-view', '#grid-view');
    updateItemViewPreference(2); // 2 = list view
});

function toggleView(activeViewId, inactiveViewId, activeContainerClass, inactiveContainerClass) {
    // Show the active view, hide the inactive view
    document.querySelector(activeContainerClass).classList.remove('d-none');
    document.querySelector(inactiveContainerClass).classList.add('d-none');
    
    // Set the active button, and reset the inactive button
    document.getElementById(activeViewId).classList.add('active');
    document.getElementById(inactiveViewId).classList.remove('active');
    
    // Change icon colors accordingly
    document.getElementById(activeViewId).querySelector('i').classList.add('text-primary');
    document.getElementById(activeViewId).querySelector('i').classList.remove('text-muted');
    
    document.getElementById(inactiveViewId).querySelector('i').classList.add('text-muted');
    document.getElementById(inactiveViewId).querySelector('i').classList.remove('text-primary');
}

function updateItemViewPreference(viewPreference) {
    // Make an AJAX request to update the user's preference
    fetch('/update-search-view-preference', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            search_view_preference: viewPreference
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('User preference updated:', data);
    })
    .catch(error => {
        console.error('Error updating user preference:', error);
    });
}
