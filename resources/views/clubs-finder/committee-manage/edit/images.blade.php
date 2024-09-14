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
    @vite('resources/js/clubNewImagePreviewer.js')
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
                                    <li class="breadcrumb-item"><a href="{{ route('clubs-finder') }}">All Clubs</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Details</a></li>
                                    <li class="breadcrumb-item active">Edit Images</li>
                                </ol>
                             </nav>
                        </div>
                        <div class="col-6"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <div class="container-fluid align-items-center py-4">
            <!-- EDIT IMAGES FORM -->
            <form action="{{ route('committee-manage.edit-images.action', ['club_id' => $club->club_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex align-items-center">
                    <div class="section-header row w-100">
                        <div class="col-md-6 text-start">
                            <h3 class="rserif fw-bold w-100 py-2">Club images</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-secondary fw-bold px-3 mx-2 w-25">Go back</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Upload a new image -->
                    <div class="col-md-12 text-start py-4">
                        <label for="new-image-input" class="rsans fw-bold form-label">Add new image:</label>
                        <div class="input-group w-50">
                            <input type="file" name="new_image" id="new-image-input" class="form-control w-50" accept="image/*">
                            <button id="new-image-submit" type="submit" class="rsans btn btn-primary fw-bold px-3">Save</button>
                        </div>
                        <p class="rsans pt-2">Note: The first image will be shown when users search for the club.</p>
                    </div>
                    <!-- Display current images with delete buttons -->
                    @php
                        $clubImagePaths = json_decode($club->club_image_paths, true);
                    @endphp
                    @if (empty($clubImagePaths))
                        <div class="col-md-3 align-items-center">
                            <div class="card h-100 justify-content-center" id="card-club-images">
                                <p class="rsans text-center">No images added yet</p>
                            </div>
                        </div>
                        <!-- Preview of to-be-uploaded file -->
                        <div class="col-md-3 align-items-center text-center">
                            <div class="card h-100" id="card-club-images-previewer">
                                <img id="new-club-image-preview" src="{{ asset('images/no_club_images_default.png') }}" alt="New club illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                <div class="rsans card-body d-flex justify-content-center align-items-center h-100">
                                    <p class="mb-1">New image preview</p>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach($clubImagePaths as $key => $imagePath)
                            <div class="col-md-3 align-items-center text-center">
                                <div class="card h-100" id="card-club-images">
                                    <img src="{{ Storage::url($imagePath) }}" alt="Club illustration" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                    <div class="card-body d-flex flex-row justify-content-center align-items-center py-3">
                                        <button type="button" class="rsans btn btn-secondary fw-semibold w-40 me-1">View</button>
                                        <button type="submit" name="delete_image" value="{{ $key }}" class="rsans btn btn-danger fw-semibold w-40 ms-1" onclick="return confirm('Are you sure you want to delete this image? Press OK to proceed.');">Delete</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- Preview of to-be-uploaded file -->
                        <div class="col-md-3 align-items-center text-center">
                            <div class="card h-100" id="card-club-images-previewer">
                                <img id="new-club-image-preview" src="{{ asset('images/no_club_images_default.png') }}" alt="New club illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                <div class="rsans card-body d-flex justify-content-center align-items-center h-100">
                                    <p class="mb-1">New image preview</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
            <!-- END EDIT IMAGES FORM -->
        </div>
    </div>
    <x-footer/>
</body>

</html>
