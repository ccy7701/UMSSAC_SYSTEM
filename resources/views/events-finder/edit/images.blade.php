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
    @vite('resources/js/eventImageViewer.js')
    <x-topnav/>
    <x-success-message/>
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

                    @endforeach
                    <!-- Add new image card -->
                    <!-- View image modal -->
                    <!-- Delete confirmation modal -->
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
                            <form id="add-event-image-form" method="POST" action="#" enctype="multipart/form-data">
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
                                                <img id="new-event-image-preview" src="{{ asset('images/no_event_images_default.png') }}" alt="New event illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
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

        {{ dump($club) }}
        {{ dump($isCommitteeMember) }}

    </div>
    <x-footer/>
</body>

</html>


