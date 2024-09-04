<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Progress Tracker</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')

    <x-topnav/>

    <br>

    <div class="container p-3">

        <div class="d-flex align-items-center">
            <div class="acad-progress-section-header row w-100">
                <div class="col-12 text-center">
                    <h3 class="rserif fw-bold w-100 py-2">Academic progress tracker</h3>
                </div>
            </div>
        </div>

        <div class="row align-items-center py-3">

            <!-- SEMESTER SELECTOR -->
            <div class="form-group pb-3">
                <label for="select-semester" class="rsans form-label me-2">Select semester:</label>
                <select id="select-semester" class="rsans form-select w-50" name="#">
                    <option selected disabled value="">Choose...</option>
                    <option value="S1-2021/2022">S1-2021/2022</option>
                    <option value="S2-2021/2022">S2-2021/2022</option>
                    <option value="S1-2022/2023">S1-2022/2023</option>
                    <option value="S2-2022/2023">S2-2022/2023</option>
                    <option value="S1-2023/2024">S1-2023/2024</option>
                    <option value="S2-2023/2024">S2-2023/2024</option>
                    <option value="S1-2024/2025">S1-2024/2025</option>
                    <option value="S2-2024/2025">S2-2024/2025</option>
                </select>
            </div>

            <!-- RESULTS OVERVIEW -->
            <div class="row py-3">
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="card shadow-sm w-80 p-3">
                        <div class="card-body">
                            <h4 class="rserif card-title fw-bold pb-0">S1-2021/2022 results at a glance</h4>
                            <p class="rslab card-text fs-5">How are my results so far?</p>
                            <br>
                            <div class="row">
                                <!-- CGPA Section -->
                                <div class="col-md-4 d-flex align-items-center">
                                    <div>
                                        <div class="d-flex">
                                            <h2 class="rslab fs-5">CGPA up to this sem</h2>
                                            <span><i class="align-self-center fa-regular fa-circle-question px-2" data-bs-toggle="tooltip" data-bs-placement="right" title="Cumulative Grade Point Average calculated up to this semester."></i></span>
                                        </div>
                                        <h1 class="rserif fw-bold fs-1 py-0">3.89</h1>
                                        <h2 class="rslab fs-5 py-0" style="color: #15AA07;">On track to first class</h2>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div>
                                        <div class="d-flex">
                                            <h2 class="rslab fs-5">SGPA</h2>
                                            <span><i class="fa-regular fa-circle-question px-2" data-bs-toggle="tooltip" data-bs-placement="right" title="Semester Grade Point Average for this semester only."></i></span>
                                        </div>
                                        <h1 class="rserif fw-bold fs-1 py-0">3.69</h1>
                                        <h2 class="rslab fs-5 py-0" style="color:#15AA07;">On track to dean's list</h2>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                window.onload = function () {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                };
            </script>

            <!-- SUBJECTS TAKEN TABLE -->
            <div class="row pb-3 pt-2">
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="card shadow-sm w-80 p-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="acad-progress-section-header row w-100">
                                    <div class="col-md-8 text-start px-3">
                                        <h4 class="rserif card-title fw-bold py-2 placeholder-glow">Subjects taken this semester</h4>
                                    </div>
                                    <div class="col-md-4 text-end px-3">
                                        <a href="#" class="rsans btn btn-primary fw-bold px-2 w-50">Add subject</a>
                                    </div>
                                </div>
                            </div>
                            <!-- SUBJECTS TAKEN TABLE -->
                            <div class="table-responsive" style="overflow: visible;">
                                <table class="rsans table table-hover">
                                    <thead class="fw-bold">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject name</th>
                                            <th>Credit</th>
                                            <th>Grade</th>
                                            <th>Grade Point</th>
                                            <th></th>   <!-- Edit tools column -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- LOOPING COMPONENT -->
                                        <x-acad-progress-subject-row
                                            :code="'KK34703'"
                                            :subject_name="'Web Engineering'"
                                            :credit="3"
                                            :grade="'A'"
                                            :grade_point="12.00"/>
                                        <x-acad-progress-subject-row
                                            :code="'KK34302'"
                                            :subject_name="'Parallel Programming and Distributed System'"
                                            :credit="2"
                                            :grade="'A-'"
                                            :grade_point="7.34"/>
                                        <x-acad-progress-subject-row
                                            :code="'KK34102'"
                                            :subject_name="'Software Engineering Project'"
                                            :credit="2"
                                            :grade="'A-'"
                                            :grade_point="7.34"/>
                                        <x-acad-progress-subject-row
                                            :code="'KK34502'"
                                            :subject_name="'Augmented Reality/Virtual Reality'"
                                            :credit="2"
                                            :grade="'A'"
                                            :grade_point="8.00"/>
                                        <x-acad-progress-subject-row
                                            :code="'KK34702'"
                                            :subject_name="'Cloud Computing'"
                                            :credit="2"
                                            :grade="'A'"
                                            :grade_point="8.00"/>
                                        <x-acad-progress-subject-row
                                            :code="'NP40503'"
                                            :subject_name="'Food Ingredients and Usage'"
                                            :credit="3"
                                            :grade="'B'"
                                            :grade_point="9.00"/>
                                        <x-acad-progress-subject-row
                                            :code="'KT34102'"
                                            :subject_name="'Technopreneurship'"
                                            :credit="2"
                                            :grade="'A'"
                                            :grade_point="8.00"/>
                                        <!-- END LOOPING COMPONENT -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <x-footer/>
</body>