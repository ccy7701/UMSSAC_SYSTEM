<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $club->club_name }} | Manage Clubs</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    <x-topnav/>
    <br>
    <div class="container p-3">

        <!-- TOP SECTION -->
        <div class="d-flex align-items-center">
            <div class="row w-100">
                <div class="col-12 text-center">
                    <!-- BREADCRUMB NAV -->
                    <div class="row pb-3">
                        <div class="col-6 align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>';">
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                    <li class="breadcrumb-item active">Manage Club Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <p class="rsans mb-0 me-3 align-self-center">Last updated: {{ $club->updated_at }}</p>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary fw-semibold w-25">Go back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <div class="container-fluid align-items-center py-4">
            <!-- EDIT CLUB INFO SECTION -->
            <form>
                <div class="d-flex align-items-center">
                    <div class="section-header row w-100">
                        <div class="col-md-6 text-start">
                            <h3 class="rserif fw-bold w-100 py-2">Club info</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="#" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="container px-3 w-75">
                        <div class="form-group mb-3">
                            <label for="club-name" class="rsans fw-bold form-label">Club name</label>
                            <input type="text" id="club-name" name="club_name" class="rsans form-control" value="{{ $club->club_name }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="club-faculty" class="rsans fw-bold form-label">Faculty</label>
                            <input type="text" id="club-faculty" name="club_faculty" class="rsans form-control w-50" value="{{ $club->club_faculty }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="club-description" class="rsans fw-bold form-label">Club description</label>
                            <textarea id="club-description" name="club_description" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024" readonly>{{ $club->club_description }}</textarea>
                        </div>
                    </div>
                </div>
                <br>
            </form>
            <!-- END EDIT CLUB INFO SECTION -->

            <!-- EDIT CLUB IMAGES SECTION -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Club images</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="#" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start align-items-center py-4 w-100 align-self-center">
                @php
                    $clubImagePaths = json_decode($club->club_image_paths, true);
                @endphp
                @foreach ($clubImagePaths as $imagePath)
                    <!-- Display the image -->
                    <div class="position-relative me-4">
                        <img src="{{ asset($imagePath) }}" alt="Club illustration" class="img-fluid border" style="width: 128px; height: 128px; object-fit: cover;">
                    </div>
                @endforeach
            </div>
            <br>
            <!-- END EDIT CLUB IMAGES SECTION -->

            <!-- EDIT MEMBER ACCESS LEVEL FORM -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Members and access levels</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="#" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center py-3 w-75 align-self-center">
                
            </div>
            <!-- END EDIT MEMBER ACCESS LEVEL SECTION -->

            <!-- EDIT EVENTS SECTION -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Events</h3>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end mb-2">
                        <div class="input-group justify-content-end me-2">
                            <!-- Grid view toggle button -->
                            <button id="toggle-grid-view" class="btn d-flex justify-content-center align-items-center border toggle-view-btn {{ $searchViewPreference == 1 ? 'active' : '' }}">
                                <i class="fa fa-th fs-4 {{ $searchViewPreference == 1 ? 'text-primary' : 'text-muted' }}"></i>
                            </button>
                            <!-- List view toggle button -->
                            <button id="toggle-list-view" class="btn d-flex justify-content-center align-items-center border toggle-view-btn {{ $searchViewPreference == 2 ? 'active' : '' }}">
                                <i class="fa fa-list-ul fs-4 {{ $searchViewPreference == 2 ? 'text-primary' : 'text-muted' }}"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-3 py-4">
                <div class="col-md-12 px-3 py-0">
                    <!-- GRID VIEW (Toggle based on preference) -->
                    <div id="grid-view" class="row grid-view {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                        <!-- Add new club card, conditionally render only for committee members -->
                        {{ dump($isCommitteeMember) }}
                        <div class="col-lg-4 col-md-6">
                            <a href="#" class="text-decoration-none w-100">
                                <div class="card add-event-card d-flex justify-content-center align-items-center h-100">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                        <i class="fa fa-plus-circle fa-3x mb-2"></i>
                                        <h5 class="card-titel fw-bold">Add new event</5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @foreach ($clubEvents as $event)
                            <div class="col-lg-4 col-md-6">
                                <x-event-card :event="$event"/>
                            </div>
                        @endforeach
                    </div>
                    <!-- LIST VIEW (Toggle based on preference) -->
                    <div id="list-view" class="row list-view {{ $searchViewPreference == 2 ? '' : 'd-none' }} justify-content-center">
                        <div class="row pb-3 w-75">
                            <div class="col-lg-12">
                                <a href="#" class="text-decoration-none w-100">
                                    <div class="card add-event-list-item" id="list-item-manage">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                            <i class="fa fa-plus-circle fa-3x pt-2 pb-1"></i>
                                            <h5 class="card-title fw-bold pt-1 pb-0">Add new event</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @foreach ($clubEvents as $event)
                            <div class="row pb-3 w-75">
                                <div class="col-lg-12">
                                    <x-event-list-item :event="$event"/>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- END EDIT EVENTS SECTION -->
        </div>
    </div>
    <x-footer/>
</body>

</html>
