<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Event</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/imageViewer.js')
    <x-topnav/>
    <x-about/>
    <x-feedback/>
    <!-- BREADCRUMB NAV -->
    <div id="event-breadcrumb" class="row w-80 justify-content-start mx-auto py-4">
        <nav aria-label="breadcrumb">
            <ol class="rsans breadcrumb mb-0 px-2" style="--bs-breadcrumb-divider: '>';">
                <li class="breadcrumb-item"><a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Club Details</a></li>
                <li class="breadcrumb-item active">Add New Event</li>
            </ol>
        </nav>
    </div>
    <main class="flex-grow-1 d-flex justify-content-center">
        <div id="main-card" class="card">
            <form action="{{ route('event-manage.add-new-event.action', ['club_id' => $club->club_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- PAGE HEADER -->
                <div class="row-container align-items-center px-3 mt-lg-0 mt-md-3 mt-sm-3 mt-xs-3 mt-3">
                    <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                        <div class="col-12 text-center">
                            <h3 class="rserif fw-bold w-100 mb-1">Add new event</h3>
                            <p class="rserif fs-4 w-100 mt-0">Fill in the details below to create a new event</p>
                        </div>
                    </div>
                </div>
                <!-- BODY OF CONTENT -->
                @if ($errors->any())
                    <div class="d-flex justify-content-center">
                        <div class="col-12 w-xxl-80 w-sm-100 px-3 align-items-center">
                            <br>
                            <div class="rsans alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <i class="fa fa-circle-exclamation px-2"></i>
                                    {{ $error }}
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="container form-container px-3">
                        <div class="form-group mb-3">
                            <label for="new-event-name" class="rsans fw-bold form-label">Event name</label>
                            <input type="text" id="new-event-name" name="new_event_name" class="rsans form-control" required value="{{ old('new_event_name', $event->new_event_name ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-event-location" class="rsans fw-bold form-label">Location</label>
                            <input type="text" id="new-event-location" name="new_event_location" class="rsans form-control" required value="{{ old('new_event_location', $event->new_event_location ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-event-datetime" class="rsans fw-bold form-label">Event date and time</label>
                            <input type="datetime-local" id="new-event-datetime" name="new_event_datetime" class="rsans form-control" required value="{{ old('new_event_datetime', $event->new_event_datetime ?? '') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-event-description" class="rsans fw-bold form-label">Description</label>
                            <textarea id="new-event-description" name="new_event_description" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024" required>{{ old('new_event_description', $event->new_event_description ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-event-entrance-fee" class="rsans fw-bold form-label">Entrance fee</label>
                            <div class="input-group w-50">
                                <span class="rsans formfield-span input-group-text d-flex justify-content-center">RM</span>
                                <input type="number" id="new-event-entrance-fee" name="new_event_entrance_fee" class="rsans form-control" step="0.01" min="0" required value="{{ old('new_event_entrance_fee', $event->new_event_entrance_fee ?? '') }}">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-event-sdp-provided" class="rsans fw-bold form-label">Does this event have SDP?</label>
                            <select id="new-event-sdp-provided" class="rsans form-select w-50" name="new_event_sdp_provided" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1" {{ old('new_event_sdp_provided', $event->new_event_sdp_provided ?? '') == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('new_event_sdp_provided', $event->new_event_sdp_provided ?? '') == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-event-registration-link" class="rsans fw-bold form-label">Registration link</label>
                            <input type="text" id="new-event-registration-link" name="new_event_registration_link" class="rsans form-control" required value="{{ old('new_event_registration_link', $event->new_event_registration_link ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-event-status" class="rsans fw-bold form-label">Event status</label>
                            <select id="new-event-status" name="new_event_status" class="rsans form-select w-50" required>
                                <option value="1" selected>Incoming</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-image-input" class="rsans fw-bold form-label">Add event image (optional)</label>
                            <div class="rsans input-group w-100">
                                <input type="file" id="new-image-input" name="new_event_image" class="form-control w-50" accept="image/*">
                            </div>
                            <p class="rsans form-text text-start">Maximum allowed image file size is 2048KB only.</p>
                        </div>
                        <!-- Preview of to-be-uploaded file -->
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-4 col-lg-6 col-sm-6 col-8 align-items-center text-center pb-3">
                                <div class="card h-100" id="card-event-image-previewer">
                                    <img id="new-image-preview" src="{{ asset('images/no_event_images_default.png') }}" alt="New event illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                    <div class="rsans card-body d-flex justify-content-center align-items-center h-100">
                                        <p class="mb-1">New image preview</p>
                                    </div>
                                </div>
                            </div>
                            <p class="rsans pt-2 text-center">Note: This image will be shown when users search for the club. It can be edited later.</p>
                        </div>
                    </div>
                </div>
                <div class="row w-100 mx-0 mt-3 mb-5 justify-content-center">
                    <div class="col-12 w-xxl-50 w-xs-80 d-flex justify-content-center align-items-center">
                        <a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                        <button type="submit" class="w-40 rsans btn btn-primary fw-bold px-3">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <x-footer/>
</body>

</html>
