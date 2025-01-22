<!-- resources/views/components/topnav.blade.php -->
<nav id="topnav" class="navbar navbar-light w-100 m-0 py-xl-1 py-lg-1 py-md-1 py-sm-0 py-xs-0 py-0" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); background-color: #FFFFFF;">
    <div class="container-fluid px-lg-5 px-md-4 py-2">
        <div class="col-md-2 col-sm-4 col-6 text-start">
            <a class="navbar-brand" href="{{ route('my-profile') }}">
                <img id="topnav-logo" src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="topnav-website-logo img-fluid">
            </a>
        </div>
        <div class="col-6 text-end">
            <!-- Profile picture icon button for notifications trigger -->
            <button class="btn p-0 position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-notifications-bar" aria-controls="offcanvas-notifications-bar" style="text-decoration: none; outline: none; border: none;">
                <img id="user-profile-topnav" src="{{ profile()->profile_picture }}" alt="User profile" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                <!-- Notification Indicator -->
                <span id="notification-indicator" class="position-absolute bg-primary rounded-circle d-none"></span>
            </button>
            <span class="px-2"></span>
            <!-- Sandwich icon button for navigation trigger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-navbar" aria-controls="offcanvas-navbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </div>
</nav>
<!-- Offcanvas Navbar for Notifications -->
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-navbar" aria-labelledby="offcanvas-navbar-label">
    <div class="rsans offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="offcanvas-navbar-label">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="rsans offcanvas-body p-0 m-0">
        <ul class="navbar-nav justify-content-end flex-grow-1">
            <li class="text-center">
                <div class="align-items-center pb-2">
                    <img src="{{ profile()->profile_picture }}" alt="User profile" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #AAAAAA;">
                </div>
                <strong>{{ currentAccount()->account_full_name }}</strong><br>
                @if (currentAccount()->account_role == 1)
                    <small>Student</small><br>
                    <small>{{ currentAccount()->account_matric_number }}</small>
                @elseif (currentAccount()->account_role == 2)
                    <small>Faculty Member</small><br>
                    <small>{{ currentAccount()->account_email_address }}</small>
                @endif
            </li>
            <hr class="divider-gray-300 py-0 mt-3 mb-0">

            <div class="px-0">
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('my-profile') }}"><i class="fas fa-user pe-2 w-10"></i> Profile</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                @if (currentAccount()->account_role == 1)
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center px-3" href="#" id="study-partners-toggle">
                            <span class="d-flex align-items-center w-50">
                                <i class="fas fa-user-friends pe-2 w-20"></i>&nbsp;Study Partners
                            </span>
                            <i class="fa fa-chevron-down chevron-icon" id="study-partners-chevron"></i>
                        </a>
                        <ul class="nav flex-column collapse" id="study-partners-submenu">
                            <li class="nav-item nav-submenu"><a class="nav-link px-3 text-decoration-none" href="{{ route('study-partners-suggester') }}">&emsp;Study Partners Suggester</a></li>
                            <li class="nav-item nav-submenu"><a class="nav-link px-3" href="{{ route('study-partners-suggester.bookmarks') }}">&emsp;Bookmarked Study Partners</a></li>
                            <li class="nav-item nav-submenu"><a class="nav-link px-3" href="{{ route('study-partners-suggester.added-list') }}">&emsp;Added Study Partners List</a></li>
                        </ul>
                    </li>
                    <hr class="divider-gray-300 py-0 my-0">

                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('timetable-builder') }}"><i class="fas fa-calendar-alt pe-2 w-10"></i> Timetable Builder</a></li>
                    <hr class="divider-gray-300 py-0 my-0">
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('progress-tracker') }}"><i class="fas fa-chart-line pe-2 w-10"></i> Academic Progress Tracker</a></li>
                    <hr class="divider-gray-300 py-0 my-0">
                @endif

                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center px-3" href="#" id="clubs-toggle">
                        <span class="d-flex align-items-center w-50">
                            <i class="fas fa-users pe-2 w-20"></i>&nbsp;Clubs
                        </span>
                        <i class="fa fa-chevron-down chevron-icon" id="clubs-chevron"></i>
                    </a>
                    <ul class="nav flex-column collapse" id="clubs-submenu">
                        <li class="nav-item nav-submenu">
                            <a class="nav-link px-3 text-decoration-none" href="{{ route('clubs-finder') }}">&emsp;Clubs Finder</a>
                        </li>
                        <li class="nav-item nav-submenu">
                            <a class="nav-link px-3" href="{{ route('clubs-finder.joined-clubs') }}">&emsp;Joined Clubs</a>
                        </li>
                        @if (currentAccount()->account_role == 2)
                            <li class="nav-item nav-submenu">
                                <a class="nav-link px-3" href="{{ route('club-creation.requests.new') }}">&emsp;Request for New Club Creation</a>
                            </li>
                            <li class="nav-item nav-submenu">
                                <a class="nav-link px-3" href="{{ route('club-creation.requests.view') }}">&emsp;View Club Creation Requests</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center px-3" href="#" id="events-toggle">
                        <span class="d-flex align-items-center w-50">
                            <i class="fa fa-calendar pe-2 w-20"></i>&nbsp;Events
                        </span>
                        <i class="fa fa-chevron-down chevron-icon" id="events-chevron"></i>
                    </a>
                    <ul class="nav flex-column collapse" id="events-submenu">
                        <li class="nav-item nav-submenu"><a class="nav-link px-3 text-decoration-none" href="{{ route('events-finder') }}">&emsp;Events Finder</a></li>
                        <li class="nav-item nav-submenu"><a class="nav-link px-3" href="{{ route('events-finder.bookmarks') }}">&emsp;Bookmarked Events</a></li>
                    </ul>
                </li>
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
