<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clubs Finder | UMSSACS</title>
    <meta name="description" content="Explore all campus clubs available on UMSSACS and find your next interest or passion.">
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    @vite('resources/js/searchInputToggle.js')
    @vite('resources/js/clubsFinderSort.js')
    @if (currentAccount()->account_role != 3)
        <x-topnav/>
    @else
        <x-admin-topnav/>
    @endif
    <x-about/>
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">Clubs finder</h3>
                        <p id="header-subtitle" class="rserif w-100 mt-0">
                            @if ($totalClubCount == 0)
                                No clubs found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @elseif ($totalClubCount == 1)
                                1 club found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @else
                                {{ $totalClubCount }} clubs found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @endif
                        </p>
                        <!-- SEARCH BAR -->
                        <div class="row pb-3">
                            <div class="col-12 px-0">
                                <form class="d-flex justify-content-center" method="GET" action="{{ route('clubs-finder') }}">
                                    <div id="search-bar-standard" class="input-group w-70 mb-4">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                        <input type="search" id="search-standard" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                        <button class="rsans btn btn-primary fw-bold">Search</button>
                                    </div>
                                    <div id="search-bar-compact" class="input-group w-90 mb-3">
                                        <input type="search" id="search-compact" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                        <button class="rsans btn btn-primary fw-bold">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- BREADCRUMB -->
                        <div class="row pb-3">
                            <!-- Left Column: Breadcrumb -->
                            <div id="club-breadcrumb" class="col-lg-8 align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="rsans breadcrumb mb-0" style="--bs-breadcrumb-divider: '>';">
                                        <li class="breadcrumb-item-active"><a href="{{ route('clubs-finder') }}">All Clubs</a></li>
                                    </ol>
                                </nav>
                            </div>
                            <!-- Left Column: Filters popout for smaller displays -->
                            <div id="club-filters-compact" class="col-xl-6 col-md-6 col-sm-8 col-8 align-items-center justify-content-start">
                                <div class="input-group justify-content-start">
                                    <button id="toggle-offcanvas-filters" class="rsans btn d-flex justify-content-center align-items-center border" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-filter" aria-controls="offcanvas-filter" aria-label="Toggle filters">
                                        <i class="fa-solid fa-filter fs-4 text-secondary"></i>
                                        <p class="ms-2 mb-0 text-secondary">Filters</p>
                                    </button>
                                    <button id="club-sort-compact" class="rsans btn justify-content-center align-items-center border" data-bs-toggle="modal" data-bs-target="#club-sort-modal" aria-controls="club-sort-modal" aria-label="Club Sort Options">
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
                                                @default Sort
                                            @endswitch
                                        </p>
                                    </button>
                                </div>
                            </div>
                            @php
                                $categoryFilters = $filters ?? [];
                            @endphp
                            <x-club-filters-tab :categoryfilters="$categoryFilters"/>
                            <!-- Right Column: View Icons -->
                            <div id="club-view-toggle" class="col-lg-4 col-md-6 col-sm-4 col-4 align-items-center justify-content-end">
                                <div class="input-group justify-content-end">
                                    <!-- SORT BUTTON -->
                                    <button id="club-sort-standard" class="rsans btn justify-content-center align-items-center border" data-bs-toggle="modal" data-bs-target="#club-sort-modal" aria-controls="club-sort-modal" aria-label="Club Sort Options">
                                        <i class="fa-solid fa-sort fs-4 text-secondary"></i>
                                        <p class="ms-2 mb-0 text-secondary">Sort</p>
                                    </button>
                                    <x-sort-modal :type="'club'"/>
                                    <!-- Grid view toggle button -->
                                    <button id="toggle-grid-view" class="btn d-flex justify-content-center align-items-center border toggle-view-btn {{ $searchViewPreference == 1 ? 'active' : '' }}">
                                        <i class="fa fa-th fs-4 {{ $searchViewPreference == 1 ? 'text-primary' : 'text-muted' }}"></i> <!-- Icon for grid view -->
                                    </button>
                                    <!-- List view toggle button -->
                                    <button id="toggle-list-view" class="btn d-flex justify-content-center align-items-center border toggle-view-btn {{ $searchViewPreference == 2 ? 'active' : '' }}">
                                        <i class="fa fa-list-ul fs-4 {{ $searchViewPreference == 2 ? 'text-primary' : 'text-muted' }}"></i> <!-- Icon for list view -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BODY OF CONTENT -->
        <div class="row-container container-fluid align-items-center my-3 py-3 pb-4 pt-xl-4 pt-lg-4 pt-md-0 pt-0 mt-0">
            <div class="rsans row ms-xl-4 ms-lg-4 ms-md-0">
                <!-- LEFT SECTIONS FOR FILTERS -->
                <div id="club-filters-standard" class="col-lg-3 col-12 border p-3 mb-3">
                    <div class="row">
                        <div class="col-xl-8 col-lg-6 col-6 d-flex align-items-center justify-content-start">
                            <h4 class="rsans fw-bold mb-0">Search filters</h4>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-6 d-flex align-items-center justify-content-end">
                            <form id="clear-filter-form" method="POST" action="{{ route('clubs-finder.clear-filter') }}" class="w-100 d-flex justify-content-end">
                                @csrf
                                <button id="filter-clear" class="rsans btn btn-secondary fw-bold px-2">Clear all</button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <form id="filter-form" method="POST" action="{{ route('clubs-finder.filter') }}">
                        @csrf
                        @php
                            $categories = [
                                'ASTIF', 'FIS', 'FKAL', 'FKIKK', 'FKIKAL',
                                'FKJ', 'FPEP', 'FPKS', 'FPL', 'FPPS', 'FPSK',
                                'FPT', 'FSMP', 'FSSA', 'FSSK', 'KKTF',
                                'KKTM', 'KKTPAR', 'KKAKF', 'KKUSIA', 'NR',
                                'General'
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
                            <button type="submit" class="rsans btn btn-primary fw-bold w-60">Apply filters</button>
                        </div>
                    </form>
                </div>
                <!-- RIGHT SECTION FOR CLUB CARDS GRID OR LIST -->
                <div class="col-lg-9 col-12 px-0">
                    <div class="col-auto d-flex justify-content-center mt-xl-0 mt-lg-0 mt-md-3 mt-3">
                        {{ $clubs->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                    </div>
                    <!-- GRID VIEW (Toggle based on preference) -->
                    <div id="grid-view" class="row grid-view ms-xl-3 ms-4 me-0 {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                        <div class="row pb-3 px-md-3 px-sm-0">
                            @foreach ($clubs as $club)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6 mb-3 px-2">
                                    <x-club-card :club="$club"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- LIST VIEW (Toggle based on preference) -->
                    <div id="list-view" class="row list-view mx-0 px-3 {{ $searchViewPreference == 2 ? '' : 'd-none' }}">
                        @foreach ($clubs as $club)
                            <div class="col-xl-6 col-12 mb-3">
                                <x-club-list-item :club="$club"/>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-auto d-flex justify-content-center">
                        {{ $clubs->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
