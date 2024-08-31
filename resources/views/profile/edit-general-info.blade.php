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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                <img src="{{ profile()->profile_picture }}" class="rounded-circle border" alt="Profile picture" style="width: 200px; height: 200px; object-fit: cover">
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
        <form action="{{ route('profile.edit-general-info-action') }}" method="POST">
            @csrf
            <input type="hidden" name="account_role" value="{{ currentAccount()->account_role }}">

            <div class="d-flex align-items-center">
                <div class="profile-section-header row w-100">
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
                        <input type="text" id="full-name" name="account_full_name" class="form-control" value="{{ currentAccount()->account_full_name }}" readonly disabled>
                    </div>
                    <!-- KIV: Is there a more graceful way to show a placeholder or value? -->
                    <div class="form-group mb-3">
                        <label for="nickname" class="rsans fw-bold form-label">Nickname</label>
                        <input type="text" id="nickname" name="profile_nickname" class="form-control" value="{{ profile()->profile_nickname }}">
                    </div>
                    @if(currentAccount()->account_role == 1)
                        <div class="form-group mb-3">
                            <label for="matric-number" class="rsans fw-bold form-label">Matric number</label>
                            <input type="text" id="matric-number" name="account_matric_number" class="form-control" value="{{ currentAccount()->account_matric_number }}" readonly disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="enrolment-session-select" class="rsans fw-bold form-label">Enrolment session</label>
                            <select id="enrolment-session-select" class="form-select w-50" name="profile_enrolment_session">
                                <option selected disabled value="">Choose...</option>
                                <!-- KIV: Is this the most graceful way to handle it considering future usecases? -->
                                <option value="2021/2022" {{ old('profile_enrolment_session', profile()->profile_enrolment_session) == '2021/2022' ? 'selected' : '' }}>2021/2022</option>
                                <option value="2022/2023" {{ old('profile_enrolment_session', profile()->profile_enrolment_session) == '2022/2023' ? 'selected' : '' }}>2022/2023</option>
                                <option value="2023/2024" {{ old('profile_enrolment_session', profile()->profile_enrolment_session) == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                                <option value="2024/2025" {{ old('profile_enrolment_session', profile()->profile_enrolment_session) == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select an enrolment session.
                            </div>
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <label for="faculty" class="rsans fw-bold form-label">Faculty</label>
                        <select id="faculty" class="form-select w-50" name="profile_faculty">
                            <option selected disabled value="">Choose...</option>
                            <option value="ASTIF">ASTIF</option>
                            <option value="FIS">FIS</option>
                            <option value="FKAL">FKAL</option>
                            <option value="FKI">FKI</option>
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
                        <label for="programme" class="rsans fw-bold form-label">Programme</label>
                        <select id="programme" class="form-select" name="profile_programme">
                            <option select disabled value="">Choose...</option>
                        </select>
                    </div>
                    <script>
                        $(document).ready(function() {
                            let facultyProgrammes = {};

                            // Load the JSON file
                            $.getJSON('{{ asset("resources/data/faculties_and_programmes.json") }}', function(data) {
                                facultyProgrammes = data;

                                // Pre-select the faculty and populate programmes if they already exist
                                let selectedFaculty = "{{ profile()->profile_faculty }}";
                                let selectedProgramme = "{{ profile()->profile_programme }}";

                                if (selectedFaculty) {
                                    $('#faculty').val(selectedFaculty).change();
                                    populateProgrammes(selectedFaculty, selectedProgramme);
                                }
                            });

                            // Handle change event for faculty dropdown
                            $('#faculty').change(function() {
                                var selectedFaculty = $(this).val();
                                $('#programme').empty().append('<option selected disabled value="">Choose...</option>');
                                populateProgrammes(selectedFaculty);
                            });

                            function populateProgrammes(faculty, selectedProgramme = null) {
                                if (facultyProgrammes[faculty]) {
                                    facultyProgrammes[faculty].forEach(function(programme) {
                                        let isSelected = (programme.course_code === selectedProgramme) ? 'selected' : '';
                                        $('#programme').append('<option value="' + programme.course_code + '" ' + isSelected + '>' + programme.course_code + ' ' + programme.course_name + '</option>');
                                    });
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </form>
    </div>
    @include('components.footer')
    @vite('resources/js/app.js')
</body>

</html>