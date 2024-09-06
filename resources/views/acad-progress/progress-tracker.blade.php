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
                    @foreach($all_semesters as $semester)
                        <option value="{{ $semester->sem_prog_log_id }}">
                            S{{ $semester->semester }}-{{ $semester->academic_session }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Handle the dropdown change and fetch via AJAX -->
            <script>
                document.getElementById('select-semester').addEventListener('change', function() {
                    const semesterId = this.value;
                    console.log('semesterId = ', semesterId);
                    if (semesterId) {
                        const url = `{{ route('fetch-subject-stats', ['sem_prog_log_id' => '']) }}/${semesterId}`;
                        console.log('Fetching data from:', url);  // Debugging line

                        fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);  // Catch non-200 responses
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Fetched data:', data);

                                // Update CGPA value in the view
                                const cgpa = data.cgpa ? data.cgpa.toFixed(2) : '0.00';
                                document.querySelector('#cgpa-value').textContent = cgpa;
                                // Update CGPA and SGPA values in the view
                                const sgpa = data.sgpa ? data.sgpa.toFixed(2) : '0.00';
                                document.querySelector('#sgpa-value').textContent = sgpa;

                                // Update CGPA message and color based on the value
                                const cgpaMessageElement = document.querySelector('#cgpa-message');
                                if (cgpa >= 3.67) {
                                    cgpaMessageElement.textContent = 'On track to first class';
                                    cgpaMessageElement.style.color = '#15AA07';
                                } else if (cgpa < 3.67 && cgpa > 0) {
                                    cgpaMessageElement.textContent = 'You\'re on the right path!';
                                    cgpaMessageElement.style.color = '#FF0000';
                                } else {
                                    cgpaMessageElement.textContent = 'No data available';
                                    cgpaMessageElement.style.color = '#BBBBBB';
                                }
                                
                                // Update SGPA message and color based on the value
                                const sgpaMessageElement = document.querySelector('#sgpa-message');
                                if (sgpa >= 3.50) {
                                    sgpaMessageElement.textContent = 'On track to dean\'s list';
                                    sgpaMessageElement.style.color = '#15AA07';
                                } else if (sgpa < 3.50 && sgpa > 0) {
                                    sgpaMessageElement.textContent = 'Good effort, keep pushing!';
                                    sgpaMessageElement.style.color = '#B4C75C';
                                } else {
                                    sgpaMessageElement.textContent = 'No data available';
                                    sgpaMessageElement.style.color = '#BBBBBB';
                                }

                                // Ensure we access the subjects array
                                const subjects = data.subjects || [];
                                const tableBody = document.getElementById('subjects-taken-table-body');
                                tableBody.innerHTML = ''; // Clear previous data

                                if (subjects.length > 0) {
                                    subjects.forEach(subject => {
                                        const row = document.createElement('tr');
                                        row.className = 'text-left align-middle';

                                        row.innerHTML = `
                                            <td>${subject.subject_code}</td>
                                            <td>${subject.subject_name}</td>
                                            <td>${subject.subject_credit_hours}</td>
                                            <td>${subject.subject_grade}</td>
                                            <td>${subject.subject_grade_point.toFixed(2)}</td>
                                            <td style="width: 1%;">
                                                <div class="dropdown">
                                                    <button class="subject-row btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton${subject.subject_code}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton${subject.subject_code}">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="editSubject(${subject.sem_prog_log_id}, '${subject.subject_code}')" data-bs-target="#editSubjectModal">Edit</a>
                                                        </li>
                                                        <li><a class="text-danger dropdown-item" href="#">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        `;
                                        tableBody.appendChild(row);
                                    });
                                } else {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                            <td colspan="6">No subjects added yet</td>
                                        `;
                                        tableBody.appendChild(row);
                                }
                            })
                            .catch(error => console.error('Error fetching subject stats:', error));
                    }
                });

                function editSubject(sem_prog_log_id, subject_code) {
                    const subjectDataRoute = "{{ route('get_subject_data', ['sem_prog_log_id' => ':sem_prog_log_id', 'subject_code' => ':subject_code']) }}";

                    const url = subjectDataRoute
                        .replace(':sem_prog_log_id', sem_prog_log_id)
                        .replace(':subject_code', subject_code);

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            // Populate modal form fields with fetched data
                            document.getElementById('edit-subject-code').value = data.subject_code;
                            document.getElementById('edit-subject-name').value = data.subject_name;
                            document.getElementById('edit-subject-credit-hours').value = data.subject_credit_hours;
                            document.getElementById('edit-subject-grade').value = data.subject_grade;
                            document.getElementById('edit-selected-semester').value = sem_prog_log_id;

                            // Dynamically update the form action to point to the update route
                            const formAction = `{{ route('update-subject', ['sem_prog_log_id' => ':sem_prog_log_id', 'subject_code' => ':subject_code']) }}`
                                .replace(':sem_prog_log_id', sem_prog_log_id)
                                .replace(':subject_code', subject_code);

                            console.log("NEW_FORMACTION:", formAction);

                            document.getElementById('edit-subject-form').action = formAction;

                            // Open the modal
                            const editModal = new bootstrap.Modal(document.getElementById('editSubjectModal'));
                            editModal.show();
                        })
                        .catch(error => console.error('Error fetching subject data:', error));
                }
            </script>

            <!-- RESULTS OVERVIEW -->
            <div class="row py-3">
                <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                    <div class="card shadow-sm w-80 p-3">
                        <div class="card-body">
                            <!-- WORK IN PROGRESS HERE -->
                            <h4 class="rserif card-title fw-bold pb-0">S1-2021/2022 results at a glance</h4>
                            <!-- WORK IN PROGRESS HERE -->
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
                                        <h1 class="rserif fw-bold fs-1 py-0" id="cgpa-value">0.00</h1>
                                        <h2 class="rslab fs-5 py-0" style="color: #BBBBBB;" id="cgpa-message">Select a sem first</h2>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div>
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
            </div>
            <script>
                window.onload = function () {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                };
            </script>

            <!-- TEMPORARY -->
            @if ($errors->any())
                <br>
                <div class="rsans alert alert-danger">
                    @foreach($errors->all() as $error)
                        {!! $error !!}
                        <br>
                    @endforeach
                </div>
            @endif
            <!-- TEMPORARY -->

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
                                        <button id="add-subject-button" type="button" class="rsans btn btn-primary fw-bold px-2 w-50" data-bs-toggle="modal" data-bs-target="#addSubjectModal" disabled>Add subject</button>
                                    </div>
                                    <x-add-subject/> <!-- add-subject modal form -->
                                    <x-edit-subject/> <!-- edit-subject modal form -->
                                </div>
                            </div>
                            <script>
                                const semesterDropdown = document.getElementById('select-semester');
                                const addButton = document.getElementById('add-subject-button');

                                function checkSemesterSelection() {
                                    const selectedSemester = semesterDropdown.value;
                                    if (selectedSemester) {
                                        addButton.disabled = false;
                                    } else {
                                        addButton.disabled = true;
                                    }
                                }

                                semesterDropdown.addEventListener('change', checkSemesterSelection);
                            </script>
                            <!-- SUBJECTS TAKEN TABLE -->
                            <div class="table-responsive" style="overflow: visible;">
                                <table class="rsans table table-hover">
                                    <thead class="fw-bold">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject name</th>
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
            </div>
        </div>
    </div>

    <x-footer/>
</body>
