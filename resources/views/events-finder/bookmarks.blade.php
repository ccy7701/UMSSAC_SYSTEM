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
                        <h3 class="rserif fw-bold w-100 mb-1">Bookmarked events</h3>
                        <p id="event-bookmark-count-display" class="rserif fs-4 w-100 mt-0">
                            @if ($totalBookmarks == 0)
                                No bookmarks found
                            @elseif ($totalBookmarks == 1)
                                1 bookmark found
                            @else
                                {{ $totalBookmarks }} bookmarks found
                            @endif
                        </p>
                        <div class="row pb-3">
                            <div id="club-view-toggle" class="col-12 align-items-center justify-content-end">
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
                <div class="col-12 px-0">
                    <!-- GRID VIEW (Toggle based on preference) -->
                    <div id="grid-view" class="row grid-view ms-2 {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                        <div class="row pb-3 px-md-3 px-sm-0">
                            @foreach ($bookmarkedEvents as $bookmark)
                                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-3 px-2">
                                    <x-event-card :event="$bookmark->event"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- LIST VIEW (Toggle based on preference) -->
                    <div id="list-view" class="row list-view ms-2 {{ $searchViewPreference == 2 ? '' : 'd-none' }} mt-0">
                        @foreach ($bookmarkedEvents as $bookmark)
                            <div class="row pb-3">
                                <x-event-list-item :event="$bookmark->event"/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
