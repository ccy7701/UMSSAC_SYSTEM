<!DOCTYPE HTML>
<html lang="en" xml:lang="en">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->event_name }} | Events Finder</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    <x-topnav/>
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
                                    <li class="breadcrumb-item"><a href="{{ route('events-finder') }}">All Events</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                    <li class="breadcrumb-item active">{{ $event->event_name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <p class="rsans mb-0 me-3 align-self-center text-end">Last updated: {{ $club->updated_at }}</p>
                            @if ($isCommitteeMember || currentAccount()->account_role == 3)
                                <a href="{{ route('events-finder.manage-details', [
                                    'event_id' => $event->event_id,
                                    'club_id' => $club->club_id,
                                ]) }}" class="rsans btn btn-primary fw-semibold align-self-center">Manage event details</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <div class="container-fluid align-items-center py-4">
            <!-- Event images carousel -->
            <div class="row w-100 justify-content-center align-items-center">
                @php
                    $eventImagePaths = json_decode($event->event_image_paths, true);
                @endphp
                <div id="eventImagesCarousel" class="carousel slide carousel-fade w-50" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner">
                        @if (empty($eventImagePaths))
                            <div class="carousel-item active">
                                <img src="{{ asset('images/no_event_images_default.png') }}" class="d-block w-100" alt="No event illustration default" style="aspect-ratio: 16/10; object-fit: cover;">
                            </div>
                        @else
                            @foreach(array_slice($eventImagePaths, 1) as $imagePath)
                                <div class="carousel-item">
                                    <img src="{{ asset($imagePath) }}" class="d-block w-100" alt="Event illustration" style="aspect-ratio: 16/10; object-fit: cover;">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#eventImagesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#eventImagesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        <br>
        <!-- Event description -->
        <div class="d-flex align-items-center">
            <div class="section-header row w-100">
                <div class="col-md-6 text-start">
                    <h3 class="rserif fw-bold w-100 py-2 px-3 mb-2">{{ $event->event_name }}</h3>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end">
                    <i class="fa fa-users text-muted fs-4 mb-2 me-3"></i>
                    <h3 class="rserif fw-bold text-muted fs-5 mb-2">{{ $club->club_name }}</h3>
                </div>
            </div>
        </div>
        <div class="container px-3 py-4">
            <h5 class="rserif fw-bold">Event date and time</h5>
            <p class="rsans pb-3">{{ $event->event_datetime }}</p>
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

    <x-footer/>
</body>

</html>
