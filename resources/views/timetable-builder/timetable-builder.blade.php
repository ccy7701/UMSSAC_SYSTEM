<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Timetable Builder</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/timetableBuilder/timetableBuilderOperations.js')
    <x-topnav/>
    <x-about/>
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold py-2">Timetable builder</h3>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- TIMETABLE CORE -->
        <div class="row-container table-responsive px-3">
            <table id="timetable-core" class="timetable rsans table-bordered text-center">
                <!-- Days of the week (header) -->
                <thead>
                    <tr>
                        <th id="time-header">Time</th>
                        <th>7am<br>8am</th>
                        <th>8am<br>9am</th>
                        <th>9am<br>10am</th>
                        <th>10am<br>11am</th>
                        <th>11am<br>12pm</th>
                        <th>12pm<br>1pm</th>
                        <th>1pm<br>2pm</th>
                        <th>2pm<br>3pm</th>
                        <th>3pm<br>4pm</th>
                        <th>4pm<br>5pm</th>
                        <th>5pm<br>6pm</th>
                        <th>6pm<br>7pm</th>
                        <th>7pm<br>8pm</th>
                        <th>8pm<br>9pm</th>
                        <th>9pm<br>10pm</th>
                    </tr>
                </thead>
                <tbody id="timetable-body">
                    <!-- Timetable rows will be dynamically generated here -->
                </tbody>
            </table>
        </div>
        <!-- Send route templates to external JS -->
        <script>
            window.getTimetableSlotRouteTemplate = "{{ route('timetable-builder.get-slot-data', ['timetable_slot_id' => ':timetable_slot_id']) }}";
            window.getSlotsByDayRouteTemplate = "{{ route('timetable-builder.get-slots-by-day', ['class_day' => ':class_day', 'profile_id' => ':profile_id']) }}";
            window.editTimetableSlotRouteTemplate = "{{ route('timetable-builder.edit', ['timetable_slot_id' => ':timetable_slot_id']) }}";
            window.deleteTimetableSlotRouteTemplate = "{{ route('timetable-builder.delete', ['timetable_slot_id' => ':timetable_slot_id']) }}";
            window.csrfToken = "{{ csrf_token() }}";
        </script>
        <!-- Timetable download button -->
        <div class="row-container d-flex justify-content-center align-items-center p-5">
            <button id="download-timetable" type="button" class="rsans btn btn-primary fw-bold">
                Download timetable
            </button>
        </div>
        <!-- Timetable subjects list card -->
        <div id="timetable-subjects-list" class="row-container justify-content-center align-items-center align-self-center pb-3 px-3">
            <div class="card shadow-sm px-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div id="subcard-col-left" class="col-lg-8 col-12 mt-2">
                            <h4 class="rserif card-title fw-bold py-2">Subjects on the timetable</h4>
                        </div>
                        <div id="subcard-col-right" class="col-lg-4 col-12">
                            <button id="add-subject-button" type="button" class="rsans btn btn-primary fw-bold w-50"
                                data-bs-toggle="modal"
                                data-bs-target="#add-ttslot-auto">Add timetable slot</button>
                        </div>
                        <x-add-ttslot-auto/>
                        <x-add-ttslot-manual/>
                        <x-edit-timetable-slot/>
                        <x-delete-timetable-slot/>
                        <!-- Timetable clash detected modal -->
                        <x-timetable-clash-modal modalId="timetable-clash-modal-add"/>
                        <x-timetable-clash-modal modalId="timetable-clash-modal-edit"/>
                        <!-- Time error modal (for when end time earlier than start time) -->
                        <x-time-error-modal modalId="time-error-modal-add"/>
                        <x-time-error-modal modalId="time-error-modal-edit"/>
                    </div>
                    <!-- SUBJECTS ADDED TABLE -->
                    <div class="table-responsive mt-3">
                        <table class="rsans table table-hover">
                            <thead class="fw-bold">
                                <tr>
                                    <th>Code</th>
                                    <th>Subject Name</th>
                                    <th>Section</th>
                                    <th>Lecturer</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th></th> <!-- Edit tools column -->
                                </tr>
                            </thead>
                            <tbody id="subjects-added-table-body">
                                <!-- LOOPING COMPONENT GOES HERE -->
                            </tobdy>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </main>
    <x-footer/>
</body>

</html>
