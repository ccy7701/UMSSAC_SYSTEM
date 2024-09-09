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

// Event listener for Grid view
document.getElementById('toggle-grid-view').addEventListener('click', function() {
    toggleView('toggle-grid-view', 'toggle-list-view', '.grid-view', '.list-view');
});

// Event listener for List view
document.getElementById('toggle-list-view').addEventListener('click', function() {
    toggleView('toggle-list-view', 'toggle-grid-view', '.list-view', '.grid-view');
});
