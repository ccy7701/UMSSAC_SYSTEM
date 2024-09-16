<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $club->club_name }} | Clubs Finder</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/itemViewToggler.js')
    <x-topnav/>
    <x-success-message/>
    <x-leave-message/>
    <br>
    <div class="container p-3">

        <div class="d-flex align-items-center">
            <!-- TOP SECTION -->
            <div class="row w-100">
                <div class="col-12 text-center">
                    <!-- BREADCRUMB NAV -->
                    <div class="row pb-3">
                        <div class="col-6 align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>';">
                                    <li class="breadcrumb-item"><a href="{{ route('clubs-finder') }}">All Clubs</a></li>
                                    <li class="breadcrumb-item active">{{ $club->club_name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            @if ($isCommitteeMember)
                                <p class="rsans mb-0 me-3 align-self-center">Last updated: {{ $club->updated_at }}</p>
                                <a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-primary fw-semibold align-self-center">Manage club details</a>
                            @else
                                <p class="rsans text-end">Last updated: {{ $club->updated_at }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BODY OF CONTENT -->
        <div class="container-fluid align-items-center py-4">
            <!-- Club images carousel -->
            <div class="row w-100 justify-content-center align-items-center">
                @php
                    $clubImagePaths = json_decode($club->club_image_paths, true);
                @endphp
                <div id="clubImagesCarousel" class="carousel slide carousel-fade w-30" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner">
                        @if (empty($clubImagePaths))
                            <div class="carousel-item active">
                                <img src="{{ asset('images/no_club_images_default.png') }}"  class="d-block w-100" alt="No club illustration found" style="aspect-ratio: 4/4; object-fit: cover;">
                            </div>
                        @else
                            <div class="carousel-item active">
                                <img src="{{ Storage::url($clubImagePaths[0]) }}" class="d-block w-100" alt="Club illustration" style="aspect-ratio: 4/4; object-fit: cover;">
                            </div>
                            @foreach(array_slice($clubImagePaths, 1) as $imagePath)
                                <div class="carousel-item">
                                    <img src="{{ Storage::url($imagePath) }}" class="d-block w-100" alt="Club illustration" style="aspect-ratio: 4/4; object-fit: cover;">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#clubImagesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#clubImagesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
            <br>
            <!-- Club description -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2 px-3 mb-2">{{ $club->club_name }}</h3>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                        <i class="fa fa-university text-muted mb-2 me-3"></i>
                        <h3 class="rserif fw-bold text-muted mb-2">{{ $club->club_category }}</h3>
                    </div>
                </div>
            </div>
            <div class="container px-3 py-4">
                <h5 class="rserif fw-bold">About this club</h5>
                <p class="rsans pb-3">{{ $club->club_description }}</p>
                <h5 class="rserif fw-bold">Club creation date</h5>
                <p class="rsans pb-3">{{ $club->created_at }}</p>
            </div>
            <!-- Members section -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <!-- Left column: Members header -->
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2 px-3 pb-2">Members</h3>
                    </div>
                    <div class="col-md-6 text-end"></div>
                </div>
            </div>
            <div class="container px-3 py-4">
                <div id="member-grid-view" class="row grid-view"> <!-- keep this row in view -->
                    @if ($clubMembers->isNotEmpty())
                        @foreach ($clubMembers as $member)
                            <div class="col-lg-3 col-md-4 py-2">
                                <x-member-card :member="$member"/>
                            </div>
                        @endforeach
                        <div class="rsans d-flex justify-content-center">
                            {{ $clubMembers->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <p class="rsans">No members in this club yet</p>
                    @endif
                </div>
            </div>
            <br>
            <!-- End members section -->
            <!-- Events conducted -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <!-- Left column: Events header -->
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2 px-3 mb-2">Events</h3>
                    </div>
                    <!-- Right column: View icons -->
                    <div class="col-md-6 d-flex align-items-center justify-content-end mb-2">
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
            <div class="container px-3 py-4">
                <div class="col-md-12 px-3 py-0">
                    <!-- GRID VIEW (Toggle based on preference) -->
                    <div id="grid-view" class="row grid-view {{ $searchViewPreference == 1 ? '' : 'd-none' }}">
                        @if ($clubEvents->isNotEmpty())
                            @foreach ($clubEvents as $event)
                                <div class="col-lg-4 col-md-6">
                                    <x-event-card :event="$event"/>
                                </div>
                            @endforeach
                            <div class="rsans d-flex justify-content-center">
                                {{ $clubEvents->links('pagination::bootstrap-4') }}
                            </div>
                        @else
                            <p class="rsans">No events recorded yet</p>
                        @endif
                    </div>
                    <!-- LIST VIEW (Toggle based on preference) -->
                    <div id="list-view" class="row list-view {{ $searchViewPreference == 2 ? '' : 'd-none' }} justify-content-center">
                        @if ($clubEvents->isNotEmpty())
                            @foreach ($clubEvents as $event)
                                <div class="row pb-3 w-75">
                                    <div class="col-lg-12">
                                        <x-event-list-item :event="$event" />
                                    </div>
                                </div>
                            @endforeach
                            <div class="rsans d-flex justify-content-center">
                                {{ $clubEvents->links('pagination::bootstrap-4') }}
                            </div>
                        @else
                            <p class="rsans">No events recorded yet</p>
                        @endif
                    </div>
                </div>
            </div>
            <br>
            <!-- End events conducted -->
            <!-- Membership - join or leave -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2 px-3 mb-2">Membership</h3>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
            <div class="container px-3 py-4 d-flex align-items-center justify-content-center">
                <div class="row w-75">
                    @if (!in_array(profile()->profile_id, $clubMembers->pluck('profile_id')->toArray()))
                        <div class="rsans card text-center p-0">
                            <div class="card-body align-items-center justify-content-center">
                                <p class="card-text">Click the button below to become a member of this club.</p>
                                <form id="join-club-form" method="POST" action="{{ route('clubs-finder.join-club') }}">
                                    @csrf
                                    <input type="hidden" name="profile_id" value="{{ profile()->profile_id }}">
                                    <input type="hidden" name="club_id" value="{{ $club->club_id }}">
                                    <button type="submit" class="btn btn-primary fw-semibold align-self-center w-20">Join club</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="rsans card text-center p-0">
                            <div class="card-body align-items-center justify-content-center">
                                <p class="card-text">Click the button below to leave from this club.</p>
                                <button type="button" class="btn btn-danger fw-semibold align-self-center w-20"
                                    data-bs-toggle="modal"
                                    data-bs-target="#leave-club-confirmation-modal">Leave club</button>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Leave club confirmation modal -->
                <div class="rsans modal fade" id="leave-club-confirmation-modal" tabindex="-1" aria-labelledby="leaveClubConfirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-2 d-flex align-items-center">
                                <p class="fw-semibold fs-5 mb-0">
                                    Leave club confirmation
                                </p>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to leave {{ $club->club_name }}?
                            </div>
                            <div class="modal-footer">
                                <form id="leave-club-form" method="POST" action="{{ route('clubs-finder.leave-club') }}">
                                    @csrf
                                    <input type="hidden" name="profile_id" value="{{ profile()->profile_id }}">
                                    <input type="hidden" name="club_id" value="{{ $club->club_id }}">
                                    <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                                    <button type="submit" class="btn btn-danger fw-semibold ms-1">Yes, continue</button>
                                </form>
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
