<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="profile-faculty" content="{{ profile()->profile_faculty }}">
    <meta name="profile-course" content="{{ profile()->profile_course }}">
    <title>Edit General Info</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/facultyCoursesLoader.js')
    @if (currentAccount()->account_role != 3)
        <x-topnav/>
    @else
        <x-admin-topnav/>
    @endif
    <br>
    <main class="flex-grow-1">
        <div class="container p-3">
            <!-- PROFILE PICTURE -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Profile picture</h3>
                    </div>
                    <div class="col-md-6 text-end"></div>
                </div>
            </div>
            <div class="row align-items-center py-3">
                <div class="col-md-2 text-center">
                    <img src="{{ profile()->profile_picture }}" class="rounded-circle" alt="User profile" style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #AAAAAA;">
                </div>
                <div class="col-md-10">
                    <h2 class="rserif fw-bold">{{ currentAccount()->account_full_name }}</h2>
                    <p class="rserif text-muted fs-5">
                        @switch(currentAccount()->account_role)
                            @case(1) Student @break
                            @case(2) Faculty Member @break
                            @case(3) Admin @break
                        @endswitch
                    </p>
                </div>
            </div>
            <br>
            <!-- EDIT GENERAL INFO FORM -->
            <form action="{{ route('profile.edit.general-info.action') }}" method="POST">
                @csrf
                <input type="hidden" name="account_role" value="{{ currentAccount()->account_role }}">
    
                <div class="d-flex align-items-center">
                    <div class="section-header row w-100">
                        <div class="col-md-6 text-start">
                            <h3 class="rserif fw-bold w-100 py-2">General</h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('profile') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                            <button type="submit" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Save</button>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                    <br>
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {!! $error !!}
                            <br>
                        @endforeach
                    </div>
                @endif
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="container px-3 w-75">
                        <div class="form-group mb-3">
                            <label for="full-name" class="rsans fw-bold form-label">Full name</label>
                            <input type="text" id="full-name" name="account_full_name" class="rsans form-control" value="{{ currentAccount()->account_full_name }}" readonly disabled>
                        </div>
                        <!-- KIV: Is there a more graceful way to show a placeholder or value? -->
                        <div class="form-group mb-3">
                            <label for="nickname" class="rsans fw-bold form-label">Nickname</label>
                            <input type="text" id="nickname" name="profile_nickname" class="rsans form-control" value="{{ profile()->profile_nickname }}">
                        </div>
                        @if(currentAccount()->account_role == 1)
                            <div class="form-group mb-3">
                                <label for="matric-number" class="rsans fw-bold form-label">Matric number</label>
                                <input type="text" id="matric-number" name="account_matric_number" class="rsans form-control" value="{{ currentAccount()->account_matric_number }}" readonly disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label for="enrolment-session" class="rsans fw-bold form-label">Enrolment session</label>
                                <input type="text" id="enrolment-session" class="rsans form-control" value="{{ profile()->profile_enrolment_session }}" readonly disabled>
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="faculty" class="rsans fw-bold form-label">Faculty</label>
                            <select id="faculty" class="rsans form-select w-50" name="profile_faculty">
                                <option selected disabled value="">Choose...</option>
                                <option value="ASTIF">ASTIF</option>
                                <option value="FIS">FIS</option>
                                <option value="FKAL">FKAL</option>
                                <option value="FKIKK">FKIKK</option>
                                <option value="FKIKAL">FKIKAL</option>
                                <option value="FKJ">FKJ</option>
                                <option value="FPEP">FPEP</option>
                                <option value="FPL">FPL</option>
                                <option value="FPP">FPP</option>
                                <option value="FPSK">FPSK</optino>
                                <option value="FPT">FPT</option>
                                <option value="FSMP">FSMP</option>
                                <option value="FSSA">FSSA</option>
                                <option value="FSSK">FSSK</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="course" class="rsans fw-bold form-label">Course</label>
                            <select id="course" class="rsans form-select" name="profile_course">
                                <option select disabled value="">Choose...</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="personal-desc" class="rsans fw-bold form-label">Personal description</label>
                            <textarea id="personal-desc" name="profile_personal_desc" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024">{{ profile()->profile_personal_desc }}</textarea>
                        </div>
                    </div>
                </div>
                <br>
            </form>
            <!-- ACCOUNT -->
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
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
                        <input type="password" id="password" name="account_password" class="form-control" value="xxxxxxxxxx" readonly disabled>
                    </div>
                </form>
            </div>
            <br>
        </div>
    </main>
    <x-footer/>
</body>

</html>
