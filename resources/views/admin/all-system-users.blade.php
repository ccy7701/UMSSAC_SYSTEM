<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>All System Users</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    @vite('resources/js/systemUsersViewToggler.js')
    <x-admin-topnav/>
    <main class="flex-grow-1">
        <br>
        <div class="container p-3">

            <div class="d-flex align-items-center">
                <!-- TOP SECTION -->
                <div class="section-header row w-100">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">System users list</h3>
                        <p id="users-count-display" class="rserif fs-4 w-100 mt-0">
                            @if ($totalUsersCount == 0)
                                No users found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @elseif ($totalUsersCount == 1)
                                1 user found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @else
                                {{ $totalUsersCount }} users found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @endif
                        </p>
                        <!-- SEARCH TAB -->
                        <form class="d-flex justify-content-center" method="GET" action="{{ route('profile.all-system-users') }}">
                            <div class="mb-4 w-50">
                                <div class="input-group">
                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                    <input type="search" id="users-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                    <button class="rsans btn btn-primary fw-bold">Search</button>
                                </div>
                            </div>
                        </form>
                        <div class="row pb-3">
                            <!-- Left column, users-by-role toggle -->
                            <div class="col-6 d-flex align-items-center"></div>
                            <!-- Right column: View icons -->
                            <div class="col-6 d-flex align-items-center justify-content-end">
                                <div class="input-group justify-content-end">
                                    <!-- Grid view toggle button -->
                                    <button id="toggle-grid-view" class="btn d-flex justify-content-center align-items-center border toggle-view-btn {{ $searchViewPreference == 1 ? 'active' : '' }}">
                                        <i class="fa fa-th fs-4 {{ $searchViewPreference == 1 ? 'text-primary' : 'text-muted' }}"></i>
                                    </button>
                                    <!-- List view toggle button -->
                                    <button id="toggle-list-view" class="btn d-flex justify-content-center align-items-center border toggle-view-btn {{ $searchViewPreference == 2 ? 'active' : '' }}">
                                        <i class="fa fa-list-ul fs-4 {{ $searchViewPreference == 2 ? 'text-primary' : 'text-muted' }}"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BODY OF CONTENT -->
            <div class="container-fluid align-items-center py-4">
                <div class="row">

                    <!-- LEFT SECTIONS FOR FILTERS -->
                    <div class="col-md-3 border p-3">
                        <div class="row">
                            <div class="col-12 align-items-center justify-content-start">
                                <h4 class="rsans fw-bold mb-0">Search filters</h4>
                            </div>
                        </div>
                        <br>
                        @php
                            $categories = [
                                'ASTIF', 'FIS', 'FKAL', 'FKIKK', 'FKIKAL',
                                'FKJ', 'FPEP', 'FPL', 'FPP', 'FPSK',
                                'FPT', 'FSMP', 'FSSA', 'FSSK', 'KKTF',
                                'KKTM', 'KKTPAR', 'KKAKF', 'KKUSIA', 'NR',
                                'Unspecified'
                            ];
                        @endphp
                        <h5 class="rsans fw-semibold mb-2">Categories</h5>
                        <div class="rsans row">
                            @foreach ($categories as $category)
                                <div class="col-6 mb-2 px-1">
                                    <button class="btn border rounded p-2 w-100 text-start filter-category" data-category="{{ $category }}">
                                        {{ $category }}
                                        ({{
                                            $category === 'Unspecified'
                                                ? $systemUsers->where('profile_faculty', '')->count()
                                                : $systemUsers->where('profile_faculty', $category)->count()
                                        }})
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <h5 class="rsans fw-semibold mb-2">Roles</h5>
                        <div class="rsans row">
                            <div class="col-12 mb-2 px-1">
                                <button id="toggle-students-view" class="btn border rounded p-2 w-100 text-start toggle-role-btn" data-account-role="1">
                                    Students ({{ $roleCounts['students'] }})
                                </button>
                            </div>
                            <div class="col-12 mb-2 px-1">
                                <button id="toggle-faculty-members-view" class="btn border rounded p-2 w-100 text-start toggle-role-btn" data-account-role="2">
                                    Faculty members ({{ $roleCounts['facultyMembers'] }})
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SECTION FOR SYSTEM USER CARDS GRID OR LIST -->
                    <div class="col-md-9 px-3 py-0">
                        <div class="container-fluid">
                            <!-- GRID VIEW (Toggle based on preference) -->
                            <div id="grid-view" class="row grid-view {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                                <!-- Your grid view content goes here -->
                            </div>
                            <!-- LIST VIEW (Toggle based on preference) -->
                            <div id="list-view" class="row list-view {{ $searchViewPreference == 2 ? '' : 'd-none' }}">
                                @foreach ($systemUsers as $user)
                                    <x-systemuser-list-item
                                        :user="$user"
                                        class="systemuser-list-item"
                                        data-category="{{ $user->profile_faculty }}"
                                        data-account-role="{{ $user->account_role }}"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>
    <x-footer/>
</body>

</html>
