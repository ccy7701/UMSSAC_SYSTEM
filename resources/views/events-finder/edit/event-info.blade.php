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
        <form action="{{ route('event-manage.edit-event-info.action') }}" method="POST">
            @csrf
            <input type="hidden" name="club_id" value="{{ $club->club_id }}">
            <input type="hidden" name="event_id" value="{{ $event->event_id }}">

            <!-- PAGE HEADER -->
            <div class="row-container">
                <!-- BREADCRUMB NAV -->
                <div id="event-breadcrumb" class="row pb-3">
                    <div id="event-breadcrumb" class="col-auto align-items-center">
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
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-left-alt col-lg-6 col-md-5 col-12 mt-xl-2 mt-sm-0 mt-0">
                            <h3 class="rserif fw-bold w-100">Edit event info</h3>
                        </div>
                        <div class="col-right-alt col-lg-6 col-md-7 col-12 align-self-center mb-xl-0 mb-md-0 mb-sm-3 mb-3">
                            <a href="{{ route('events-finder.manage-details', [
                                'event_id' => $event->event_id,
                                'club_id' => $club->club_id,
                            ]) }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                            <button type="submit" class="section-button-short rsans btn btn-primary fw-bold px-3">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            @if($errors->any())
                <br><br><br>
                <div class="rsans alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <i class="fa fa-circle-exclamation px-2"></i>
                        {{ $error }}
                        <br>
                    @endforeach
                </div>
            @endif
            <div class="d-flex justify-content-center align-items-center align-self-center py-3 w-100">
                <div class="container form-container px-3">
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
        <br>
    </main>
    <x-footer/>
</body>

</html>
