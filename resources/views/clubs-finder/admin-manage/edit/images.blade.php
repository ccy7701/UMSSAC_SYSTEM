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
    <x-topnav/>
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
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Details</a></li>
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
        <!-- EDIT IMAGES FORM -->
        <form action="{{ route('committee-manage.edit-images.action', ['club_id' => $club->club_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Display current images with delete buttons -->
                @php
                    $clubImagePaths = json_decode($club->club_image_paths, true);
                @endphp
                @if (empty($clubImagePaths))
                    <div class="col-md-3">
                        <div class="image-wrapper">
                            <img src="{{ asset('images/no_club_images_default.png') }}" alt="No club illustration" class="img-thumbnail">
                        </div>
                    </div>
                @else
                    @foreach($clubImagePaths as $key => $imagePath)
                    <div class="col-md-3">
                        <div class="image-wrapper">
                            <img src="{{ Storage::url($imagePath) }}" alt="Club illustration" class="img-thumbnail">
                            <button type="submit" name="delete_image" value="{{ $key }}" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                    @endforeach
                @endif
                <!-- Upload a new image -->
                <div class="col-md-3">
                    <label for="new_image">Add new image:</label>
                    <input type="file" name="new_image" id="new_image" class="form-control" accept="image/*">
                </div>
            </div>
        
            <!-- Save button -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
        <!-- END EDIT IMAGES FORM -->

    </div>
    <x-footer/>
</body>

</html>
