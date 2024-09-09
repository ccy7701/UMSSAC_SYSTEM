document.getElementById('toggle-grid-view').addEventListener('click', function() {
    // Show grid view, hide list view
    document.querySelector('.grid-view').classList.remove('d-none');
    document.querySelector('.list-view').classList.add('d-none');

    // Set grid button to active, list button to inactive
    this.classList.add('active');
    document.getElementById('toggle-list-view').classList.remove('active');
    
    // Change icon colors accordingly
    this.querySelector('i').classList.add('text-primary');
    this.querySelector('i').classList.remove('text-muted');
    
    document.getElementById('toggle-list-view').querySelector('i').classList.add('text-muted');
    document.getElementById('toggle-list-view').querySelector('i').classList.remove('text-primary');
});

document.getElementById('toggle-list-view').addEventListener('click', function() {
    // Show list view, hide grid view
    document.querySelector('.list-view').classList.remove('d-none');
    document.querySelector('.grid-view').classList.add('d-none');

    // Set list button to active, grid button to inactive
    this.classList.add('active');
    document.getElementById('toggle-grid-view').classList.remove('active');
    
    // Change icon colors accordingly
    this.querySelector('i').classList.add('text-primary');
    this.querySelector('i').classList.remove('text-muted');
    
    document.getElementById('toggle-grid-view').querySelector('i').classList.add('text-muted');
    document.getElementById('toggle-grid-view').querySelector('i').classList.remove('text-primary');
});
