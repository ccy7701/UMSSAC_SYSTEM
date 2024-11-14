<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Joined Clubs</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    <x-topnav/>
    <x-about/>
    <main class="flex-grow-1 d-flex justify-content-center mt-xl-5 mt-lg-5">
        <div id="main-card" class="card">
            <!-- PAGE HEADER -->
            <div class="row-container align-items-center px-3 mt-lg-0 mt-md-3 mt-sm-3 mt-xs-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center mt-md-0 mt-sm-0 mt-xs-3 mt-3">
                        <h3 class="rserif fw-bold w-100 mb-1">Joined clubs</h3>
                        <p class="rserif fs-4 w-100 mt-0">
                            @if ($totalJoinedClubs == 0)
                                No joined clubs found
                            @elseif ($totalJoinedClubs == 1)
                                1 joined club found
                            @else
                                {{ $totalJoinedClubs }} joined clubs found
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
            <!-- BODY OF CONTENT -->
            <div class="row-container container-fluid align-items-center my-3 py-3 pb-4 pt-xl-4 pt-lg-4 pt-md-0 pt-0 mt-0">
                <div class="align-items-center w-100 px-0">
                    <div class="col-auto d-flex justify-content-center mt-xl-0 mt-lg-0 mt-md-3 mt-3">
                        {{ $joinedClubs->links('pagination::bootstrap-4') }}
                    </div>
                    <div id="grid-view" class="row grid-view ms-2 {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                        <div class="row pb-3 px-md-3 px-sm-0">
                            @foreach ($joinedClubs as $club)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6 mb-3 px-2">
                                    <x-club-card :club="$club"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- LIST VIEW (Toggle based on preference) -->
                    <div id="list-view" class="row list-view justify-content-start mx-0 {{ $searchViewPreference == 2 ? '' : 'd-none' }}">
                        @foreach ($joinedClubs as $club)
                            <div class="col-xl-6 col-12 mb-3">
                                <x-club-list-item :club="$club"/>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-auto d-flex justify-content-center">
                        {{ $joinedClubs->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
