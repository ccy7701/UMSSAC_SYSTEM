<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>All System Users | UMSSACS</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/systemUsersViewToggler.js')
    @vite('resources/js/sysusersSort.js')
    <x-admin-topnav/>
    <x-about/>
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
                    <!-- Filter and sort buttons -->
                    <div class="row pb-3">
                        <!-- Left column: Filters popout for smaller displays -->
                        <div id="sysusers-filters-compact" class="col-xl-6 col-md-6 col-sm-12 col-12 align-items-center justify-content-start">
                            <div class="input-group justify-content-start">
                                <button id="toggle-offcanvas-filters" class="rsans btn d-flex justify-content-center align-items-center border" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-filter" aria-controls="offcanvas-filter" aria-label="Toggle filters">
                                    <i class="fa-solid fa-filter fs-4 text-secondary"></i>
                                    <p class="ms-2 mb-0 text-secondary">Filters</p>
                                </button>
                                <button id="sysusers-sort-compact" class="rsans btn justify-content-center align-items-center border" data-bs-toggle="modal" data-bs-target="#sysusers-sort-modal" aria-controls="sysusers-sort-modal" aria-label="System Users Sort Options">
                                    <i class="fa-solid fa-sort fs-4 text-secondary"></i>
                                    <p class="ms-2 mb-0 text-secondary">
                                        @php
                                            $activeSort = request()->input('sort', '');
                                        @endphp
                                        @switch ($activeSort)
                                            @case ('az') Name (A-Z) @break
                                            @case ('za') Name (Z-A) @break
                                            @case ('oldest') Oldest @break
                                            @case ('newest') Newest @break
                                            @case ('fm') Faculty members first @break
                                            @case ('student') Students first @break
                                            @default Sort
                                        @endswitch
                                    </p>
                                </button>
                            </div>
                        </div>
                        @php
                            $categoryFilters = $filters ?? [];
                        @endphp
                        <x-sysusers-filters-tab :categoryfilters="$categoryFilters"/>
                        <!-- Right column: View icons -->
                        <div id="sysusers-view-toggle" class="col-xl-12 col-lg-12 col-md-6 col-sm-4 col-4 align-items-center justify-content-end pe-0">
                            <div class="input-group justify-content-end">
                                <!-- SORT BUTTON -->
                                <button id="sysusers-sort-standard" class="rsans btn justify-content-center align-items-center border" data-bs-toggle="modal" data-bs-target="#sysusers-sort-modal" aria-controls="sysusers-sort-modal" aria-label="System Users Sort Options">
                                    <i class="fa-solid fa-sort fs-4 text-secondary"></i>
                                    <p class="ms-2 mb-0 text-secondary">
                                        @php
                                            $activeSort = request()->input('sort', '');
                                        @endphp
                                        @switch ($activeSort)
                                            @case ('az') Name (A-Z) @break
                                            @case ('za') Name (Z-A) @break
                                            @case ('oldest') Oldest @break
                                            @case ('newest') Newest @break
                                            @case ('fm') Faculty members first @break
                                            @case ('student') Students first @break
                                            @default Sort
                                        @endswitch
                                    </p>
                                </button>
                            </div>
                        </div>
                        <x-sort-modal :type="'sysusers'"/>
                    </div>
                </div>
            </div>
        </div>
        <!-- BODY OF CONTENT -->
        <div class="row-container container-fluid align-items-center my-3 py-3 pb-4 pt-xl-4 pt-lg-4 pt-md-0 pt-0 mt-0">
            <div class="rsans row ms-xl-4 ms-lg-4 ms-md-0">
                <!-- LEFT SECTIONS FOR FILTERS -->
                <div id="sysusers-filters-standard" class="col-lg-3 col-12 border p-3 mb-3">
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
                                        <div class="form-check w-100 d-flex justify-content-start align-items-center clickable-wrapper">
                                            <label class="form-check-label flex-grow-1 text-start" for="{{ strtolower($category) }}">
                                                <input class="form-check-input me-2" type="checkbox" id="{{ strtolower($category) }}" name="category_filter[]" value="{{ $category }}" {{ in_array($category, $filters) ? 'checked' : '' }}>
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
                <!-- RIGHT SECTIONS FOR USERS LIST -->
                <div class="col-lg-9 col-12 px-0">
                    <div class="col-auto d-flex justify-content-center mt-xl-0 mt-lg-0 mt-md-3 mt-3">
                        {{ $allSystemUsers->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                    </div>
                    <div id="list-view" class="row list-view mx-0 px-3">
                        @foreach ($allSystemUsers as $user)
                            <div class="col-12 mb-3">
                                <x-systemuser-list-item :user="$user"/>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </main>
    <x-footer/>
</body>

</html>
