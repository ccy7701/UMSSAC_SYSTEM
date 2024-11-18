<!-- resources/view/components/notifications-offcanvas.blade.php -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-notifications-bar" aria-labelledby="offcanvas-notifications-bar-label">
    <div class="rsans offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="offcanvas-notifications-bar-label">Notifications</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr class="divider-gray-300 py-0 mt-3 mb-0">
    <div class="rsans offcanvas-body p-0 m-0">
        <ul class="navbar-nav flex-grow-1">

            <!-- Notification cards start -->
            @for ($i = 0; $i < 10; $i++)
                <x-notification-card/>
                <hr class="divider-gray-300 py-0 my-0">
            @endfor


        </ul>
    </div>
</div>
