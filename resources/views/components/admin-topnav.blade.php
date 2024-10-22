<!-- resources/views/components/admin-topnav.blade.php -->
<nav class="navbar navbar-light w-100 m-0" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
    <div class="container-fluid px-lg-5 px-md-4 py-2">
        <div class="col-md-2 col-sm-4 col-6 text-start">
            <a class="navbar-brand" href="{{ route('my-profile') }}">
                <img id="topnav-logo" src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="topnav-website-logo img-fluid w-75">
            </a>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('my-profile') }}" style="text-decoration: none; outline: none;">
                <img id="user-profile-topnav" src="{{ profile()->profile_picture }}" alt="User profile" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
            </a>
            <span class="px-2"></span>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>

<!-- Offcanvas navbar -->
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
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('my-profile') }}">Profile</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item"><a class="nav-link px-3" href="{{ route('admin.all-system-users') }}">All System Users</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item"><a class="nav-link px-3" href="{{ route('manage-clubs') }}">Manage Clubs</a></li>
                <hr class="divider-gray-300 py-0 my-0">

                <li class="nav-item"><a class="nav-link px-3" href="{{ route('events-finder') }}">Events Finder</a></li>
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
