// On page load, fetch the user's notifications
document.addEventListener('DOMContentLoaded', function() {
    startPeriodicNotificationFetch();
});

// Function to periodically fetch notifications
function startPeriodicNotificationFetch() {
    fetchNotifications();
    setInterval(fetchNotifications, 10000);
}

// Fetch user's notifications and populate topnav offcanvas for it
function fetchNotifications() {
    fetch('/notifications/fetch-all')
        .then(response => response.json())
        .then(data => {
            const notificationsList = document.getElementById('notifications-list');
            notificationsList.innerHTML = '';

            // Update the topnav notification indicator
            const unreadNotificationsCount = data.filter(notification => notification.is_read === 0).length;
            updateNotificationIndicator(unreadNotificationsCount);

            // Check if there are no notifications, exit early if true
            if (data.length === 0) {
                const noNotificationItem = createNoNotificationsMessage();
                notificationsList.appendChild(noNotificationItem);

                return;
            }
        
            // If there are, then generate the notification items
            data.forEach(notification => {
                const notificationItem = createNotificationItem(notification);
                const divider = createDivider();

                notificationsList.appendChild(notificationItem);
                notificationsList.appendChild(divider);
            });

            // Attach eventListeners to the delete buttons
            attachDeleteEventListeners();
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
        })
}

// Update the notification indicator circle
function updateNotificationIndicator(unreadNotificationsCount) {
    const notificationIndicator = document.getElementById('notification-indicator');

    if (unreadNotificationsCount > 0) {
        // Show the indicator
        notificationIndicator.classList.remove('d-none');
        notificationIndicator.classList.add('d-block');
    } else {
        // Hide the indicator
        notificationIndicator.classList.remove('d-block');
        notificationIndicator.classList.add('d-none');
    }
}

// Display a no notifications imgge if there aren't any notifications
function createNoNotificationsMessage() {
    const noNotificationItem = document.createElement('li');
    noNotificationItem.classList.add('nav-item', 'disabled');
    noNotificationItem.innerHTML = `
        <a class="nav-link px-3">
            <div class="row d-flex justify-content-center mt-4">
                <div class="col-12 d-flex justify-content-center">
                    <p class="fst-italic">No notifications found</p>
                </div>
            </div>
        </a>
    `;

    return noNotificationItem;
}

// Create the notification list item
function createNotificationItem(notification) {
    const isReadClass = notification.is_read == 0 
        ? `notification` 
        : `notification-read text-secondary`;

    const isReadIndicator = notification.is_read == 0
        ? `<i class="fa-solid fa-circle text-primary mt-1" style="font-size: 0.70em;"></i>`
        : ``;

    const notificationItem = document.createElement('li');
    notificationItem.classList.add('nav-item');
    notificationItem.innerHTML = `
        <a class="nav-link px-3 ${isReadClass}">
            <div class="row mt-1">
                <div class="col-1 d-flex justify-content-center align-items-start">
                    ${isReadIndicator}
                </div>
                <div class="col-10">
                    <div class="row d-flex align-items-center py-0">
                        <h6 class="mt-0 mb-1 text-truncate">
                            ${notification.notification_title}
                        </h6>
                    </div>
                    <div class="row d-flex align-items-center py-0">
                        <p class="mt-0 mb-1">
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
                    <form id="delete-form-${notification.notification_id}" method="POST" action="/notifications/delete">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                        <input type="hidden" name="notification_id" value="${notification.notification_id}">
                    </form>
                    <button type="submit" form="delete-form-${notification.notification_id}" class="btn btn-delete-notification p-0 m-0 d-flex align-items-center justify-content-center" style="font-size: 1.00em; line-height: 1;">
                        <i class="delete-icon fa-solid fa-trash m-0 p-0"></i>
                    </button>
                </div>
            </div>
        </a>
    `;

    // Attach the click event listener to the anchor if the notification is unread
    if (notification.is_read == 0) {
        notificationItem.querySelector('a').addEventListener('click', function() {
            markNotificationAsRead(notification.notification_id);
        });
    }

    return notificationItem;
}

// Create the list item divider
function createDivider() {
    const divider = document.createElement('hr');
    divider.classList.add('divider-gray-300', 'py-0', 'my-0');

    return divider;
}

// Handle marking a notification as read
function markNotificationAsRead(notificationId) {
    // Create a new FormData object and append the notification ID
    const formData = new FormData();
    formData.append('notification_id', notificationId);

    // Use fetch API to send the update request
    fetch('/notifications/mark-as-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Notification fetched successfully. Regenerate the notifications list
            fetchNotifications();
        } else {
            console.error('Failed to mark the notification as read:', data.error);
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

// Handle attaching delete eventListeners and deletion
function attachDeleteEventListeners() {
    const deleteButtons = document.querySelectorAll('.btn-delete-notification');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // Get the associated form ID and form element
            const formId = button.getAttribute('form');
            const form = document.getElementById(formId);

            // Extract the form data
            const formData = new FormData(form);
            const formAction = form.action;
            const csrfToken = form.querySelector('input[name="_token"]').value;

            // Use Fetch API to send the deletion request
            fetch(formAction, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Notification fetched successfully. Regenerate the notifications list
                    fetchNotifications();
                } else {
                    console.error('Failed to delete the notification:', data.error);
                }
            })
            .catch(error => {
                console.error('Error deleting notification:', error);
            });
        });
    });
}
