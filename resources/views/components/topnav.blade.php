<nav class="navbar navbar-light w-100 m-0" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
    <div class="container-fluid px-5 py-2">
        <div class="col-md-2 col-sm-4 col-6 text-start">
            <a class="navbar-brand" href="{{ route('profile') }}">
                <img id="topnav-logo" src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="topnav-website-logo img-fluid w-75">
            </a>
        </div>
        <div class="col-6 text-end">
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
                    <img src="{{ profile()->profile_picture }}" alt="User profile" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover">
                </div>
                <strong>{{ currentAccount()->account_full_name }}</strong><br>
                @switch(currentAccount()->account_role)
                    @case(1)
                        <small>Student</small><br>
                        <small>{{ currentAccount()->account_matric_number }}</small>
                        @break
                    @case(2)
                        <small>Faculty Member</small><br>
                        <small>{{ currentAccount()->account_email_address }}</small>
                        @break
                    @case(3)
                        <small>Admin</small><br>
                        <small>{{ currentAccount()->account_email_address }}</small>
                        @break
                @endswitch
            </li>
            <li><hr class="divider-gray-300"></li>
            <div class="px-0">
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('profile') }}">Profile</a></li>
                <li class="nav-item"><a class="nav-link px-3 text-black-50" href="#">Study Partners (WIP)</a></li>
                <li class="nav-item"><a class="nav-link px-3 text-black-50" href="#">Timetable Builder (WIP)</a></li>
                @if (currentAccount()->account_role == 1)
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('progress-tracker') }}">Academic Progress Tracker</a></li>
                @endif
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('events-finder.view-all-events') }}">Events Finder (WIP)</a></li>
                <li class="nav-item"><a class="nav-link px-3 text-black-50" href="#">Clubs (WIP)</a></li>
                <li class="nav-item"><a class="nav-link px-3 text-black-50" href="#">Bookmarks (WIP)</a></li>
                <li class="nav-item"><a class="nav-link px-3 text-black-50" href="#">Calendar (WIP)</a></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('account.logout') }}">
                        @csrf
                        <button type="submit" class="nav-link px-3 text-danger">
                            Log out
                        </button>
                    </form>
                </li>
            </div>
        </ul>
    </div>
</div>