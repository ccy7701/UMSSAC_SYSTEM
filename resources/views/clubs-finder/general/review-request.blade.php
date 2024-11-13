<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Review Request to Create {{ $target->club_name }}</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/clubRequests.js')
    @if (currentAccount()->account_role == 3)
        <x-admin-topnav/>
    @elseif (currentAccount()->account_role == 2)
        <x-topnav/>
    @endif
    <x-about/>
    <main class="flex-grow-1 d-flex justify-content-center mt-xl-5 mt-lg-5">
        <div id="main-card" class="card">
            <!-- PAGE HEADER -->
            <div class="row-container align-items-center px-3 mt-lg-0 mt-md-3 mt-sm-3 mt-xs-3 mt-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center">
                        @if (currentAccount()->account_role == 3)
                            <h3 id="header-title" class="rserif fw-bold w-100 mb-1">Review club creation request</h3>
                            <p id="header-subtitle" class="rserif w-100 mt-0">Please review all details before proceeding</p>
                        @elseif (currentAccount()->account_role == 2)
                            <h3 class="rserif fw-bold w-100 mb-1">Review club creation request</h3>
                        @endif
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
                                {{ $error.'test' }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <form id="review-form" action="{{ route('club-creation.requests.accept') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="creation_request_id" value="{{ $target->creation_request_id }}">
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="container form-container px-3">
                        <div class="form-group mb-3">
                            <label for="new-club-name" class="rsans fw-bold form-label">Club name</label>
                            <input type="text" id="new-club-name" name="new_club_name" class="rsans form-control" value="{{ $target->club_name }}" required readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-club-category" class="rsans fw-bold form-label">Category</label>
                            <input type="text" id="new-club-category" class="rsans form-control w-50" value="{{ $target->club_category }}" required readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-club-description" class="rsans fw-bold form-label">Description</label>
                            <textarea id="new-club-description" name="new_club_description" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024" required readonly>{{ $target->club_description }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new-image-input" class="rsans fw-bold form-label mb-0">Club image</label>
                        </div>
                        <!-- Preview of to-be-uploaded file -->
                        @php
                            $clubImagePaths = json_decode($target->club_image_paths, true);
                        @endphp
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-4 col-lg-6 col-sm-6 col-8 align-items-center text-center pb-3">
                                <div class="card h-100" id="card-club-images-previewer">
                                    @if (empty($clubImagePaths))
                                        <img id="new-image-preview" src="{{ asset('images/no_club_images_default.png') }}" alt="New club illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                    @else
                                        <img id="new-image-preview" src="{{ Storage::url($clubImagePaths[0]) }}" alt="New club illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                    @endif
                                    <div class="rsans card-body d-flex justify-content-center align-items-center h-100">
                                        <p class="mb-1">
                                            @if (empty($clubImagePaths))
                                                No image provided
                                            @else
                                                New image preview
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if (currentAccount()->account_role == 3)
                <div class="row w-100 mx-0 mt-3 mb-5 justify-content-center">
                    <div id="col-action-buttons-row" class="col-12 d-flex justify-content-center align-items-center">
                        <a href="{{ route('club-creation.requests.manage') }}" class="w-30 rsans btn btn-secondary fw-semibold px-3 me-1">Go back</a>
                        <a href="{{ '#' }}" class="w-30 rsans btn btn-danger fw-semibold px-3 ms-1 me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#reject-confirmation-modal"
                            data-creation-request-id="{{ $target->creation_request_id }}"
                            data-club-name="{{ $target->club_name }}">
                            Reject
                        </a>
                        <button type="button" form="review-form" class="w-30 rsans btn btn-primary fw-semibold px-3 ms-1"
                            data-bs-toggle="modal"
                            data-bs-target="#accept-confirmation-modal"
                            data-creation-request-id="{{ $target->creation_request_id }}"
                            data-club-name="{{ $target->club_name }}">
                            Approve
                        </button>
                    </div>
                    <x-accept-request/>
                    <x-reject-request/>
                </div>
            @elseif (currentAccount()->account_role == 2)
                <div id="col-action-buttons" class="row w-100 mx-0 mt-3 justify-content-center">
                    <div id="col-action-buttons-row" class="col-12 d-flex justify-content-center align-items-center">
                        <a href="{{ route('club-creation.requests.view') }}" class="w-30 rsans btn btn-secondary fw-semibold px-3">Go back</a>
                    </div>
                </div>
            @endif
        </div>
    </main>
    <x-footer/>
</body>

</html>
