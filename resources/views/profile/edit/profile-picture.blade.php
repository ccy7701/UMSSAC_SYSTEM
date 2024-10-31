<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile Picture</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/picturePreviewer.js')
    @if (currentAccount()->account_role != 3)
        <x-topnav/>
    @else
        <x-admin-topnav/>
    @endif
    <br>
    <main class="flex-grow-1">
        <form action="{{ route('profile.edit.profile-picture.action') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-left-alt col-lg-6 col-md-4 col-12 mt-xl-2 mt-sm-0 mt-0">
                            <h3 class="rserif fw-bold w-100">Profile picture</h3>
                        </div>
                        <div class="col-right-alt col-lg-6 col-md-8 col-12 align-self-center mb-xl-0 mb-md-0 mb-sm-3 mb-3">
                            <a href="{{ route('my-profile') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                            <button type="submit" class="section-button-short rsans btn btn-primary fw-bold px-3">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-container align-self-center py-3">
                @if ($errors->any())
                    <div class="col-12 px-3">
                        <div class="rsans alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <i class="fa fa-circle-exclamation px-2"></i>
                                {!! $error !!}
                                <br>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="col-12 text-center my-2">
                    <img id="profile-picture-preview" src="{{ profile()->profile_picture }}" class="rounded-circle" alt="User profile" style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #AAAAAA;">
                </div>
                <div class="col-12 d-flex justify-content-center mt-3 mb-2">
                    <div class="form-group mb-3 w-80">
                        <input type="file" name="new_profile_picture" id="profile-picture-input" class="rsans form-control" accept="image/*">
                        <div id="pfp-note" class="rsans form-text text-start">Maximum allowed image file size is 2048KB only.</div>
                    </div>
                </div>
            </div>
        </form>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
