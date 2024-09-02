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
    <x-topnav/>
    <br>
    <div class="container p-3">
        <!-- EDIT PROFILE PICTURE FORM -->
        <form action="{{ route('profile.edit.profile-picture.action') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center">
                <div class="profile-section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Profile picture</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('profile') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                        <button type="submit" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Save</button>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <br>
                <div class="rsans alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {!! $error !!}
                        <br>
                    @endforeach
                </div>
            @endif
            <div class="row align-items-center py-3">
                <div class="col-md-2 text-center">
                    <img id="profile-picture-preview" src="{{ profile()->profile_picture }}" class="rounded-circle border" alt="Profile picture" style="width: 200px; height: 200px; object-fit: cover">
                </div>
                <div class="col-md-10">
                    <input id="profile-picture-input" type="file" name="new_profile_picture" class="rsans form-control-file">
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
                    <label for="full-name" class="rsans fw-bold form-label">Full name</label>
                    <input type="text" id="full-name" name="account_full_name" class="rsans form-control" value="{{ currentAccount()->account_full_name }}" readonly disabled>
                </div>
                <div class="form-group mb-3">
                    <label for="nickname" class="rsans fw-bold form-label">Nickname</label>
                    <input type="text" id="nickname" name="profile_nickname" class="rsans form-control" value="{{ profile()->profile_nickname }}" readonly disabled>
                </div>
                @if(currentAccount()->account_role == 1)
                    <div class="form-group mb-3">
                        <label for="matric-number" class="rsans fw-bold form-label">Matric number</label>
                        <input type="text" id="matric-number" name="account_matric_number" class="rsans form-control" value="{{ currentAccount()->account_matric_number }}" readonly disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="enrolment-session" class="rsans fw-bold form-label">Enrolment session</label>
                        <input type="text" id="enrolment-session" name="profile_enrolment_session" class="rsans form-control w-50" value="{{ profile()->profile_enrolment_session }}" readonly disabled> 
                    </div>
                @endif
                <div class="form-group mb-3">
                    <label for="faculty" class="rsans fw-bold form-label">Faculty</label>
                    <input type="text" id="faculty" name="profile_faculty" class="rsans form-control w-50" value="{{ profile()->profile_faculty }}" readonly disabled>
                </div>
                <div class="form-group mb-3">
                    <label for="course" class="rsans fw-bold form-label">Course</label>
                    <input type="text" id="course" name="profile_course" class="rsans form-control" value="{{ profile()->profile_course }}" readonly disabled>
                </div>
                <div class="form-group mb-3">
                    <label for="personal-desc" class="rsans fw-bold form-label">Personal description</label>
                    <textarea id="personal-desc" name="profile_personal_desc" class="rsans form-control" rows="5" style="resize: none;" readonly disabled>{{ profile()->profile_personal_desc }}</textarea>
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
                    <label for="email-address" class="rsans fw-bold form-label">E-mail address</label>
                    <input type="email" id="email-address" name="account_email_address" class="rsans form-control" value="{{ currentAccount()->account_email_address }}" readonly disabled>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="rsans fw-bold form-label">Password</label>
                    <input type="password" id="password" name="account_password" class="rsans form-control" value="xxxxxxxxxx" readonly disabled>
                </div>
            </form>
        </div>
        <br>
    </div>
    <x-footer/>
    @vite('resources/js/app.js')
</body>

</html>