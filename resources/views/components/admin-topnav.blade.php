<!-- resources/views/components/admin-topnav.blade.php -->
<nav id="topnav" class="navbar navbar-light w-100 m-0 py-xl-1 py-lg-1 py-md-1 py-sm-0 py-xs-0 py-0" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); background-color: #FFFFFF">
    <div class="container-fluid px-lg-5 px-md-4 py-2">
        <div class="col-md-2 col-sm-4 col-6 text-start">
            <a class="navbar-brand" href="{{ route('my-profile') }}">
                <img id="topnav-logo" src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="topnav-website-logo img-fluid w-75">
            </a>
        </div>
        <div class="col-6 text-end">
            <!-- Profile picture icon button for notifications trigger -->
            <button class="btn p-0 position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-notifications-bar" aria-controls="offcanvas-notifications-bar" style="text-decoration-none; outline: none; border: none;">
                <img id="user-profile-topnav" src="{{ profile()->profile_picture }}" alt="User profile" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                <!-- Notification indicator -->
                <span id="notification-indicator" class="position-absolute bg-primary rounded-circle d-none"></span>
            </button>
            <span class="px-2"></span>
            <!-- Sandwich icon button for navigation trigger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>
<!-- Offcanvas Navbar for Notification -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-notifications-bar" aria-labelledby="offcanvas-notifications-bar-label">
    <div class="rsans offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="offcanvas-notifications-bar-label">Notifications</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr class="divider-gray-300 py-0 mt-3 mb-0">
    <div class="rsans offcanvas-body p-0 m-0">
        <ul id="notifications-list" class="navbar-nav flex-grow-1">
            <!-- LOOPING COMPONENT FOR NOTIFICATIONS GOES HERE -->
        </ul>
    </div>
</div>
<!-- Offcanvas Navbar for Navigation -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="rsans offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="rsans offcanvas-body p-0 m-0">
        <ul class="navbar-nav justify-content-end flex-grow-1">
            <li class="text-center">
                <div class="align-items-center pb-2">
                    <img src="{{ profile()->profile_picture }}" alt="User profile" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #AAAAAA;">
                </div>
                <strong>{{ currentAccount()->account_full_name }}</strong><br>
                <small>Admin</small><br>
                <small>{{ currentAccount()->account_email_address }}</small>
            </li>
            <hr class="divider-gray-300 py-0 mt-3 mb-0">

            <div class="px-0">
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('my-profile') }}"><i class="fas fa-user pe-2 w-10"></i> Profile</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item"><a class="nav-link px-3" href="{{ route('admin.all-system-users') }}"><i class="fas fa-address-book pe-2 w-10"></i> All System Users</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center px-3" href="#" id="clubs-toggle">
                        <span class="d-flex align-items-center w-50">
                            <i class="fas fa-users pe-2 w-20"></i>&nbsp;Clubs
                        </span>
                        <i class="fa fa-chevron-down chevron-icon" id="clubs-chevron"></i>
                    </a>
                    <ul class="nav flex-column collapse" id="clubs-submenu">
                        <li class="nav-item nav-submenu">
                            <a class="nav-link px-3 text-decoration-none" href="{{ route('manage-clubs') }}">&emsp;Manage Clubs</a>
                        </li>
                        <li class="nav-item nav-submenu">
                            <a class="nav-link px-3 text-decoration-none" href="{{ route('club-creation.requests.manage') }}">&emsp;Manage Club Creation Requests</a>
                        </li>
                    </ul>
                </li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item"><a class="nav-link px-3" href="{{ route('events-finder') }}"><i class="fa fa-calendar pe-2 w-10"></i> Events</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item">
                    <a class="nav-link px-3" href="#" data-bs-toggle="modal" data-bs-target="#about-modal"><i class="fas fa-info-circle pe-2 w-10"></i> About UMSSACS</a>
                </li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item">
                    <a class="nav-link px-3" href="#" data-bs-toggle="modal" data-bs-target="#feedback-modal"><i class="fas fa-comment-dots pe-2 w-10"></i> Leave Feedback Here!</a>
                </li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item">
                    <form method="POST" action="{{ route('account.logout') }}">
                        @csrf
                        <button type="submit" class="nav-link px-3 text-danger fw-bold">
                            Log Out
                        </button>
                    </form>
                </li>
                <hr class="divider-gray-300 py-0 my-0">

            </div>
        </ul>
    </div>
</div>
