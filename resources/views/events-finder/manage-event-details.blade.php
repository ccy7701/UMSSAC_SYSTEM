<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage {{ $event->event_name }}</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    <x-topnav/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <!-- BREADCRUMB NAV -->
            <div id="event-breadcrumb" class="row">
                <!-- Breadcrumb links -->
                <div class="col-7 d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>'; margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('events-finder') }}">All Events</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}">{{ $event->event_name }}</a></li>
                            <li class="breadcrumb-item active">Manage Event Details</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-5 d-flex justify-content-end align-items-center">
                    <p class="rsans mb-0 me-3">Last updated: {{ \Carbon\Carbon::parse($event->updated_at)->format('Y-m-d h:i A') }}</p>
                    <a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}" class="rsans btn btn-secondary fw-semibold w-25 text-center">Go back</a>
                </div>
            </div>
            <div id="event-breadcrumb-alt" class="row w-100 mx-0">
                <div id="event-breadcrumb-alt" class="col-4 align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '<';">
                            <li class="breadcrumb-item"></li>
                            <li class="breadcrumb-item"><a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}">Go back</a></li>
                        </ol>
                    </nav>
                </div>
                <div id="event-breadcrumb-alt" class="col-8 d-flex justify-content-end">
                    <p class="rsans mb-0 me-1 justify-content-end">Last updated: {{ \Carbon\Carbon::parse($event->updated_at)->format('Y-m-d h:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="mt-xl-4 mt-lg-4 mt-md-0"></div>
        <!-- BODY OF CONTENT -->
        <!-- EVENT INFO SECTION -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-lg-6 col-8 text-start mt-2">
                        <h3 class="rserif fw-bold w-100">Event info</h3>
                    </div>
                    <div class="col-lg-6 col-4 text-end align-self-center">
                        <a href="{{ route('event-manage.edit-event-info', [
                            'event_id' => $event->event_id,
                            'club_id' => $club->club_id,
                        ]) }}" class="section-button rsans btn btn-primary fw-bold px-3">Edit</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-container d-flex justify-content-center align-items-center py-3">
            <form class="form-standard px-3">
                <div class="form-group mb-3">
                    <label for="event-name" class="rsans fw-bold form-label">Event name</label>
                    <input type="text" id="event-name" name="event_name" class="rsans form-control" value="{{ $event->event_name }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="event-location" class="rsans fw-bold form-label">Location</label>
                    <input type="text" id="event-location" name="event_location" class="rsans form-control" value="{{ $event->event_location }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="event-datetime" class="rsans fw-bold form-label">Event date and time</label>
                    <input type="text" id="event-datetime" name="event_datetime" class="rsans form-control" value="{{ $event->event_datetime }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="event-description" class="rsans fw-bold form-label">Description</label>
                    <textarea id="event-description" name="event_description" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024" readonly>{{ $event->event_description }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="event-entrance-fee" class="rsans fw-bold form-label">Entrance fee</label>
                    <input type="text" id="event-entrance-fee" name="event_entrance_fee" class="rsans form-control" value="RM {{ number_format($event->event_entrance_fee, 2) }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="event-sdp-provided" class="rsans fw-bold form-label">Does this event have SDP?</label>
                    <input type="text" id="event-sdp-provided" name="event_sdp_provided" class="rsans form-control" value="{{ ($event->event_sdp_provided == 1) ? 'Yes' : 'No' }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="event-registration-link" class="rsans fw-bold form-label">Registration link</label>
                    <input type="text" id="event-registration-link" name="event_registration_link" class="rsans form-control" value="{{ $event->event_registration_link }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="event-status" class="rsans fw-bold form-label">Event status</label>
                    <input type="text" id="event-status" name="event_status" class="rsans form-control" value="{{ ($event->event_status == 1) ? 'Incoming' : 'Closed' }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="created-at" class="rsans fw-bold form-label">Event creation time and date</label>
                    <input type="text" id="created-at" name="created_at" class="rsans form-control" value="{{ \Carbon\Carbon::parse($event->created_at)->format('Y-m-d h:i A') }}" readonly>
                </div>
            </form>
        </div>
        <!-- EVENT IMAGES SECTION -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-lg-6 col-8 text-start mt-2">
                        <h3 class="rserif fw-bold w-100">Event images</h3>
                    </div>
                    <div class="col-lg-6 col-4 text-end align-self-center">
                        <a href="{{ route('event-manage.edit-images', [
                            'event_id' => $event->event_id,
                            'club_id' => $club->club_id,
                        ]) }}" class="section-button rsans btn btn-primary fw-bold px-3">Edit</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-container d-flex align-items-center">
            <div class="align-items-center w-100 px-3">
                @php
                    $eventImagePaths = json_decode($event->event_image_paths, true);
                @endphp
                @if (!empty($eventImagePaths))
                    <div class="row py-4">
                        @foreach ($eventImagePaths as $imagePath)
                            <div class="col-xl-2 col-md-3 col-sm-4 col-6 mb-4">
                                <img src="{{ Storage::url($imagePath) }}" alt="Event illustration" class="img-fluid border" style="aspect-ratio: 4/4; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="rsans text-center w-100 py-4">No images added yet</p>
                @endif
            </div>
        </div>
        <!-- DELETION SECTION -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-12 text-start mt-2">
                        <h3 class="rserif fw-bold w-100">Event deletion</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-container d-flex justify-content-center align-items-center py-3">
            <div class="row w-75">
                <div class="rsans card text-center p-0">
                    <div class="card-body align-items-center justify-content-center">
                        <p class="card-text">Click the button below to delete this event.</p>
                        <button id="btn-event-delete" type="button" class="btn btn-danger fw-semibold align-self-center"
                            data-bs-toggle="modal"
                            data-bs-target="#delete-event-confirmation-modal">Delete event</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete event confirmation modal -->
        <div class="rsans modal fade" id="delete-event-confirmation-modal" tabindex="-1" aria-labelledby="deleteEventConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-2 d-flex align-items-center">
                        <p class="fw-semibold fs-5 mb-0">
                            Delete event confirmation
                        </p>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete the event: {{ $event->event_name }}?
                        <br><br>
                        <p class="text-danger">This will permanently delete the record of this event and cannot be reversed. Please be certain.</b>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-event-form" method="POST" action="{{ route('event-manage.delete-event', [
                            'event_id' => $event->event_id,
                            'club_id' => $club->club_id
                        ]) }}">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                            <input type="hidden" name="club_id" value="{{ $club->club_id }}">
                            <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                            <button type="submit" class="btn btn-danger fw-semibold ms-1">Yes, continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
