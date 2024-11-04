<!DOCTYPE HTML>
<html lang="en" xml:lang="en">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->event_name }} | UMSSACS</title>
    <meta name="description" content="{{ $event->event_description ?? 'See the full details for this event at UMSSACS.' }}">
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/imageViewer.js')
    @if (currentAccount()->account_role != 3)
        <x-topnav/>
    @else
        <x-admin-topnav/>
    @endif
    <x-about/>
    <x-response-popup
        messageType="bookmark-create"
        iconClass="text-primary fa-solid fa-bookmark"
        title="Event bookmark created."/>
    <x-response-popup
        messageType="bookmark-delete"
        iconClass="text-primary fa-regular fa-bookmark"
        title="Event bookmark deleted."/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <main class="flex-grow-1">
        <!-- BREADCRUMB NAV -->
        <div class="row-container">
            <div id="event-breadcrumb" class="row">
                <div class="col-xl-6 col-lg-5 col-5 d-flex align-items-center mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>'; margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('events-finder') }}">All Events</a></li>
                            <li class="breadcrumb-item">
                                @if (currentAccount()->account_role != 3)
                                    <a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a>
                                @else
                                    <a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a>
                                @endif
                            </li>
                            <li class="breadcrumb-item active">{{ $event->event_name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-6 col-lg-7 col-7 d-flex justify-content-end align-items-center mb-4">
                    <p class="rsans mb-0 me-3 align-self-center text-end">Last updated: {{ \Carbon\Carbon::parse($event->updated_at)->format('Y-m-d h:i A') }}</p>
                    @if ($isCommitteeMember)
                        <a href="{{ route('events-finder.manage-details', [
                            'event_id' => $event->event_id,
                            'club_id' => $club->club_id,
                        ]) }}" class="rsans btn btn-primary fw-semibold align-self-center">Manage event details</a>
                    @endif
                </div>
            </div>
            <div id="event-breadcrumb-alt" class="row w-100 mx-0">
                <div id="event-breadcrumb-alt" class="col-4 align-items-baseline mb-2">
                    <nav aria-label="breadcrumb">
                        <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '<';">
                            <li class="breadcrumb-item"></li>
                            <li class="breadcrumb-item"><a href="{{ route('events-finder') }}">All Events</a></li>
                        </ol>
                    </nav>
                </div>
                <div id="event-breadcrumb-alt" class="col-8 d-flex justify-content-end mb-2">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <p class="rsans mb-0 me-2 justify-content-end">Last updated: {{ \Carbon\Carbon::parse($event->updated_at)->format('Y-m-d h:i A') }}</p>
                        </div>
                        @if ($isCommitteeMember)
                            <div class="col-12 d-flex justify-content-end mb-3">
                                <a id="btn-manage-event-compact" href="{{ route('events-finder.manage-details', [
                                    'event_id' => $event->event_id,
                                    'club_id' => $club->club_id,
                                ]) }}" class="section-button-short rsans btn btn-primary fw-semibold text-center me-2">Manage event</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- BODY OF CONTENT -->
        <!-- EVENT IMAGES CAROUSEL -->
        <div class="row-container">
            <div class="row w-100 justify-content-center align-items-center mx-0">
                @php
                    $eventImagePaths = json_decode($event->event_image_paths, true);
                @endphp
                <div id="event-images-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner">
                        @if (!empty($eventImagePaths))
                            <div class="carousel-item active">
                                <img src="{{ Storage::url($eventImagePaths[0]) }}" class="d-block w-100" alt="Event illustration"
                                data-bs-toggle="modal"
                                data-bs-target="#view-image-modal"
                                data-image="{{ Storage::url($eventImagePaths[0]) }}"
                                data-index="1">
                            </div>
                            @foreach (array_slice($eventImagePaths, 1) as $index => $imagePath)
                                <div class="carousel-item">
                                    <img src="{{ Storage::url($imagePath) }}" class="d-block w-100" alt="Event illustration"
                                    data-bs-toggle="modal"
                                    data-bs-target="#view-image-modal"
                                    data-image="{{ Storage::url($imagePath) }}"
                                    data-index="{{ $index + 2 }}">
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <img src="{{ asset('images/no_event_images_default.png') }}" class="d-block w-100" alt="No event illustration default" style="cursor: none;">
                            </div>
                        @endif
                        <x-view-image-modal/>
                    </div>
                    <button class="carousel-control-prev ms-2" type="button" data-bs-target="#event-images-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next me-2" type="button" data-bs-target="#event-images-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        <br>
        <!-- EVENT DESCRIPTION -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-left-alt col-lg-6 col-md-6 col-12 mt-2">
                        <h3 class="rserif fw-bold w-100">
                            {{ $event->event_name }}
                            <!-- EVENT BOOKMARK -->
                            <form class="d-inline-flex" method="POST" action="{{ route('events-finder.bookmarks.toggle') }}">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                                <input type="hidden" name="club_id" value="{{ $club->club_id }}">
                                @if (currentAccount()->account_role != 3)
                                    <button type="submit" class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none">
                                        @if ($isBookmarked)
                                            &nbsp;<i class="fa-solid fa-bookmark text-primary"></i>
                                        @else
                                            &nbsp;<i class="fa-regular fa-bookmark text-primary"></i>
                                        @endif
                                    </button>
                                @endif
                            </form>
                        </h3>
                    </div>
                    <div class="col-right-alt col-lg-6 col-md-6 col-12 mt-xl-2 mt-sm-0 d-flex align-items-center">
                        @php
                            $route = null;
                            if (currentAccount()->account_role != 3) {
                                $route = route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]);
                            } else {
                                $route = route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]);
                            }
                        @endphp
                        <a href="{{ $route }}" class="text-decoration-none mt-md-2">
                            <h5 class="rserif d-inline-flex align-items-center fw-bold text-muted">
                                <span>
                                    <i id="club-icon" class="fa fa-users text-muted mb-0 me-2"></i>
                                    {{ $club->club_name }}
                                </span>
                            </h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-container">
            <div class="container px-3 py-4">
                <h5 class="rserif fw-bold">Event date and time</h5>
                <p class="rsans pb-3">{{ \Carbon\Carbon::parse($event->event_datetime)->format('Y-m-d h:i A') }}</p>
                <h5 class="rserif fw-bold">Location</h5>
                <p class="rsans pb-3">{{ $event->event_location }}</p>
                <h5 class="rserif fw-bold">Description</h5>
                <p class="rsans pb-3">{{ $event->event_description }}</p>
                <h5 class="rserif fw-bold">Entrance fee</h5>
                <p class="rsans pb-3">RM {{ number_format($event->event_entrance_fee, 2) }}</p>
                <h5 class="rserif fw-bold">Does this event have SDP?</h5>
                <p class="rsans pb-3">
                    @if($event->event_sdp_provided == 1) Yes
                    @elseif($event->event_sdp_provided == 0) No
                    @endif
                </p>
                <h5 class="rserif fw-bold">Registration link</h5>
                <p class="rsans pb-3"><a href="#">{{ $event->event_registration_link }}</a></p>
            </div>
        </div>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
