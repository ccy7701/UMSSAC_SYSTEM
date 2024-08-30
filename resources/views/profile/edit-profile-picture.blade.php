<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile Picture</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @include('components.topnav')
    <br>
    <div class="container p-3">
        <!-- EDIT PROFILE PICTURE FORM -->
        <form action="{{ route('profile.edit-profile-picture-action') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center">
                <div class="profile-section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Profile picture</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="javascript:history.back()" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                        <button type="submit" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Save</button>
                    </div>
                </div>
            </div>
            <div class="row align-items-center py-3">
                <div class="col-md-2 text-center">
                    <img id="profile-picture-preview" src="{{ Auth::user()->profile && Auth::user()->profile->profilePictureFilePath ? Storage::url(Auth::user()->profile->profilePictureFilePath) : asset('images/no-pic-default.png') }}" class="rounded-circle border" alt="Profile picture" style="width: 200px; height: 200px; object-fit: cover">
                </div>
                <div class="col-md-10">
                    <input id="profile-picture-input" type="file" name="newProfilePicture" class="form-control-file">
                </div>
            </div>
            <br>
        </form>
        <script>
            document.getElementById('profile-picture-input').addEventListener('change', function(event) {
                const[file] = event.target.files;
                if (file) {
                    document.getElementById('profile-picture-preview').src = URL.createObjectURL(file);
                }
            });
        </script>
        <!-- GENERAL -->
        <div class="d-flex align-items-center">
            <div class="profile-section-header row w-100">
                <div class="col-md-6 text-start">
                    <h3 class="rserif fw-bold w-100 py-2">General</h3>
                </div>
                <div class="col-md-6 text-end"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
            <form class="px-3 w-75">
                <div class="form-group mb-3">
                    <label for="fullName" class="rsans fw-bold form-label">Full name</label>
                    <input type="text" id="fullName" name="accountFullName" class="form-control" value="Ruan Mei" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="nickname" class="rsans fw-bold form-label">Nickname</label>
                    <input type="text" id="nickname" name="profileNickname" class="form-control" value="ruan_mei" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="matricNumber" class="rsans fw-bold form-label">Matric number</label>
                    <input type="text" id="matricNumber" name="accountMatricNumber" class="form-control" value="BI21110236" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="enrolmentSession" class="rsans fw-bold form-label">Enrolment session</label>
                    <input type="text" id="enrolmentSession" name="profileEnrolmentSession" class="form-control w-50" value="2021/2022" readonly> 
                </div>
                <div class="form-group mb-3">
                    <label for="faculty" class="rsans fw-bold form-label">Faculty</label>
                    <input type="text" id="faculty" name="profileFaculty" class="form-control w-50" value="FKIKK" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="programme" class="rsans fw-bold form-label">Programme</label>
                    <input type="text" id="programme" name="profileProgramme" class="form-control" value="HC00 Software Engineering" readonly>
                </div>
            </form>
        </div>
        <br>
        <!-- ACCOUNT -->
        <div class="d-flex align-items-center">
            <div class="profile-section-header row w-100">
                <div class="col-md-6 text-start">
                    <h3 class="rserif fw-bold w-100 py-2">Account</h3>
                </div>
                <div class="col-md-6 text-end"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
            <form class="px-3 w-75">
                <div class="form-group mb-3">
                    <label for="email" class="rsans fw-bold form-label">E-mail address</label>
                    <input type="email" id="email" name="accountEmailAddress" class="form-control" value="test@email.com" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="rsans fw-bold form-label">Password</label>
                    <input type="password" id="password" name="accountPassword" class="form-control" value="xxxxxxxxxx" readonly>
                </div>
            </form>
        </div>
        <br>
    </div>
    @include('components.footer')
    @vite('resources/js/app.js')
</body>

</html>