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

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    <x-admin-topnav/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <main class="flex-grow-1">
        <!-- BREADCRUMB NAV -->
        <div class="row-container">
            <div id="club-breadcrumb" class="row">
                <div class="col-xl-6 col-lg-5 col-5 d-flex align-items-center mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>'; margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                            <li class="breadcrumb-item active">{{ $club->club_name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-6 col-lg-7 col-7 d-flex justify-content-end align-items-center mb-4">
                    <p class="rsans mb-0 me-3">Last updated: {{ \Carbon\Carbon::parse($club->updated_at)->format('Y-m-d h:i A') }}</p>
                    <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="section-button-short rsans btn btn-primary fw-semibold text-center">Manage club</a>
                </div>
            </div>
            <div id="club-breadcrumb-alt" class="row w-100 mx-0">
                <div id="club-breadcrumb-alt" class="col-4 align-items-baseline mb-2">
                    <nav aria-label="breadcrumb">
                        <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '<';">
                            <li class="breadcrumb-item"></li>
                            <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">Go back</a></li>
                        </ol>
                    </nav>
                </div>
                <div id="club-breadcrumb-alt" class="col-8 d-flex justify-content-end mb-2">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <p class="rsans mb-0 me-2 justify-content-end">Last updated: {{ \Carbon\Carbon::parse($club->updated_at)->format('Y-m-d h:i A') }}</p>
                        </div>
                        <div class="col-12 d-flex justify-content-end mb-3">
                            <a id="btn-manage-club-compact" href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="section-button-short rsans btn btn-primary fw-semibold text-center me-2">Manage club</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <!-- CLUB IMAGES CAROUSEL -->
        <div class="row-container">
            <div class="row w-100 justify-content-center align-items-center mx-0">
                @php
                    $clubImagePaths = json_decode($club->club_image_paths, true);
                @endphp
                <div id="club-images-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner">
                        @if (!empty($clubImagePaths))
                            <div class="carousel-item active">
                                <img src="{{ Storage::url($clubImagePaths[0]) }}" class="d-block w-100" alt="Club illustration" style="aspect-ratio: 4/4; object-fit: cover;">
                            </div>
                            @foreach(array_slice($clubImagePaths, 1) as $imagePath)
                                <div class="carousel-item">
                                    <img src="{{ Storage::url($imagePath) }}" class="d-block w-100" alt="Club illustration" style="aspect-ratio: 4/4; object-fit: cover;">
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <img src="{{ asset('images/no_club_images_default.png') }}" class="d-block w-100" alt="No club illustration found" style="aspect-ratio: 4/4; object-fit: cover;">
                            </div>
                        @endif
                    </div>
                    <button class="carousel-control-prev ms-2" type="button" data-bs-target="#club-images-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next me-2" type="button" data-bs-target="#club-images-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        <br>
        <!-- CLUB DESCRIPTION -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-left-alt col-lg-6 col-md-6 col-12 mt-2">
                        <h3 class="rserif fw-bold w-100">{{ $club->club_name }}</h3>
                    </div>
                    <div class="col-right-alt col-lg-6 col-md-6 col-12 mt-xl-2 mt-sm-0 d-flex align-items-center">
                        <i class="fa fa-university text-muted mb-2 me-3"></i>
                        <h3 class="rserif fw-bold text-muted">{{ $club->club_category }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-container">
            <div class="container px-3 py-4">
                <h5 class="rserif fw-bold">About this club</h5>
                <p class="rsans pb-3">{{ $club->club_description }}</p>
                <h5 class="rserif fw-bold">Club creation date</h5>
                <p class="rsans pb-3">{{ \Carbon\Carbon::parse($club->created_at)->format('Y-m-d h:i A') }}</p>
            </div>
        </div>
        <!-- MEMBERS -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-12">
                        <h3 class="rserif fw-bold w-100">Members</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-container">
            <div class="align-items-center w-100 px-3">
                @if ($clubMembers->isNotEmpty())
                    <div id="member-grid-view" class="row grid-view px-3 mt-3">
                        <div class="rsans row d-flex justify-content-center">
                            <div class="col-auto">
                                {{ $clubMembers->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        @foreach ($clubMembers as $member)
                            <div class="col-lg-3 col-md-4 col-6 py-2">
                                <x-member-card :member="$member"/>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="rsans text-center w-100 py-4">No members in this club yet</p>
                @endif
            </div>
            <br>
        </div>
        <!-- EVENTS -->
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
        <div class="row-container">
            <div class="align-items-center w-100 px-3">
                <!-- GRID VIEW (Toggle based on preference) -->
                <div id="grid-view" class="row grid-view ms-2 {{ $searchViewPreference == 1 ? '' : 'd-none' }} mt-3">
                    @if ($clubEvents->isNotEmpty())
                        <div class="rsans row d-flex justify-content-center">
                            <div class="col-auto">
                                {{ $clubEvents->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <div class="row pb-3 px-md-3 px-sm-0">
                            @foreach ($clubEvents as $event)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6 mb-3 px-2">
                                    <x-event-card :event="$event"/>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="rsans text-center w-100 py-4">No events recorded yet</p>
                    @endif
                </div>
                <!-- LIST VIEW (Toggle based on preference) -->
                <div id="list-view" class="row list-view {{ $searchViewPreference == 2 ? '' : 'd-none' }} justify-content-center mt-3">
                    @if ($clubEvents->isNotEmpty())
                        <div class="rsans row d-flex justify-content-center">
                            <div class="col-auto">
                                {{ $clubEvents->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        @foreach ($clubEvents as $event)
                            <div class="row pb-3">
                                <x-event-list-item :event="$event"/>
                            </div>
                        @endforeach
                    @else
                        <p class="rsans text-center w-100 py-4">No events recorded yet</p>
                    @endif
                </div>
            </div>
        </div>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
