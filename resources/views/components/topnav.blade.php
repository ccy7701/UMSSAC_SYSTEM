<!-- resources/views/components/topnav.blade.php -->
<nav class="navbar navbar-light w-100 m-0" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
    <div class="container-fluid px-lg-5 px-md-4 py-2">
        <div class="col-md-2 col-sm-4 col-6 text-start">
            <a class="navbar-brand" href="{{ route('profile') }}">
                <img id="topnav-logo" src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="topnav-website-logo img-fluid w-75">
            </a>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('profile') }}" style="text-decoration: none; outline: none;">
                <img id="user-profile-topnav" src="{{ profile()->profile_picture }}" alt="User profile" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
            </a>
            <span class="px-2"></span>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>
<!-- Offcanvas Navbar -->
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
                @if (currentAccount()->account_role == 1)
                    <small>Student</small><br>
                    <small>{{ currentAccount()->account_matric_number }}</small>
                @elseif (currentAccount()->account == 2)
                    <small>Faculty Member</small><br>
                    <small>{{ currentAccount()->account_email_address }}</small>
                @endif
            </li>
            <hr class="divider-gray-300 py-0 mt-3 mb-0">

            <div class="px-0">
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('profile') }}">Profile</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                @if (currentAccount()->account_role == 1)
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#" id="study-partners-toggle">
                            Study Partners
                            <i class="fa fa-chevron-down chevron-icon ms-1" id="study-partners-chevron"></i>
                        </a>
                        <ul class="nav flex-column collapse" id="study-partners-submenu">
                            <li class="nav-item nav-submenu"><a class="nav-link px-3 text-decoration-none" href="{{ route('study-partners-suggester') }}">&emsp;Study Partners Suggester</a></li>
                            <li class="nav-item nav-submenu"><a class="nav-link px-3" href="{{ route('study-partners-suggester.bookmarks') }}">&emsp;Bookmarked Study Partners</a></li>
                            <li class="nav-item nav-submenu"><a class="nav-link px-3" href="{{ route('study-partners-suggester.added-list') }}">&emsp;Added Study Partners List</a></li>
                        </ul>
                    </li>
                    <hr class="divider-gray-300 py-0 my-0">
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('timetable-builder') }}">Timetable Builder</a></li>
                    <hr class="divider-gray-300 py-0 my-0">
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('progress-tracker') }}">Academic Progress Tracker</a></li>
                    <hr class="divider-gray-300 py-0 my-0">
                @endif

                <li class="nav-item"><a class="nav-link px-3" href="{{ route('clubs-finder') }}">Clubs Finder</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item">
                    <a class="nav-link px-3" href="#" id="events-toggle">
                        Events
                        <i class="fa fa-chevron-down chevron-icon ms-1" id="events-chevron"></i>
                    </a>
                    <ul class="nav flex-column collapse" id="events-submenu">
                        <li class="nav-item nav-submenu"><a class="nav-link px-3 text-decoration-none" href="{{ route('events-finder') }}">&emsp;Events Finder</a></li>
                        <li class="nav-item nav-submenu"><a class="nav-link px-3" href="{{ route('events-finder.bookmarks') }}">&emsp;Bookmarked Events</a></li>
                    </ul>
                </li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item">
                    <form method="POST" action="{{ route('account.logout') }}">
                        @csrf
                        <button type="submit" class="nav-link px-3 text-danger">
                            Log Out
                        </button>
                    </form>
                </li>
                <hr class="divider-gray-300 py-0 my-0">

            </div>
        </ul>
    </div>
</div>
