<nav class="navbar navbar-expand-lg navbar-light w-100 m-0" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
    <div class="container">
        <div class="row align-items-center">
            <!-- Logo section -->
            <div class="col-md-2 col-sm-3 col-xs-4 text-center">
                <a href="{{ route('profile') }}">
                    <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="topnav-website-logo img-fluid">
                </a>
            </div>
            <!-- Navlinks section -->
            <div class="col-md-10 col-sm-9 col-xs-8">
                <!-- Toggler for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar items -->
                <div class="rsans collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto">
                        <!-- TAB 1 with dropdown -->
                        <li class="nav-item dropdown px-2">
                            <a class="nav-link dropdown px-3" href="#" id="tab1Dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                TAB_1
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="tab1Dropdown">
                                <li><a class="dropdown-item" href="#">T1-Dropdown1</a></li>
                                <li><a class="dropdown-item" href="#">T1-Dropdown2</a></li>
                            </ul>
                        </li>
                        <!-- TAB 2 with no dropdown -->
                        <li class="nav-item-dropdown px-2">
                            <a class="rsans nav-link dropdown px-3" href="#" id="tab2Dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                TAB_2
                            </a>
                        </li>
                        <!-- TAB 3 with no dropdown -->
                        @if (currentAccount()->account_role == 1)
                        <li class="nav-item-dropdown px-2">
                            <a class="nav-link px-3" href="{{ route('progress-tracker') }}" id="tab3Dropdown" role="button">
                                PROGRESS TRACKER
                            </a>
                        </li>
                        @endif
                    </ul>
                    <!-- User profile dropdown -->
                    <ul class="rsans navbar-nav">
                        <li class="nav-item-dropdown">
                            <a class="nav-link dropdown" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ profile()->profile_picture }}" alt="User avatar" class="rounded-circle" width="50" height="50">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li class="px-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ profile()->profile_picture }}" alt="User avatar" class="rounded-circle" width="60" height="60">
                                        <div class="ms-2">
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
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('account.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            Log out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
