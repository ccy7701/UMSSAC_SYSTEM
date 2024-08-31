<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit General Info</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @include('components.topnav')
    <br>
    <div class="container p-3">
        <!-- PROFILE PICTURE -->
        <div class="d-flex align-items-center">
            <div class="profile-section-header row w-100">
                <div class="col-md-6 text-start">
                    <h3 class="rserif fw-bold w-100 py-2">Profile picture</h3>
                </div>
                <div class="col-md-6 text-end"></div>
            </div>
        </div>
        <div class="row align-items-center py-3">
            <div class="col-md-2 text-center">
                <img src="{{ Auth::user()->profile && Auth::user()->profile->profilePictureFilePath ? Storage::url(Auth::user()->profile->profilePictureFilePath) : asset('images/no-pic-default.png') }}" class="rounded-circle border" alt="Profile picture" style="width: 200px; height: 200px; object-fit: cover">
            </div>
            <div class="col-md-10">
                <h2 class="rserif fw-bold">Ruan Mei</h2>
                <p class="rserif text-muted fs-5">Student</p>
            </div>
        </div>
        <br>
        <!-- GENERAL -->
    </div>
    @include('components.footer')
    @vite('resources/js/app.js')
</body>

</html>