<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage {{ $club->club_name }}</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    @vite('resources/js/imageViewer.js')
    <x-admin-topnav/>
    <x-about/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <!-- BREADCRUMB NAV -->
    <div id="club-breadcrumb" class="row w-80 justify-content-start mx-auto py-4 my-0">
        <!-- Breadcrumb links -->
        <div class="col-6 d-flex justify-content-start align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="rsans breadcrumb mb-0" style="--bs-breadcrumb-divider: '>';">
                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                    <li class="breadcrumb-item active">Manage Club Details</li>
                </ol>
            </nav>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center mb-xl-1 mb-lg-1 mb-0">
            <p class="rsans mb-0 align-self-center text-end">Last updated: {{ \Carbon\Carbon::parse($club->updated_at)->format('Y-m-d h:i A') }}</p>
            <a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-secondary fw-semibold w-25 text-center ms-2">Go back</a>
        </div>
    </div>
    <!-- ALT BREADCRUMB (COMPACT) -->
    <div id="club-breadcrumb-alt" class="row w-100 mx-auto py-3">
        <div class="col-4 d-flex justify-content-start align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="rsans breadcrumb m-0" style="--bs-breadcrumb-divider: '<';">
                    <li class="breadcrumb-item"></li>
                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">Go back</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-8 d-flex justify-content-end">
            <p class="rsans mb-0 me-1 justify-content-end">Last updated: {{ \Carbon\Carbon::parse($club->updated_at)->format('Y-m-d h:i A') }}</p>
        </div>
    </div>
    <main class="flex-grow-1 d-flex justify-content-center">
        <div id="main-card" class="card">
            <!-- CLUB INFO SECTION -->
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-lg-6 col-8 text-start mt-2">
                            <h3 class="rserif fw-bold w-100">Club info</h3>
                        </div>
                        <div class="col-lg-6 col-4 text-end align-self-center">
                            <a href="{{ route('admin-manage.edit-club-info', ['club_id' => $club->club_id]) }}" class="section-button rsans btn btn-primary fw-bold px-3">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-container d-flex justify-content-center align-items-center py-3">
                <form class="form-standard px-3">
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
                </form>
            </div>
            <!-- CLUB IMAGES SECTION -->
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-lg-6 col-8 text-start mt-2">
                            <h3 class="rserif fw-bold w-100">Club images</h3>
                        </div>
                        <div class="col-lg-6 col-4 text-end align-self-center">
                            <a href="{{ route('admin-manage.edit-images', ['club_id' => $club->club_id]) }}" class="section-button rsans btn btn-primary fw-bold px-3">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-container d-flex align-items-center">
                <div class="align-items-center w-100 px-3">
                    @php
                        $clubImagePaths = json_decode($club->club_image_paths, true);
                    @endphp
                    @if (!empty($clubImagePaths))
                        <div id="club-images-list" class="row py-4">
                            @foreach ($clubImagePaths as $index => $imagePath)
                                <div class="col-xl-2 col-md-3 col-sm-4 col-6 mb-4">
                                    <img src="{{ Storage::url($imagePath) }}" alt="Club illustration" class="img-fluid border" style="aspect-ratio: 4/4; object-fit: cover; cursor: pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#view-image-modal"
                                    data-image="{{ Storage::url($imagePath) }}"
                                    data-index="{{ $index + 1 }}">
                                </div>
                            @endforeach
                            <x-view-image-modal/>
                        </div>
                    @else
                        <p class="rsans text-center w-100 py-4">No images added yet</p>
                    @endif
                </div>
            </div>
            <!-- MEMBERS AND ACCESS LEVELS SECTION -->
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-lg-6 col-8 text-start mt-2">
                            <h3 class="rserif fw-bold w-100">Members and access levels</h3>
                        </div>
                        <div class="col-lg-6 col-4 text-end align-self-center">
                            <a href="{{ route('admin-manage.edit-member-access', ['club_id' => $club->club_id]) }}" class="section-button rsans btn btn-primary fw-bold px-3">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-container">
                <div class="align-items-center w-100 px-3">
                    @if ($clubMembers->isNotEmpty())
                        <div id="member-grid-view" class="row grid-view px-3 mt-3">
                            <x-members-carousel :carouselid="'carousel-inner-lg'" :members="$clubMembers"/>
                            <x-members-carousel :carouselid="'carousel-inner-md'" :members="$clubMembers"/>
                            <x-members-carousel :carouselid="'carousel-inner-sm'" :members="$clubMembers"/>
                        </div>
                    @else
                        <p class="rsans text-center w-100 py-4">No members in this club yet</p>
                    @endif
                </div>
            </div>
            <br>
            <!-- EVENTS SECTION -->
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-lg-6 col-8 text-start mt-2">
                            <h3 class="rserif fw-bold w-100">Events</h3>
                        </div>
                        <div class="col-lg-6 col-4 text-end align-self-center">
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
            </div>
            <div class="row-container container-fluid align-items-center my-3 py-3 pb-4 pt-xl-4 pt-lg-4 pt-md-0 pt-0 mt-0">
                <div class="align-items-center w-100 px-0">
                    <div class="col-auto d-flex justify-content-center mt-xl-0 mt-lg-0 mt-md-3 mt-3">
                        {{ $clubEvents->links('pagination::bootstrap-4') }}
                    </div>
                    @if ($clubEvents->isNotEmpty())
                        <!-- GRID VIEW (Toggle based on preference) -->
                        <div id="grid-view" class="row grid-view ms-2 {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                            <div class="row pb-3 px-md-3 px-sm-0">
                                @foreach ($clubEvents as $event)
                                    <div class="col-xl-4 col-lg-6 col-md-4 col-6 mb-3 px-2">
                                        <x-event-card
                                            :event="$event"
                                            :intersectionarray="$intersectionArray"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- LIST VIEW (Toggle based on preference) -->
                        <div id="list-view" class="row list-view justify-content-start mx-0 {{ $searchViewPreference == 2 ? '' : 'd-none' }}">
                            @foreach ($clubEvents as $event)
                                <div class="col-12 mb-3">
                                    <x-event-list-item
                                        :event="$event"
                                        :intersectionarray="$intersectionArray"/>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div id="grid-view" class="row grid-view d-none"></div>
                        <div id="list-view" class="row list-view d-none"></div>
                        <p class="rsans text-center w-100 py-2">No events recorded yet</p>
                    @endif
                    <div class="col-auto d-flex justify-content-center mt-xl-0 mt-1">
                        {{ $clubEvents->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
