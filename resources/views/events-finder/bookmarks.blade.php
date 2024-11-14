<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bookmarked Events</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    @vite('resources/js/searchInputToggle.js')
    @if (currentAccount()->account_role != 3)
        <x-topnav/>
    @else
        <x-admin-topnav/>
    @endif
    <x-about/>
    <main class="flex-grow-1 d-flex justify-content-center mt-xl-5 mt-lg-5">
        <div id="main-card" class="card">
            <!-- PAGE HEADER -->
            <div class="row-container align-items-center px-3 mt-lg-0 mt-md-3 mt-sm-3 mt-xs-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center mt-md-0 mt-sm-0 mt-xs-3 mt-3">
                        <h3 class="rserif fw-bold w-100 mb-1">Bookmarked events</h3>
                        <p id="header-subtitle" class="rserif w-100 mt-0">
                            @if ($totalBookmarks == 0)
                                No bookmarks found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @elseif ($totalBookmarks == 1)
                                1 bookmark found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @else
                                {{ $totalBookmarks }} bookmarks found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @endif
                        </p>
                        <!-- SEARCH BAR -->
                        <div class="row pb-3">
                            <div class="col-xl-9 col-md-9 col-sm-8 col-8 ps-3 pe-0">
                                <form class="d-flex justify-content-center" method="GET" action="{{ route('events-finder.bookmarks') }}">
                                    <div id="search-bar-standard" class="input-group w-100">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                        <input type="search" id="search-standard" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                        <button class="rsans btn btn-primary fw-bold">Search</button>
                                    </div>
                                    <div id="search-bar-compact" class="input-group w-100">
                                        <input type="search" id="search-compact" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                        <button class="rsans btn btn-primary fw-bold">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div id="club-view-toggle" class="col-xl-3 col-md-3 col-sm-4 col-4 align-items-center justify-content-end">
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
            <div class="row-container container-fluid align-items-center my-3 py-3 px-4">
                <div class="rsans row">
                    <div class="col-12 px-0">
                        <!-- GRID VIEW (Toggle based on preference) -->
                        <div id="grid-view" class="row grid-view ms-2 {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                            <div class="row pb-3 px-md-3 px-sm-0">
                                @foreach ($bookmarks as $bookmark)
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-6 mb-3 px-2">
                                        <x-event-card
                                            :event="$bookmark->event"
                                            :intersectionarray="$intersectionArray"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- LIST VIEW (Toggle based on preference) -->
                        <div id="list-view" class="row list-view mx-0 {{ $searchViewPreference == 2 ? '' : 'd-none' }}">
                            @foreach ($bookmarks as $bookmark)
                                <div class="col-12 mb-3">
                                    <x-event-list-item
                                        :event="$bookmark->event"
                                        :intersectionarray="$intersectionArray"/>
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
