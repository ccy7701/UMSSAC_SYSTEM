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

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/imageViewer.js')
    <x-admin-topnav/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <main class="flex-grow-1">
        <div class="row-container">
            <!-- BREADCRUMB NAV -->
            <div id="club-breadcrumb" class="row pb-3">
                <div id="club-breadcrumb" class="col-auto align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>';">
                            <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Details</a></li>
                            <li class="breadcrumb-item active">Edit Club Images</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-left-alt col-lg-6 col-md-6 col-12 mt-xl-2 mt-sm-0 mt-0">
                        <h3 class="rserif fw-bold w-100">Edit club images</h3>
                    </div>
                    <div class="col-right-alt col-lg-6 col-md-6 col-12 align-self-center mb-xl-0 mb-md-0 mb-sm-3 mb-3">
                        <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="section-button-short rsans btn btn-secondary fw-bold px-3">Go back</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <div class="d-flex justify-content-center align-items-center align-self-center py-3 w-100">
            <div class="container px-3">
                <div class="row py-4">
                    @php
                        $clubImagePaths = json_decode($club->club_image_paths, true);
                    @endphp
                    <!-- Add new image card -->
                    <div class="col-xl-3 col-lg-4 col-md-4 col-6 align-items-stretch">
                        <div class="rsans card h-100 add-club-image-card d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#add-club-image-modal">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                <i class="fa fa-plus-circle fa-3x mb-2"></i>
                                <h5 class="card-title fw-bold">Add new image</h5>
                            </div>
                        </div>
                    </div>
                    @if (!empty($clubImagePaths))
                        @foreach ($clubImagePaths as $key => $imagePath)
                            <div class="col-xl-3 col-lg-4 col-md-4 col-6 align-items-center text-center">
                                <div class="card h-100" id="card-club-images">
                                    <img src="{{ Storage::url($imagePath) }}" alt="Club illustration" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                    <div class="card-body justify-content-center align-items-center py-2 px-1">
                                        <div class="row px-0 mx-0">
                                            <div class="col-xl-6 col-12 py-2">
                                                <button type="button" class="rsans btn btn-secondary fw-semibold w-100"
                                                data-bs-toggle="modal"
                                                data-bs-target="#view-image-modal"
                                                data-image="{{ Storage::url($imagePath) }}"
                                                data-index={{ $loop->iteration }}>View</button>
                                            </div>
                                            <div class="col-xl-6 col-12 py-2">
                                                <button type="button" class="rsans btn btn-danger fw-semibold w-100"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete-confirmation-modal"
                                                data-key="{{ $key }}">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                                    <div class="modal-body d-flex justify-content-center align-items-center">
                                        <img src="" alt="Club illustration" class="img-fluid" id="modalImage">
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
                                        <form id="delete-club-image-form" method="POST" action="{{ route('admin-manage.edit-images.delete', ['club_id' => $club->club_id]) }}">
                                            @csrf
                                            <input type="hidden" name="key" id="delete-key">
                                            <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                                            <button type="submit" class="btn btn-danger fw-semibold ms-1">Yes, continue</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-xl-3 col-lg-4 col-md-4 col-6 align-items-center">
                            <div class="card h-100 justify-content-center" id="card-club-images" style="min-height: 35vh;">
                                <p class="rsans text-center">No images added yet</p>
                            </div>
                        </div>
                    @endif
                    <!-- Add club image modal -->
                    <div class="rsans modal fade" id="add-club-image-modal" tabindex="-1" aria-labelledby="addClubImageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                                    <p class="fw-semibold fs-5 mb-0">
                                        Add Club Image
                                    </p>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="add-club-image-form" method="POST" action="{{ route('admin-manage.edit-images.add', ['club_id' => $club->club_id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="col-md-12 text-start py-2">
                                            <div class="input-group w-100">
                                                <input type="file" name="new_image" id="new-image-input" class="form-control w-50" accept="image/*">
                                                <button id="new-image-submit" type="submit" class="rsans btn btn-primary fw-bold px-3">Save</button>
                                            </div>
                                            <p class="rsans pt-2">Note: The first image in the list will be shown when users search for the club.</p>
                                        </div>
                                        <!-- Preview of to-be-uploaded file -->
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-6 align-items-center text-center pb-3">
                                                <div class="card h-100" id="card-club-images-previewer">
                                                    <img id="new-image-preview" src="{{ asset('images/no_club_images_default.png') }}" alt="New club illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
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
    </main>
    <x-footer/>
</body>

</html>
