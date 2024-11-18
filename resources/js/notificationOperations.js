document.addEventListener('DOMContentLoaded', function() {
    fetchNotifications();
});

// Fetch user's notifications and populate topnav offcanvas for it
function fetchNotifications() {
    fetch('/notifications/fetch-all')
        .then(response => response.json())
        .then(data => {
            const notificationsList = document.getElementById('notifications-list');
            notificationsList.innerHTML = '';

            data.forEach(notification => {
                const notificationItem = createNotificationItem(notification);
                const divider = createDivider();

                notificationsList.appendChild(notificationItem);
                notificationsList.appendChild(divider);
            });
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
        })
}

// Create the notification list item
function createNotificationItem(notification) {
    const notificationItem = document.createElement('li');
    notificationItem.classList.add('nav-item');
    notificationItem.innerHTML = `
        <a class="nav-link px-3">
            <div class="row mt-1">
                <div class="col-1 d-flex justify-content-center align-items-start">
                    <i class="fa-solid fa-circle text-primary mt-1" style="font-size: 0.70em;"></i>
                </div>
                <div class="col-10">
                    <div class="row d-flex align-items-center py-0">
                        <h6 class="mt-0 mb-1 text-truncate">
                            ${notification.notification_title}
                        </h6>
                    </div>
                    <div class="row d-flex align-items-center py-0">
                        <p class="mt-0 mb-1 text-truncate">
                            ${notification.notification_message}
                        </p>
                    </div>
                    <div class="row d-flex align-items-center py-0">
                        <small class="text-muted">
                            ${notification.formatted_datetime}
                        </small>
                    </div>
                </div>
                <div class="col-1 d-flex justify-content-center align-items-start">
                    <i class="fa-solid fa-trash text-secondary mt-1" style="font-size: 0.90em;"></i>
                </div>
            </div>
        </a>
    `;

    return notificationItem;
}

// Create the list item divider
function createDivider() {
    const divider = document.createElement('hr');
    divider.classList.add('divider-gray-300', 'py-0', 'my-0');

    return divider;
}