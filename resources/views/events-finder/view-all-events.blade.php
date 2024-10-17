<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Events Finder</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    @if (currentAccount()->account_role != 3)
        <x-topnav/>
    @else
        <x-admin-topnav/>
    @endif
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">Events finder</h3>
                        <p id="event-count-display" class="rserif fs-4 w-100 mt-0">
                            @if ($totalEventCount == 0)
                                No events found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @elseif ($totalEventCount == 1)
                                1 event found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @else
                                {{ $totalEventCount }} events found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @endif
                        </p>
                        <!-- SEARCH TAB -->
                        <form class="d-flex justify-content-center" method="GET" action="{{ route('events-finder') }}">
                            <div class="search-tab mb-4">
                                <div class="input-group">
                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                    <input type="search" id="event-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                    <button class="rsans btn btn-primary fw-bold">Search</button>
                                </div>
                            </div>
                        </form>
                        <!-- BREADCRUMB NAV -->
                        <div class="row pb-3">
                            <!-- Left Column: Breadcrumb -->
                            <div id="event-breadcrumb" class="col-lg-8 align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="rsans breadcrumb mb-0" style="--bs-breadcrumb-divider: '>';">
                                        <li class="breadcrumb-item-active"><a href="{{ route('events-finder') }}">All Events</a></li>
                                    </ol>
                                </nav>
                            </div>
                            <!-- Right Column: View Icons -->
                            <div id="club-view-toggle" class="col-lg-4 col-md-12 col-12 align-items-center justify-content-end">
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
        </div>
        <!-- BODY OF CONTENT -->
        <div class="row-container container-fluid align-items-center my-3 py-3 px-4">
            <div class="rsans row">
                <!-- LEFT SECTIONS FOR FILTERS -->
                <div class="col-xl-2 col-lg-3 col-12 border p-3 mb-3">
                    <div class="d-flex justify-content-center">
                        <!-- Toggle button visible below 992px -->
                        <button id="filter-toggle-btn" class="btn btn-muted d-lg-none mb-2 border w-50" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filter-collapse" aria-expanded="false" aria-controls="filter-collapse">
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
                                <form id="clear-filter-form" method="POST" action="{{ route('events-finder.clear-filter') }}" class="w-100 d-flex justify-content-end">
                                    @csrf
                                    <button id="filter-clear" class="rsans btn btn-secondary fw-bold px-2">Clear all</button>
                                </form>
                            </div>
                        </div>
                        <br>
                        <form id="filter-form" method="POST" action="{{ route('events-finder.filter') }}">
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
                                            <div class="form-check w-50">
                                                <input class="form-check-input" type="checkbox" id="{{ strtolower($category) }}" name="category_filter[]" value="{{ $category }}" {{ in_array($category, $filters['category_filter'] ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ strtolower($category) }}">
                                                    {{ $category }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <h5 class="rsans fw-semibold mb-2">Event Status</h5>
                            <div class="rsans row">
                                <div class="col-6 mb-2 px-1">
                                    <div class="p-2 border rounded">
                                        <div class="form-check w-50">
                                            <input class="form-check-input" type="checkbox" id="incoming" name="event_status[]" value="1" {{ in_array(1, $filters['event_status'] ?? []) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="incoming">Incoming</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-2 px-1">
                                    <div class="p-2 border rounded">
                                        <div class="form-check w-50">
                                            <input class="form-check-input" type="checkbox" id="closed" name="event_status[]" value="0" {{ in_array(0, $filters['event_status'] ?? []) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="closed">Closed</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-3 d-flex justify-content-center">
                                <button type="submit" class="rsans btn btn-primary fw-bold w-60">Apply filters</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- RIGHT SECTION FOR EVENT CARDS GRID OR LIST -->
                <div class="col-lg-9 col-12 px-0">
                    <!-- GRID VIEW (Toggle based on preference) -->
                    <div id="grid-view" class="row grid-view ms-2 {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                        <div class="rsans row d-flex justify-content-center">
                            <div class="col-auto">
                                {{ $events->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <div class="row pb-3 px-md-3 px-sm-0">
                            @foreach ($events as $event)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6 mb-3 px-2">
                                    <x-event-card
                                        :event="$event"
                                        :intersectionarray="$intersectionArray"/>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- LIST VIEW (Toggle based on preference) -->
                    <div id="list-view" class="row list-view ms-2 {{ $searchViewPreference == 2 ? '' : 'd-none' }}">
                        <div class="rsans row d-flex justify-content-center">
                            <div class="col-auto">
                                {{ $events->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        @foreach ($events as $event)
                            <div class="row pb-3">
                                <x-event-list-item
                                    :event="$event"
                                    :intersectionarray="$intersectionArray"/>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
