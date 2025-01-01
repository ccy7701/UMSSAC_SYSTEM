<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Request for New Club Creation</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/imageViewer.js')
    <x-topnav/>
    <x-about/>
    <x-feedback/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <main class="flex-grow-1 d-flex justify-content-center mt-xl-5 mt-lg-5">
        <div id="main-card" class="card">
            <form action="{{ route('club-creation.requests.new.action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="requester_profile_id" value="{{ profile()->profile_id }}">
                <!-- PAGE HEADER -->
                <div class="row-container align-items-center px-3 mt-lg-0 mt-md-3 mt-sm-3 mt-xs-3 mt-3">
                    <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                        <div class="col-12 text-center">
                            <h3 id="header-title" class="rserif fw-bold w-100 mb-1">Request for new club creation</h3>
                            <p id="header-subtitle" class="rserif w-100 mt-0">Fill in the details below to request for a new club</p>
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
                            <label for="new-club-name" class="rsans fw-bold form-label">Club name</label>
                            <input type="text" id="new-club-name" name="new_club_name" class="rsans form-control" value="{{ old('new_club_name') }}" required>
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
                                <input type="file" id="new-image-input" name="new_club_image" class="form-control w-50" value="{{ old('new_club_image') }}" accept="image/*" disabled>
                            </div>
                            <p class="rsans form-text text-start">Maximum allowed image file size is 2048KB only.</p>
                        </div>
                        <!-- Preview of to-be-uploaded file -->
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-4 col-lg-6 col-sm-6 col-8 align-items-center text-center pb-3">
                                <div class="card h-100" id="card-club-images-previewer">
                                    <img id="new-image-preview" src="{{ asset('images/no_club_images_default.png') }}" alt="New club illustration preview" class="card-img-top border-bottom" style="aspect-ratio: 4/4; object-fit: cover;">
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
                    <div id="col-action-buttons-row" class="col-12 d-flex justify-content-center align-items-center">
                        <button onclick="history.back(); return false;" class="cancel-compact rsans text-decoration-none text-dark fw-bold px-3">Cancel</button>
                        <button type="submit" class="w-40 rsans btn btn-primary fw-bold px-3">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <x-footer/>
</body>

</html>
