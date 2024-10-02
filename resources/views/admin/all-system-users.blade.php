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
    @vite('resources/js/systemUsersViewToggler.js')
    <x-admin-topnav/>
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold py-2 mb-0">System users list</h3>
                        <p id="users-count-display" class="rserif fs-4 w-100 mt-0">
                            @if ($totalSystemUsersCount == 0)
                                No users found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @elseif ($totalSystemUsersCount == 1)
                                1 user found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @else
                                {{ $totalSystemUsersCount }} users found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @endif
                        </p>
                    </div>
                    <!-- SEARCH TAB -->
                    <form class="d-flex justify-content-center" method="GET" action="{{ route('admin.all-system-users') }}">
                        <div class="search-tab mb-4">
                            <div class="input-group">
                                <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                <input type="search" id="system-users-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search...">
                                <button class="rsans btn btn-primary fw-bold">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- BODY OF CONTENT -->
        <div class="row-container container-fluid align-items-center my-3 py-3 px-4">
            <div class="rsans row">
                <!-- LEFT SECTIONS FOR FILTERS -->
                <div class="col-lg-3 col-12 border p-3">
                    <div class="d-flex justify-content-center">
                        <!-- Toggle Button visible below 992px -->
                        <button id="filter-toggle-btn" class="btn btn-muted d-lg-none mb-2 border w-50" type="button" data-bs-toggle="collapse" data-bs-target="#filter-collapse" aria-expanded="false" aria-controls="filter-collapse">
                            <span id="filter-btn-text">Show Filters</span>
                            <i id="filter-btn-icon" class="fa fa-chevron-down ms-1 chevron-icon"></i>
                        </button>
                    </div>
                    <div class="collapse d-lg-block" id="filter-collapse">
                        <div class="row">
                            <div class="col-xl-8 col-lg-6 col-6 d-flex align-items-center justify-content-start">
                                <h4 class="rsans fw-bold mb-0">Search filters</h4>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-6 d-flex align-items-center justify-content-end">
                                <form id="clear-filter-form" method="POST" action="{{ route('admin.all-system-users.clear-filter') }}" class="w-100 d-flex justify-content-end">
                                    @csrf
                                    <button id="filter-clear" class="rsans btn btn-secondary fw-bold px-2">Clear all</button>
                                </form>
                            </div>
                        </div>
                        <br>
                        <form id="filter-form" method="POST" action="{{ route('admin.all-system-users.filter') }}">
                            @csrf
                            @php
                            $categories = [
                                'ASTIF', 'FIS', 'FKAL', 'FKIKK', 'FKIKAL',
                                'FKJ', 'FPEP', 'FPKS', 'FPL', 'FPP', 'FPPS', 'FPSK',
                                'FPT', 'FSMP', 'FSSA', 'FSSK', 'Unspecified'
                            ];
                            @endphp
                            <h5 class="rsans fw-semibold mb-2">Categories</h5>
                            <div class="rsans row">
                                @foreach ($categories as $category)
                                    <div class="col-6 mb-2 px-1">
                                        <div class="p-2 border rounded">
                                            <div class="form-check w-50">
                                                <input class="form-check-input" type="checkbox" id="{{ strtolower($category) }}" name="category_filter[]" value="{{ $category }}" {{ in_array($category, $filters) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ strtolower($category) }}">
                                                    {{ $category }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row p-3 d-flex justify-content-center">
                                <button type="submit" class="rsans btn btn-primary fw-bold w-60">
                                    Apply filters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- RIGHT SECTIONS FOR USERS LIST -->
                <div class="col-lg-9 col-12 px-3">
                    <div id="list-view" class="row list-view ms-2">
                        <div class="rsans row d-flex justify-content-center">
                            <div class="col-auto">
                                {{ $allSystemUsers->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        @foreach ($allSystemUsers as $user)
                            <div class="row pb-3">
                                <x-systemuser-list-item :user="$user"/>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
