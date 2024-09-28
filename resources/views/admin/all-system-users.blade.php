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
        <div class="container p-3">
            <div class="d-flex align-items-center">
                <!-- TOP SECTION -->
                <div class="section-header row w-100">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">System users list</h3>
                        <p id="users-count-display" class="rserif fs-4 w-100 mt-0">
                            @if ($totalSystemUsersCount == 0)
                                No users found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @elseif ($totalSystemUsersCount == 1)
                                1 user found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @else
                                {{ $totalSystemUsersCount }} users found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @endif
                        </p>
                        <!-- SEARCH TAB -->
                        <form class="d-flex justify-content-center" method="GET" action="{{ route('admin.all-system-users') }}">
                            <div class="mb-4 w-50">
                                <div class="input-group">
                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                    <input type="search" id="system-users-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search...">
                                    <button class="rsans btn btn-primary fw-bold">Search</button>
                                </div>
                            </div>
                        </form>
                        <div class="row pb-3"></div>
                    </div>
                </div>
            </div>
            <!-- BODY OF CONTENT -->
            <div class="container-fluid align-items-center py-4">
                <div class="row">
                    <!-- LEFT SECTIONS FOR FILTERS -->
                    <div class="col-md-3 border p-3">
                        <div class="row">
                            <div class="col-8 d-flex align-items-center justify-content-start">
                                <h4 class="rsans fw-bold mb-0">Search filters</h4>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end">
                                <form id="clear-filter-form" method="POST" action="{{ route('admin.all-system-users.clear-filter') }}">
                                    @csrf
                                    <button class="rsans btn btn-secondary fw-bold px-2">Clear all</button>
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
                                    Apply filters</button>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- RIGHT SECTION FOR USERS LIST -->
                    <div class="col-md-9 px-3 py-0">
                        <div class="container-fluid">
                            <div id="list-view" class="row list-view">
                                <div class="rsans d-flex justify-content-center">
                                    {{ $allSystemUsers->links('pagination::bootstrap-4') }}
                                </div>
                                @foreach($allSystemUsers as $user)
                                    <div class="row pb-3">
                                        <x-systemuser-list-item :user="$user"/>
                                    </div>
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
