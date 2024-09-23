<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Event Info</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    <x-topnav/>
    <br>
    <main class="flex-grow-1">
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
                                        <li class="breadcrumb-item"><a href="{{ route('events-finder.manage-details', [
                                            'event_id' => $event->event_id,
                                            'club_id' => $club->club_id,
                                        ]) }}">Manage Details</a></li>
                                        <li class="breadcrumb-item active">Edit Event Info<li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BODY OF CONTENT -->
            <!-- EDIT CLUB INFO FORM -->
            <form action="{{ route('event-manage.edit-event-info.action') }}" method="POST">
                @csrf
                <input type="hidden" name="club_id" value="{{ $club->club_id }}">
                <input type="hidden" name="event_id" value="{{ $event->event_id }}">
                <div class="d-flex align-items-center">
                    <div class="section-header row w-100">
                        <div class="col-md-6 text-start">
                            <h3 class="rserif fw-bold w-100 py-2">Event info</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('events-finder.manage-details', [
                                'event_id' => $event->event_id,
                                'club_id' => $club->club_id,
                            ]) }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                            <button type="submit" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Save</button>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                    <br>
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {!! $error !!}
                            <br>
                        @endforeach
                    </div>
                @endif
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="container px-3 w-75">
                        <div class="form-group mb-3">
                            <label for="event-name" class="rsans fw-bold form-label">Event name</label>
                            <input type="text" id="event-name" name="event_name" class="rsans form-control" value="{{ $event->event_name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event-location" class="rsans fw-bold form-label">Location</label>
                            <input type="text" id="event-location" name="event_location" class="rsans form-control" value="{{ $event->event_location }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event-datetime" class="rsans fw-bold form-label">Event date and time</label>
                            <input type="datetime-local" id="event-datetime" name="event_datetime" class="rsans form-control" value="{{ \Carbon\Carbon::parse($event->event_datetime)->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event-description" class="rsans fw-bold form-label">Description</label>
                            <textarea id="event-description" name="event_description" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024" required>{{ $event->event_description }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event-entrance-fee" class="rsans fw-bold form-label">Entrance fee</label>
                            <div class="input-group">
                                <span class="rsans formfield-span input-group-text d-flex justify-content-center">RM</span>
                                <input type="number" id="new-event-entrance-fee" name="new_event_entrance_fee" class="rsans form-control" step="0.01" min="0" value="{{ number_format($event->event_entrance_fee, 2) }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event-sdp-provided" class="rsans fw-bold form-label">Does this event have SDP?</label>
                            <select id="event-sdp-provided" class="rsans form-select w-50" name="event_sdp_provided" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1" {{ $event->event_sdp_provided == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $event->event_sdp_provided == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event-registration-link" class="rsans fw-bold form-label">Registration link</label>
                            <input type="text" id="event-registration-link" name="event_registration_link" class="rsans form-control" value="{{ $event->event_registration_link }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event-status" class="rsans fw-bold form-label">Event status</label>
                            <select id="event-status" name="event_status" class="rsans form-select w-50" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1" {{ $event->event_status == 1 ? 'selected' : '' }}>Incoming</option>
                                <option value="0" {{ $event->event_status == 0 ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="created-at" class="rsans fw-bold form-label">Event creation time and date</label>
                            <input type="text" id="created-at" name="created_at" class="rsans form-control" value="{{ \Carbon\Carbon::parse($event->created_at)->format('Y-m-d h:i A') }}" readonly disabled>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <x-footer/>
</body>

</html>
