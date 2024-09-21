<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    @if (currentAccount()->account_role != 3)
        <x-topnav/>
    @else
        <x-admin-topnav/>
    @endif
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <div class="container p-3">
        <!-- PROFILE PICTURE -->
        <div class="d-flex align-items-center">
            <div class="section-header row w-100">
                <div class="col-md-6 text-start">
                    <h3 class="rserif fw-bold w-100 py-2">Profile picture</h3>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('profile.edit.profile-picture') }}" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3">
            <div class="col-md-2 text-center">
                <img src="{{ asset(profile()->profile_picture) }}" class="rounded-circle" alt="User profile" style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #AAAAAA;">
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
        <!-- GENERAL -->
        <div class="d-flex align-items-center">
            <div class="section-header row w-100">
                <div class="col-md-6 text-start">
                    <h3 class="rserif fw-bold w-100 py-2">General</h3>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('profile.edit.general-info') }}" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Edit</a>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
            <form class="px-3 w-75">
                <div class="form-group mb-3">
                    <label for="full-name" class="rsans fw-bold form-label">Full name</label>
                    <input type="text" id="full-name" name="account_full_name" class="rsans form-control" value="{{ currentAccount()->account_full_name }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="nickname" class="rsans fw-bold form-label">Nickname</label>
                    <input type="text" id="nickname" name="profile_nickname" class="rsans form-control" value="{{ profile()->profile_nickname }}" readonly>
                </div>
                @if(currentAccount()->account_role == 1)
                    <div class="form-group mb-3">
                        <label for="matric-number" class="rsans fw-bold form-label">Matric number</label>
                        <input type="text" id="matric-number" name="account_matric_number" class="rsans form-control" value="{{ currentAccount()->account_matric_number }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="enrolment-session" class="rsans fw-bold form-label">Enrolment session</label>
                        <input type="text" id="enrolment-session" name="profile_enrolment_session" class="rsans form-control w-50" value="{{ profile()->profile_enrolment_session }}" readonly>
                    </div>
                @endif
                <div class="form-group mb-3">
                    <label for="faculty" class="rsans fw-bold form-label">Faculty</label>
                    <input type="text" id="faculty" name="profile_faculty" class="rsans form-control w-50" value="{{ profile()->profile_faculty }}" readonly>
                </div>
                @php
                    $facultyCourses = json_decode(file_get_contents(public_path('resources/data/faculties_and_courses.json')), true);
                    $selectedFaculty = profile()->profile_faculty;
                    $selectedCourseCode = profile()->profile_course;
                    $courseName = '';

                    if (isset($facultyCourses[$selectedFaculty])) {
                        foreach ($facultyCourses[$selectedFaculty] as $course) {
                            if ($course['course_code'] === $selectedCourseCode) {
                                $courseName = $course['course_name'];
                                break;
                            }
                        }
                    }
                @endphp
                <div class="form-group mb-3">
                    <label for="course" class="rsans fw-bold form-label">Course</label>
                    <input type="text" id="course" name="profile_course" class="rsans form-control" value="{{ profile()->profile_course }} {{ $courseName }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="personal-desc" class="rsans fw-bold form-label">Personal description</label>
                    <textarea id="personal-desc" name="profile_personal_desc" class="rsans form-control" rows="5" style="resize: none;" readonly>{{ profile()->profile_personal_desc }}</textarea>
                </div>
            </form>
        </div>
        <br>
        <!-- ACCOUNT -->
        <div class="d-flex align-items-center">
            <div class="section-header row w-100">
                <div class="col-md-6 text-start">
                    <h3 class="rserif fw-bold w-100 py-2">Account</h3>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('change-password') }}" class="rsans btn btn-primary fw-bold px-2 mx-2 w-25">Change password</a>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
            <form class="px-3 w-75">
                <div class="form-group mb-3">
                    <label for="email-address" class="rsans fw-bold form-label">E-mail address</label>
                    <input type="email" id="email-address" name="account_email_address" class="rsans form-control" value="{{ currentAccount()->account_email_address }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="rsans fw-bold form-label">Password</label>
                    <input type="password" id="password" name="account_password" class="rsans form-control" value="xxxxxxxxxx" readonly>
                </div>
            </form>
        </div>
        <br>
    </div>
    <x-footer/>
    @vite('resources/js/app.js')
</body>

</html>
