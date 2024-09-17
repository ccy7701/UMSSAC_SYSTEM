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

<body>
    @vite('resources/js/app.js')
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
                                    <li class="breadcrumb-item"><a href="{{ route('events-finder') }}">All Events</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}">{{ $event->event_name }}</a></li>
                                    <li class="breadcrumb-item active">Manage Event Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <p class="rsans mb-0 me-3 align-self-center">Last updated: {{ $club->updated_at }}</p>
                            <a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}" class="rsans btn btn-secondary fw-semibold w-30">Go back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <div class="container-fluid align-items-center py-4">
            <!-- EDIT EVENT INFO SECTION -->
            <form>
                <div class="d-flex align-items-center">
                    <div class="section-header row w-100">
                        <div class="col-md-6 text-start">
                            <h3 class="rserif fw-bold w-100 py-2">Event info</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <!-- ROUTE TO BE ADDED HERE -->
                            <a href="{{ route('event-manage.edit-event-info', [
                                'event_id' => $event->event_id,
                                'club_id' => $club->club_id,
                            ]) }}" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="container px-3 w-75">
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
                            <input type="text" id="created-at" name="created_at" class="rsans form-control" value="{{ $event->created_at }}" readonly>
                        </div>
                    </div>
                </div>
                <br>
            </form>
            <!-- END EDIT EVENT INFO SECTION -->

            <!-- EDIT EVENT IMAGES SECTION -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Event images</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('event-manage.edit-images', [
                            'event_id' => $event->event_id,
                            'club_id' => $club->club_id,
                        ]) }}" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start align-items-center py-4 w-100 align-self-center">
                @php
                    $eventImagePaths = json_decode($event->event_image_paths, true);
                @endphp
                @if (empty($eventImagePaths))
                    <div class="position-relative me-4">
                        <p class="rsans">No images added yet</p>
                    </div>
                @else
                    @foreach ($eventImagePaths as $imagePath)
                        <div class="position-relative me-4">
                            <img src="{{ Storage::url($imagePath) }}" alt="Event illustration" class="img-fluid border" style="width: 128px; height: 128px; object-fit: cover;">
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- END EDIT EVENT IMAGES SECTION -->
        </div>
    </div>
    <x-footer/>
</body>

</html>
