<!DOCTYPE html>
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
    <x-success-message/>
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
                                    <li class="breadcrumb-item active">Manage Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <p class="rsans mb-0 me-3 align-self-center">Last updated: {{ $club->updated_at }}</p>
                            <a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-secondary fw-semibold w-25">Go back</a>
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
                            <a href="{{ route('admin-manage.edit-club-info', ['club_id' => $club->club_id]) }}" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
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
                            <label for="club-category" class="rsans fw-bold form-label">Category</label>
                            <input type="text" id="club-category" name="club_category" class="rsans form-control w-50" value="{{ $club->club_category }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="club-description" class="rsans fw-bold form-label">Description</label>
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
                        <a href="{{ route('admin-manage.edit-images', ['club_id' => $club->club_id]) }}" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start align-items-center py-4 w-100 align-self-center">
                @php
                    $clubImagePaths = json_decode($club->club_image_paths, true);
                @endphp
                @if (empty($clubImagePaths))
                    <div class="rsans position-relative me-4">
                        <p>No images added yet</p>
                    </div>
                @else
                    @foreach ($clubImagePaths as $imagePath)
                        <!-- Display the image -->
                        <div class="position-relative me-4">
                            <img src="{{ Storage::url($imagePath) }}" alt="Club illustration" class="img-fluid border" style="width: 128px; height: 128px; object-fit: cover;">
                        </div>
                    @endforeach
                @endif
            </div>
            <br>
            <!-- END EDIT CLUB IMAGES SECTION -->

            <!-- EDIT MEMBER ACCESS LEVEL SECTION -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Members and access levels</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin-manage.edit-member-access', ['club_id' => $club->club_id]) }}" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                    </div>
                </div>
            </div>
            <div class="container px-3 py-4">
                <div id="member-grid-view" class="row grid-view">
                    @foreach ($clubMembers as $member)
                        <div class="col-lg-3 col-md-4 py-2">
                            <x-member-card :member="$member"/>
                        </div>
                    @endforeach
                </div>
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
                        @foreach ($clubEvents as $event)
                            <div class="col-lg-4 col-md-6">
                                <x-event-card :event="$event"/>
                            </div>
                        @endforeach
                    </div>
                    <!-- LIST VIEW (Toggle based on preference) -->
                    <div id="list-view" class="row list-view {{ $searchViewPreference == 2 ? '' : 'd-none' }} justify-content-center">
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
