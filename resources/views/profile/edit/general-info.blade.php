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
    <x-about/>
    <br>
    <main class="flex-grow-1">
        <form action="{{ route('profile.edit.general-info.action') }}" method="POST">
            @csrf
            <div class="row-container align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-left-alt col-lg-6 col-md-4 col-12 mt-xl-2 mt-md-3 mt-sm-0 mt-0 mb-sm-2 mb-xs-2">
                        <h3 class="rserif fw-bold w-100">Edit general info</h3>
                    </div>
                    <div id="col-action-buttons-standard" class="col-right-alt col-lg-6 col-md-8 col-12 align-self-center mb-xl-0 mb-md-0 mb-sm-3 mb-3">
                        <a href="{{ route('my-profile') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                        <button type="submit" class="section-button-short rsans btn btn-primary fw-bold px-3">Save</button>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                <div class="container form-container px-3">
                    @if($errors->any())
                        <br>
                        <div class="rsans alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <i class="fa fa-circle-exclamation px-2"></i>
                                {{ $error }}
                                <br>
                            @endforeach
                        </div>
                        <br>
                    @endif
                    <div class="form-group mb-3">
                        <label for="full-name" class="rsans fw-bold form-label">Full name</label>
                        <input type="text" id="full-name" name="account_full_name" class="rsans form-control" value="{{ currentAccount()->account_full_name }}" readonly disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nickname" class="rsans fw-bold form-label">Nickname (optional)</label>
                        <input type="text" id="nickname" name="profile_nickname" class="rsans form-control" value="{{ profile()->profile_nickname }}" placeholder="Enter nickname">
                    </div>
                    @if (currentAccount()->account_role == 1)
                        <div class="form-group mb-3">
                            <label for="matric-number" class="rsans fw-bold form-label">Matric number</label>
                            <input type="text" id="matric-number" name="account_matric_number" class="rsans form-control" value="{{ currentAccount()->account_matric_number }}" readonly disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="enrolment-session" class="rsans fw-bold form-label">Enrolment session</label>
                            <input type="text" id="enrolment-session" class="rsans form-control" value="{{ profile()->profile_enrolment_session != '' ? profile()->profile_enrolment_session : 'Not filled yet' }}" readonly disabled>
                            <div id="enrolment-session-note" class="rsans form-text">Note: Use the Academic Progress Tracker to initialise your enrolment session.</div>
                        </div>
                    @endif
                    @if (currentAccount()->account_role != 3)
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
                            <option value="FPKS">FPKS</option>
                            <option value="FPL">FPL</option>
                            <option value="FPP">FPP (former)</option>
                            <option value="FPPS">FPPS</option>
                            <option value="FPSK">FPSK</optino>
                            <option value="FPT">FPT</option>
                            <option value="FSMP">FSMP</option>
                            <option value="FSSA">FSSA</option>
                            <option value="FSSK">FSSK</option>
                        </select>
                        <div id="faculty-note" class="rsans form-text">Note: Select "FPP (former)" for courses not listed under FPKS or FPPS.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="course" class="rsans fw-bold form-label">
                            @if(currentAccount()->account_role == 1)
                                Course
                            @elseif(currentAccount()->account_role == 2)
                                Course (optional)
                            @endif
                        </label>
                        <select id="course" class="rsans form-select" name="profile_course">
                            <option select disabled value="">Choose...</option>
                        </select>
                    </div>
                    @endif
                    <div class="form-group mb-3">
                        <label for="personal-desc" class="rsans fw-bold form-label">Personal description (optional)</label>
                        <textarea id="personal-desc" name="profile_personal_desc" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024" placeholder="Enter personal description">{{ profile()->profile_personal_desc }}</textarea>
                    </div>
                </div>
            </div>
            <div id="col-action-buttons-compact" class="row w-100 mx-0 mt-3 justify-content-center">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <a href="{{ route('my-profile') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                    <button type="submit" class="w-40 rsans btn btn-primary fw-bold px-3">Save</button>
                </div>
            </div>
        </form>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
