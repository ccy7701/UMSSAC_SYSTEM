<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Academic Progress Tracker</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/semesterDropdown.js')
    @vite('resources/js/tooltips.js')
    @vite('resources/js/semIdValidator.js')
    @vite('resources/js/semSubOperations.js')
    <x-topnav/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold py-2">Academic progress tracker</h3>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- INITIALISER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                @if (profile()->profile_enrolment_session == '')
                    <div class="d-flex justify-content-center align-items-center py-3 w-100">
                        <div class="card shadow-sm w-90 p-3">
                            <div class="card-body">
                                <h4 class="rserif card-title fw-bold pb-0">Settings things up...</h4>
                                <p class="rsans card-text fs-5">Before we continue, please confirm the following details to set things up.</p>
                                <br>
                                <div class="w-100 d-flex justify-content-center align-items-center">
                                    <form id="initialiser-fill-form" method="POST" action="{{ route('progress-tracker.initialise', ['profile_id' => profile()->profile_id]) }}">
                                        @csrf
                                        <div class="rsans mb-3">
                                            <label for="select-enrolment-session" class="form-label fw-semibold">Enrolment session</label>
                                            <select class="form-select w-100" id="select-enrolment-session" name="profile_enrolment_session" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option value="2021/2022">2021/2022</option>
                                                <option value="2022/2023">2022/2023</option>
                                                <option value="2023/2024">2023/2024</option>
                                                <option value="2024/2025">2024/2025</option>
                                            </select>
                                            <div class="rsans invalid-feedback">
                                                Please select an enrolment session.
                                            </div>
                                        </div>
                                        <div class="rsans mb-3">
                                            <label for="select-course-duration" class="form-label fw-semibold">Course duration</label>
                                            <select class="form-select w-100" id="select-course-duration" name="course_duration" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option value="6">3 years / 6 semesters</option>
                                                <option value="7">3.5 years / 7 semesters</option>
                                                <option value="8">4 years / 8 semesters</option>
                                                <option value="10">5 years / 10 semesters</option>
                                            </select>
                                            <div class="rsans invalid-feedback">
                                                Please select a course duration.
                                            </div>
                                        </div>
                                        <div class="rsans d-flex justify-content-center py-3">
                                            <button id="btn-pass-form" type="button" class="btn btn-primary fw-bold w-50"
                                                data-bs-toggle="modal"
                                                data-bs-target="#submission-confirmation-modal" disabled>Confirm
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Submission confirmation modal -->
                        <div class="rsans modal fade" id="submission-confirmation-modal" tabindex="-1" aria-labelledby="submissionConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header py-2 d-flex align-items-center">
                                        <p class="fw-semibold fs-5 mb-0">
                                            Confirmation
                                        </p>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Confirm if the details are correct before submission. They cannot be changed afterwards.
                                    </div>
                                    <div class="modal-footer">
                                        <form id="initialiser-submit-form" method="POST" action="{{ route('progress-tracker.initialise', ['profile_id' => profile()->profile_id]) }}">
                                            @csrf
                                            <input type="hidden" id="received_profile_enrolment_sesion" name="profile_enrolment_session" value="">
                                            <input type="hidden" id="received_course_duration" name="course_duration" value="">
                                            <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">Wait, go back</button>
                                            <button type="submit" class="btn btn-primary fw-semibold ms-1">OK, continue</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (profile()->profile_enrolment_session != '')
                    <!-- SEMESTER SELECTOR -->
                    <div class="form-group pb-3 px-3">
                        <label for="select-semester" class="rsans form-label me-2">Select semester:</label>
                        <select id="select-semester" class="rsans form-select w-50" name="#">
                            <option selected disabled value="">Choose...</option>
                            @foreach($all_semesters as $semester)
                                <option value="{{ $semester->sem_prog_log_id }}">
                                    S{{ $semester->semester }}-{{ $semester->academic_session }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Send routes templates to external JS -->
                    <script>
                        window.fetchBySemProgLogIdRoute = "{{ route('fetch-subject-stats', ['sem_prog_log_id' => ':sem_prog_log_id']) }}";
                        window.getSubjectDataRouteTemplate = "{{ route('subject-stats-log.get', ['sem_prog_log_id' => ':sem_prog_log_id', 'subject_code' => ':subject_code']) }}";
                        window.editSubjectRouteTemplate = "{{ route('subject-stats-log.edit', ['sem_prog_log_id' => ':sem_prog_log_id', 'subject_code' => ':subject_code']) }}";
                        window.deleteRouteTemplate = "{{ route('subject-stats-log.delete', ['sem_prog_log_id' => ':sem_prog_log_id', 'subject_code' => ':subject_code']) }}";
                        window.csrfToken = "{{ csrf_token() }}";
                    </script>
        
                    <!-- RESULTS OVERVIEW SECTION -->
                    <div class="row-container justify-content-center align-items-center align-self-center py-3">
                        <div class="card shadow-sm p-3">
                            <div class="card-body">
                                <h4 id="semester-results-title" class="rserif card-title fw-bold pb-0">My results at a glance</h4>
                                <p class="rslab card-text fs-5">How are my results so far?</p>
                                <br>
                                <div class="row">
                                    <!-- CGPA Section -->
                                    <div class="col-md-4 d-flex align-items-center">
                                        <div class="py-1">
                                            <div class="d-flex">
                                                <h2 class="rslab fs-5">CGPA up to this sem</h2>
                                                <span><i class="align-self-center fa-regular fa-circle-question px-2" data-bs-toggle="tooltip" data-bs-placement="right" title="Cumulative Grade Point Average calculated up to this semester."></i></span>
                                            </div>
                                            <h1 class="rserif fw-bold fs-1 py-0" id="cgpa-value">0.00</h1>
                                            <h2 class="rslab fs-5 py-0" style="color: #BBBBBB;" id="cgpa-message">Select a sem first</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <div class="py-1">
                                            <div class="d-flex">
                                                <h2 class="rslab fs-5">SGPA</h2>
                                                <span><i class="fa-regular fa-circle-question px-2" data-bs-toggle="tooltip" data-bs-placement="right" title="Semester Grade Point Average for this semester only."></i></span>
                                            </div>
                                            <h1 class="rserif fw-bold fs-1 py-0" id="sgpa-value">0.00</h1>
                                            <h2 class="rslab fs-5 py-0" style="color: #BBBBBB;" id="sgpa-message">Select a sem first</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SUBJECTS TAKEN TABLE -->
                    <div class="row-container justify-content-center align-items-center align-self-center py-3">
                        <div class="card shadow-sm px-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div id="subcard-col-left" class="col-lg-8 col-12 mt-2">
                                        <h4 class="rserif card-title fw-bold py-2 placeholder-glow">Subjects taken this semester</h4>
                                    </div>
                                    <div id="subcard-col-right" class="col-lg-4 col-12">
                                        <button id="add-subject-button" type="button" class="rsans btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#add-subject-modal" disabled>Add subject</button>
                                    </div>
                                    <!-- MODALS -->
                                    <x-add-subject/>
                                    <x-edit-subject/>
                                    <x-delete-subject/>
                                    <!-- Duplicate entry detected modal -->
                                    <div class="rsans modal fade" id="duplicate-entry-modal" tabindex="-1" aria-labelledby="duplicateEntryModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                                                    <p class="fw-semibold fs-5 mb-0">
                                                        Duplicate Entry Detected
                                                    </p>
                                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    A subject with the same subject code already exists in the system. Please check your input again.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Go back</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- SUBJECTS TAKEN TABLE -->
                                <div class="table-responsive mt-3">
                                    <table class="rsans table table-hover">
                                        <thead class="fw-bold">
                                            <tr>
                                                <th>Code</th>
                                                <th>Subject Name</th>
                                                <th>Credit Hours</th>
                                                <th>Grade</th>
                                                <th>Grade Point</th>
                                                <th></th>   <!-- Edit tools column -->
                                            </tr>
                                        </thead>
                                        <tbody id="subjects-taken-table-body">
                                            <!-- LOOPING COMPONENT GOES HERE -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <br>
    </main>
    <x-footer/>
</body>
