<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Images</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/imageViewer.js')
    <x-topnav/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <div class="container p-3">

        <!-- TOP SECTION -->
        <div class="d-flex align-items-center">
            <div class="row w-100">
                <!-- BREADCRUMB NAV -->
                <div class="row pb-3">
                    <div class="col-8 align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>';">
                                <li class="breadcrumb-item"><a href="{{ route('events-finder') }}">All Events</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}">{{ $event->event_name }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('events-finder.manage-details', [
                                    'event_id' => $event->event_id,
                                    'club_id' => $club->club_id,
                                ]) }}">Manage Details</a></li>
                                <li class="breadcrumb-item active">Edit Images</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-4"></div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <div class="container-fluid align-items-center py-4">
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Event images</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('events-finder.manage-details', [
                            'event_id' => $event->event_id,
                            'club_id' => $club->club_id,
                        ]) }}" class="rsans btn btn-secondary fw-bold px-3 mx-2 w-25">Go back</a>
                    </div>
                </div>
            </div>
            <div class="row py-4">
                @php
                    $eventImagePaths = json_decode($event->event_image_paths, true);
                @endphp
                @if (!empty($eventImagePaths))
                    @foreach ($eventImagePaths as $key => $imagePath)
                        <div class="col-md-3 align-items-center text-center">
                            <div class="card h-100" id="card-event-images">
                                <img src="{{ Storage::url($imagePath) }}" alt="Event illustration" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                <div class="card-body d-flex flex-row justify-content-center align-items-center py-3">
                                    <button type="button" class="rsans btn btn-secondary fw-semibold w-40 me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#view-image-modal"
                                        data-image="{{ Storage::url($imagePath) }}"
                                        data-index={{ $loop->iteration }}>View
                                    </button>
                                    <button type="button" class="rsans btn btn-danger fw-semibold w-40 ms-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#delete-confirmation-modal"
                                        data-key="{{ $key }}">Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Add new image card -->
                    <div class="col-md-3 align-items-center">
                        <div class="rsans card h-100 add-event-image-card d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#add-event-image-modal">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                <i class="fa fa-plus-circle fa-3x mb-2"></i>
                                <h5 class="card-title fw-bold">Add new image</h5>
                            </div>
                        </div>
                    </div>
                    <!-- View image modal -->
                    <div class="rsans modal fade" id="view-image-modal" tabindex="-1" aria-labelledby="viewImageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                                    <p class="fw-semibold fs-5 mb-0">
                                        <span id="image-index"></span>
                                    </p>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex justify-content-center">
                                    <img src="" alt="Event illustration" class="img-fluid" id="modalImage">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete confirmation modal -->
                    <div class="rsans modal fade" id="delete-confirmation-modal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                                    <p class="fw-semibold fs-5 mb-0">
                                        Delete confirmation
                                    </p>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this image?
                                </div>
                                <div class="modal-footer">
                                    <form id="delete-event-image-form" method="POST" action="{{ route('event-manage.edit-images.delete', [
                                        'event_id' => $event->event_id,
                                        'club_id' => $club->club_id,
                                    ]) }}">
                                        @csrf
                                        <input type="hidden" id="delete-key" name="key">
                                        <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                                        <button type="submit" class="btn btn-danger fw-semibold ms-1">Yes, continue</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-3 align-items-center">
                        <div class="card h-100 justify-content-center" id="card-event-images" style="min-height: 50vh;">
                            <p class="rsans text-center">No images added yet</p>
                        </div>
                    </div>
                    <!-- Add new image card -->
                    <div class="col-md-3 align-items-stretch">
                        <div class="rsans card h-100 add-event-image-card d-flex justify-content-center align-self-center" data-bs-toggle="modal" data-bs-target="#add-event-image-modal">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                <i class="fa fa-plus-circle fa-3x mb-2"></i>
                                <h5 class="card-title fw-bold">Add new image</i>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Add event image modal -->
                <div class="rsans modal fade" id="add-event-image-modal" tabindex="-1" aria-labelledby="addEventImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                                <p class="fw-semibold fs-5 mb-0">
                                    Add event image
                                </p>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="add-event-image-form" method="POST" action="{{ route('event-manage.edit-images.add', [
                                'event_id' => $event->event_id,
                                'club_id' => $club->club_id
                            ]) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="col-md-12 text-start py-2">
                                        <div class="rsans input-group w-100">
                                            <input type="file" name="new_image" id="new-image-input" class="form-control w-50" accept="image/*">
                                            <button id="new-image-submit" type="submit" class="rsans btn btn-primary fw-bold px-3">Save</button>
                                        </div>
                                        <p class="rsans pt-2">Note: The first image in the list will be shown when users search for the event.</p>
                                    </div>
                                    <!-- Preview of to-be-uploaded file -->
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-md-3 align-items-center text-center pb-3">
                                            <div class="card h-100" id="card-event-images-previewer">
                                                <img id="new-image-preview" src="{{ asset('images/no_event_images_default.png') }}" alt="New event illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                                <div class="rsans card-body d-flex justify-content-center align-items-center h-100">
                                                    <p class="mb-1">New image preview</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</body>

</html>


