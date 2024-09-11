<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clubs Finder</title>
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
                    <h3 class="rserif fw-bold w-100 mb-1">Clubs finder</h3>
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
                    <form class="d-flex justify-content-center" method="GET" action="{{ route('clubs-finder') }}">
                        <div class="mb-4 w-50">
                            <div class="input-group">
                                <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                <input type="search" id="club-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
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
                                    <li class="breadcrumb-item-active"><a href="{{ route('clubs-finder') }}">All Clubs</a></li>
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
                            <form id="clear-filter-form" method="POST" action="{{ route('clubs-finder.clear-filter') }}">
                                @csrf
                                <button class="rsans btn btn-secondary fw-bold px-2">Clear all</button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <h5 class="rsans fw-semibold mb-0">Faculty</h5>
                    <form id="filter-form" method="POST" action="{{ route('clubs-finder.filter') }}">
                        @csrf
                        <ul class="rsans list-group py-2">
                            <li class="list-group-item">
                                <input type="checkbox" id="fkikk" name="faculty_filter[]" value="FKIKK" {{ in_array('FKIKK', $filters) ? 'checked' : '' }}>
                                <label for="fkikk">FKIKK</label>
                            </li>
                            <li class="list-group-item">
                                <input type="checkbox" id="fkikal" name="faculty_filter[]" value="FKIKAL" {{ in_array('FKIKAL', $filters) ? 'checked' : '' }}>
                                <label for="fkikal">FKIKAL</label>
                            </li>
                            <li class="list-group-item">
                                <input type="checkbox" id="astif" name="faculty_filter[]" value="ASTIF" {{ in_array('ASTIF', $filters) ? 'checked' : '' }}>
                                <label for="astif">ASTIF</label>
                            </li>
                            <li class="list-group-item">
                                <input type="checkbox" id="fsmp" name="faculty_filter[]" value="FSMP" {{ in_array('FSMP', $filters) ? 'checked' : '' }}>
                                <label for="fsmp">FSMP</label>
                            </li>
                            <li class="list-group-item">
                                <input type="checkbox" id="fpp" name="faculty_filter[]" value="FPP" {{ in_array('FPP', $filters) ? 'checked' : '' }}>
                                <label for="fpp">FPP</label>
                            </li>
                        </ul>
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
                            @foreach($clubs as $club)
                                <div class="col-lg-4 col-md-6">
                                    <x-club-card :club="$club"/>
                                </div>
                            @endforeach
                        </div>
                        <!-- LIST VIEW (Toggle based on preference) -->
                        <div id="list-view" class="row list-view {{ $searchViewPreference == 2 ? '' : 'd-none' }}">
                            @foreach($clubs as $club)
                                <div class="row pb-3">
                                    <div class="col-lg-12">
                                        <x-club-list-item :club="$club"/>
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
