<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Finder</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    <x-topnav/>
    <br>
    <div class="container p-3">
        
        <div class="d-flex align-items-center">

            <!-- TOP SECTION -->
            <div class="section-header row w-100">
                <div class="col-12 text-center">
                    <h3 class="rserif fw-bold w-100 mb-1">Events finder</h3>
                    <p class="rserif fs-4 w-100 mt-0">{123} events found</p>
                    <!-- SEARCH TAB -->
                    <form class="d-flex justify-content-center">
                        <div class="mb-4 w-50">
                            <div class="input-group">
                                <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                <input type="search" id="event-search" class="rsans form-control" aria-label="search" placeholder="Search...">
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
                                    <li class="breadcrumb-item"><a href="#">All Events</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Search Results</li>
                                </ol>
                            </nav>
                        </div>
                        <!-- Right Column: View Icons -->
                        <div class="col-6 d-flex align-items-center justify-content-end">
                            <p class="rsans mb-0">
                                View: 
                                <i class="fa fa-th fs-5 ps-3 pe-2 text-primary"></i>
                                <i class="fa fa-list-ul fs-5 ps-2 text-muted"></i>
                            </p>
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
                    <!-- Faculty filters -->
                    <h4 class="rserif fw-bold fs-5">Faculty</h4>
                    <ul class="rsans list-group py-2">
                        <li class="list-group-item">
                            <input type="checkbox" id="fkikk" checked>
                            <label for="fkikk">FKIKK</label>
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="fkikal">
                            <label for="fkikal">FKIKAL</label>
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="astif">
                            <label for="astif">ASTIF</label>
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="fsmp">
                            <label for="fsmp">FSMP</label>
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="fpp">
                            <label for="fpp">FPP</label>
                        </li>
                    </ul>
                    <br>
                    <!-- Event status filters -->
                    <h4 class="rserif fw-bold fs-5">Event status</h4>
                    <ul class="rsans list-group py-2">
                        <li class="list-group-item">
                            <input type="checkbox" id="incoming">
                            <label for="incoming">Incoming</label>
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="closed">
                            <label for="closed">Closed</label>
                        </li>
                    </ul>
                </div>

                <!-- RIGHT SECTION FOR EVENT CARDS GRID -->
                <div class="col-md-9 px-3 py-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 pb-4">
                                <x-event-card/>
                            </div>
                            <div class="col-lg-4 col-md-6 pb-4">
                                <x-event-card/>
                            </div>
                            <div class="col-lg-4 col-md-6 pb-4">
                                <x-event-card/>
                            </div>
                            <div class="col-lg-4 col-md-6 pb-4">
                                <x-event-card/>
                            </div>
                            <div class="col-lg-4 col-md-6 pb-4">
                                <x-event-card/>
                            </div>
                            <div class="col-lg-4 col-md-6 pb-4">
                                <x-event-card/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <x-footer/>
</body>

</html>