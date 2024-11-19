<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $profile->account->account_full_name }}'s Profile | UMSSACS</title>
    <meta name="description" content="Visit UMSSACS and learn more about {{ $profile->account->account_full_name }}.">
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @if (currentAccount()->account_role != 3)
        <x-topnav/>
    @else
        <x-admin-topnav/>
    @endif
    <x-about/>
    <main class="flex-grow-1 d-flex justify-content-center mt-xl-5 mt-lg-5">
        <div id="main-card" class="card">
            <!-- PROFILE PICTURE -->
            <div class="row-container align-self-center py-3">
                <div class="col-12 text-center my-2">
                    <img id="user-profile-picture" src="{{ $profile->profile_picture }}" class="rounded-circle" alt="User profile">
                </div>
                <div class="col-12 text-center mt-3 mb-2">
                    <h2 class="rserif fw-bold">{{ $profile->account->account_full_name }}</h2>
                    <h4 class="rserif fst-italic mt-2 text-muted">({{ $profile->profile_nickname }})</h4>
                    <p class="rserif text-muted fs-4 mt-0">
                        @switch($profile->account->account_role)
                            @case(1) Student @break
                            @case(2) Faculty Member @break
                            @case(3) Admin @break
                        @endswitch
                    </p>
                </div>
            </div>
            <!-- GENERAL -->
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-left-alt col-lg-6 col-md-6 col-12 mt-2">
                            <h3 class="rserif fw-bold w-100">General info</h3>
                        </div>
                        <div class="col-right-alt col-lg-6 col-md-6 col-12 mt-xl-2 mt-sm-0 d-flex align-items-center"></div>
                    </div>
                </div>
            </div>
            <div class="row-container">
                <div class="container px-3 py-4">
                    @if ($profile->account->account_role == 1)
                        <h5 class="rserif fw-bold">Matric number</h5>
                        <p class="rsans pb-3">{{ $profile->account->account_matric_number }}</p>
                        <h5 class="rserif fw-bold">Enrolment session</h5>
                        <p class="rsans pb-3">{{ $profile->profile_enrolment_session }}</p>
                    @endif
                    <h5 class="rserif fw-bold">Faculty</h5>
                    <p class="rsans pb-3">{{ $profile->profile_faculty }}</p>
                    @if ($profile->account->account_role == 1)
                        <h5 class="rserif fw-bold">Course</h5>
                        @php
                            $selectedFaculty = $profile->profile_faculty;
                            $courseCode = null;
                            $courseName = '';

                            if ($selectedFaculty == "") {
                                $selectedFaculty = 'Not filled yet';
                                $courseName = 'Not filled yet';
                            } else {
                                $facultyCourses = json_decode(file_get_contents(public_path('resources/data/faculties_and_courses.json')), true);
                                $selectedCourseCode = $profile->profile_course;
                                $courseName = '';
                                
                                if (isset($facultyCourses[$selectedFaculty])) {
                                    if ($selectedCourseCode == "") {
                                        $courseName = 'Not filled yet';
                                    } else {
                                        foreach ($facultyCourses[$selectedFaculty] as $course) {
                                            if ($course['course_code'] === $selectedCourseCode) {
                                                $courseName = $course['course_code'] . ' ' . $course['course_name'];
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        @endphp
                        <p class="rsans pb-3">{{ $courseName }}</p>
                    @endif
                    <h5 class="rserif fw-bold">Personal description</h5>
                    <p class="rsans pb-3">{{ $profile->profile_personal_desc }}</p>
                    <h5 class="rserif fw-bold">Email address</h5>
                    <p class="rsans pb-3">{{ $profile->account->account_email_address }}</p>
                    <h5 class="rserif fw-bold">Contact number</h5>
                    <p class="rsans pb-3">
                        @php
                            $contactNumber = $profile->account->account_contact_number ?? 'Not filled yet';
                        @endphp
                        {{ $contactNumber }}
                    </p>
                </div>
            </div>
            @if ($profile->account->account_role != 3)
                <!-- JOINED CLUBS -->
                <div class="row-container">
                    <div class="align-items-center px-3">
                        <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                            <div class="col-left-alt col-lg-6 col-md-6 col-12 mt-2">
                                <h3 class="rserif fw-bold w-100">Joined clubs</h3>
                            </div>
                            <div class="col-right-alt col-lg-6 col-md-6 col-12 mt-xl-2 mt-sm-0 d-flex align-items-center"></div>
                        </div>
                    </div>
                </div>
                <div class="row-container container-fluid align-items-center my-3 py-3 px-4">
                    <div class="rsans row">
                        <div class="col-12 px-0">
                            <div id="grid-view" class="row grid-view ms-2">
                                <div class="row pb-3 px-md-3 px-sm-0">
                                @if ($joinedClubs->isNotEmpty())
                                    @foreach ($joinedClubs as $club)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-6 mb-3 px-2">
                                            <x-club-card :club="$club"/>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center w-100">This user hasn't joined any clubs yet</p>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
    <x-footer/>
</body>

</html>
