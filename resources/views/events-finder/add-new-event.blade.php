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

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/imageViewer.js')
    <x-topnav/>
    <br>
    <main class="flex-grow-1">
        <form action="{{ route('event-manage.add-new-event.action') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- PAGE HEADER -->
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                        <div class="col-12 text-center">
                            <h3 class="rserif fw-bold w-100 mb-1">Add new event</h3>
                            <p class="rserif fs-4 w-100 mt-0">Fill in the details below to create a new event</p>
                        </div>
                        <!-- BREADCRUMB NAV -->
                        <div class="row py-3">
                            <div id="event-breadcrumb" class="col-lg-8 align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="rsans breadcrumb mb-0 px-2" style="--bs-breadcrumb-divider: '>';">
                                        <li class="breadcrumb-item"><a href="{{ route('clubs-finder') }}">All Clubs</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Club Details</a></li>
                                        <li class="breadcrumb-item active">Add New Event</li>
                                    </ol>
                                </nav>
                            </div>
                            <div id="event-action-buttons" class="col-lg-4 col-md-12 col-12 align-items-center px-0">
                                <a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                                <button type="submit" class="rsans btn btn-primary fw-bold px-3 ms-2 w-40">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BODY OF CONTENT -->
            @if ($errors->any())
                <br><br><br>
                <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {!! $error !!}
                    <br>
                @endforeach
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
                        <input type="datetime-local" id="new-event-datetime" name="new_event_datetime" class="rsans form-control" required value="{{ old('new_event_datetime', $event->new_event_datetime ?? '') }}">
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
                        <p class="rsans py-2">Note: This image will be shown when users search for the club. It can be edited later.</p>
                    </div>
                    <!-- Preview of to-be-uploaded file -->
                    <div class="row align-items-center justify-content-center">
                        <div class="col-xl-3 col-lg-4 col-sm-6 col-8 align-items-center text-center pb-3">
                            <div class="card h-100" id="card-event-images-previewer">
                                <img id="new-image-preview" src="{{ asset('images/no_event_images_default.png') }}" alt="New event illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                <div class="rsans card-body d-flex justify-content-center align-items-center h-100">
                                    <p class="mb-1">New image preview</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <x-footer/>
</body>

</html>
