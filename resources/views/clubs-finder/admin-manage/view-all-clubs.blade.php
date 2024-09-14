<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Clubs</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    <x-topnav/>
    <br>
    <div class="container p-3">

        <div class="d-flex align-items-center">

            <!-- TOP SECTION -->
            <div class="section-header row w-100">
                <div class="col-12 text-center">
                    <h3 class="rserif fw-bold w-100 mb-1">Manage clubs</h3>
                    <p id="club-count-display" class="rserif fs-4 w-100 mt-0">
                        @if ($totalClubCount == 0)
                            No clubs found{{ $search ? ' for search term "' . $search . '"' : '' }}
                        @elseif ($totalClubCount == 1)
                            1 club found{{ $search ? ' for search term "' . $search . '"' : '' }}
                        @else
                            {{ $totalClubCount }} clubs found{{ $search ? ' for search term "' . $search . '"' : '' }}
                        @endif
                    </p>
                    <!-- SEARCH TAB -->
                    <form class="d-flex justify-content-center" method="GET" action="{{ route('manage-clubs') }}">
                        <div class="mb-4 w-50">
                            <div class="input-group">
                                <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                <input type="search" id="club-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search...">
                                <button class="rsans btn btn-primary fw-bold">Search</button>
                            </div>
                        </div>
                    </form>
                    <!-- BREADCRUMB NAV -->
                    <div class="row pb-3">
                        <!-- Left Column: Breadcrumb -->
                        <div class="col-6 d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="rsans breadcrumb mb-0" style="--bs-breadcrumb-divider: '>';">
                                    <li class="breadcrumb-item-active"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                                </ol>
                            </nav>
                        </div>
                        <!-- Right Column: View Icons -->
                        <div class="col-6 d-flex align-items-center justify-content-end">
                            <div class="input-group justify-content-end">
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
                            <form id="clear-filter-form" method="POST" action="{{ route('manage-clubs.clear-filter') }}">
                                @csrf
                                <button class="rsans btn btn-secondary fw-bold px-2">Clear all</button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <form id="filter-form" method="POST" action="{{ route('manage-clubs.filter') }}">
                        @csrf
                        @php
                            $categories = [
                                'ASTIF', 'FIS', 'FKAL', 'FKIKK', 'FKIKAL',
                                'FKJ', 'FPEP', 'FPL', 'FPP', 'FPSK',
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
                            <button type="submit" class="rsans btn btn-primary fw-bold w-60">Apply filters</button>
                        </div>
                    </form>
                </div>
                <!-- RIGHT SECTION FOR CLUB CARDS GRID OR LIST -->
                <div class="col-md-9 px-3 py-0">
                    <div class="container-fluid">
                        <!-- GRID VIEW (Toggle based on preference) -->
                        <div id="grid-view" class="row grid-view {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                            <!-- Add new club card -->
                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                <a href="{{ route('manage-clubs.add-new-club') }}" class="text-decoration-none w-100">
                                    <div class="card add-club-card d-flex justify-content-center align-items-center h-100">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                            <i class="fa fa-plus-circle fa-3x mb-2"></i>
                                            <h5 class="card-title fw-bold">Add new club</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Existing clubs' cards -->
                            @foreach($clubs as $club)
                                <div class="col-lg-4 col-md-6">
                                    <x-manage-club-card :club="$club"/>
                                </div>
                            @endforeach
                        </div>
                        <!-- LIST VIEW (Toggle based on preference) -->
                        <div id="list-view" class="row list-view {{ $searchViewPreference == 2 ? '' : 'd-none' }}">
                            <!-- Add new club list item -->
                            <div class="row pb-3">
                                <div class="col-lg-12">
                                    <a href="{{ route('manage-clubs.add-new-club') }}" class="text-decoration-none w-100">
                                        <div class="card add-club-list-item" id="list-item-manage">
                                            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                                <i class="fa fa-plus-circle fa-3x pt-2 pb-1"></i>
                                                <h5 class="card-title fw-bold pt-1 pb-0">Add new club</5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @foreach($clubs as $club)
                                <div class="row pb-3">
                                    <div class="col-lg-12">
                                        <x-manage-club-list-item :club="$club"/>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</body>

</html>
