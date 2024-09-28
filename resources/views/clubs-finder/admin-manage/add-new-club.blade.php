<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Club</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/imageViewer.js')
    <x-admin-topnav/>
    <br>
    <main class="flex-grow-1">
        <div class="container p-3">
            <!-- TOP SECTION -->
            <form action="{{ route('manage-clubs.add-new-club.action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="section-header row w-100">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">Add new club</h3>
                        <p class="rserif fs-4 w-100 mt-0">Fill in the details below to create a new club</p>
                    </div>
                    <!-- BREADCRUMB NAV -->
                    <div class="row py-3">
                        <div class="col-6 d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="rsans breadcrumb mb-0 px-2" style="--bs-breadcrumb-divider: '>';">
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                                    <li class="breadcrumb-item active">Add New Club</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-center px-0">
                            <a href="{{ route('manage-clubs') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                            <button type="submit" class="rsans btn btn-primary fw-bold px-3 ms-2 w-25">Add</button>
                        </div>
                    </div>
                </div>
                <!-- BODY OF CONTENT -->
                <div class="container-fluid align-items-center py-4">
                    <div class="d-flex justify-content-center align-items-center w-100 align-self-center">
                        <div class="container px-3 w-75">
                            <div class="form-group mb-3">
                                <label for="new-club-name" class="rsans fw-bold form-label">Club name</label>
                                <input type="text" id="new-club-name" name="new_club_name" class="rsans form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="new-club-category" class="rsans fw-bold form-label">Category</label>
                                <select id="new-club-category" class="rsans form-select w-50" name="new_club_category" required>
                                    <option selected disabled value="">Choose...</option>
                                    <optgroup label="Faculty">
                                        <option value="ASTIF">ASTIF</option>
                                        <option value="FIS">FIS</option>
                                        <option value="FKAL">FKAL</option>
                                        <option value="FKIKK">FKIKK</option>
                                        <option value="FKIKAL">FKIKAL</option>
                                        <option value="FKJ">FKJ</option>
                                        <option value="FPEP">FPEP</option>
                                        <option value="FPKS">FPKS</option>
                                        <option value="FPL">FPL</option>
                                        <option value="FPPS">FPPS</option>
                                        <option value="FPSK">FPSK</option>
                                        <option value="FPT">FPT</option>
                                        <option value="FSMP">FSMP</option>
                                        <option value="FSSA">FSSA</option>
                                        <option value="FSSK">FSSK</option>
                                    </optgroup>
                                    <optgroup label="Residential College">
                                        <option value="KKTF">KKTF</option>
                                        <option value="KKTM">KKTM</option>
                                        <option value="KKTPAR">KKTPAR</option>
                                        <option value="KKAKF">KKAKF</option>
                                        <option value="KKUSIA">KKUSIA</option>
                                        <option value="NR">NR</option>
                                    </optgroup>
                                    <optgroup label="Others">
                                        <option value="GENERAL">General</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="new-club-description" class="rsans fw-bold form-label">Description</label>
                                <textarea id="new-club-description" name="new_club_description" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="new-image-input" class="rsans fw-bold form-label">Add club image (optional)</label>
                                <div class="rsans input-group w-100">
                                    <input type="file" id="new-image-input" name="new_club_image" class="form-control w-50" accept="image/*">
                                </div>
                                <p class="rsans py-2">Note: This image will be shown when users search for the club. It can be edited later.</p>
                            </div>
                            <!-- Preview of to-be-uploaded file -->
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-3 align-items-center text-center pb-3">
                                    <div class="card h-100" id="card-club-images-previewer">
                                        <img id="new-image-preview" src="{{ asset('images/no_club_images_default.png') }}" alt="New club illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
                                        <div class="rsans card-body d-flex justify-content-center align-items-center h-100">
                                            <p class="mb-1">New image preview</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <x-footer/>
</body>

</html>
