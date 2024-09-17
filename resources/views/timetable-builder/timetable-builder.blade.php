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

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/timetableBuilderOperations.js')
    <x-topnav/>
    <br>
    <div class="container p-3">

        <div class="d-flex align-items-center">
            <div class="section-header row w-100">
                <div class="col-12 text-center">
                    <h3 class="rserif fw-bold w-100 py-2">Timetable builder</h3>
                </div>
            </div>
        </div>

        <div class="row align-items-center py-4">

            <!-- TIMETABLE CORE -->
            <table class="timetable rsans table-bordered text-center">
                <!-- Days of the week (header) -->
                <thead>
                    <tr>
                        <th id="time-header">Time</th>
                        <th id="7am-8am">7am<br>8am</th>
                        <th id="8am-9am">8am<br>9am</th>
                        <th id="9am-10am">9am<br>10am</th>
                        <th id="10am-11am">10am<br>11am</th>
                        <th id="11am-12pm">11am<br>12pm</th>
                        <th id="12pm-1pm">12pm<br>1pm</th>
                        <th id="1pm-2pm">1pm<br>2pm</th>
                        <th id="2pm-3pm">2pm<br>3pm</th>
                        <th id="3pm-4pm">3pm<br>4pm</th>
                        <th id="4pm-5pm">4pm<br>5pm</th>
                        <th id="5pm-6pm">5pm<br>6pm</th>
                        <th id="6pm-7pm">6pm<br>7pm</th>
                        <th id="7pm-8pm">7pm<br>8pm</th>
                        <th id="8pm-9pm">8pm<br>9pm</th>
                        <th id="9pm-10pm">9pm<br>10pm</th>
                    </tr>
                </thead>
                <!-- Timetable body -->
                <tbody>
                    <tr>
                        <th id="monday">MON</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th id="tuesday">TUE</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th id="wednesday">WED</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th id="thursday">THU</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th id="friday">FRI</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th id="saturday">SAT</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th id="sunday">SUN</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>


        </div>

        <!-- Send route templates to external JS -->

        <!-- SUBJECTS ON TIMETABLE OVERVIEW -->
        <div class="row pb-3 pt-2">
            <div class=" d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                <div class="card shadow-sm w-100 p-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="row w-100 px-3">
                                <div class="col-md-8 text-start">
                                    <h4 class="rserif card-title fw-bold py-2">Subjects on the timetable</h4>
                                </div>
                                <div class="col-md-4 text-end pe-0">
                                    <button id="add-subject-button" type="button" class="rsans btn btn-primary fw-bold w-50"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addTimetableItem">Add subject</button>
                                </div>
                                <x-add-timetable-item/>
                                <x-edit-timetable-item/>
                            </div>
                        </div>
                        <!-- SUBJECTS ADDED TABLE -->
                        <div class="table-responsive" style="overflow: visible;">
                            <table class="rsans table table-hover">
                                <thead class="fw-bold">
                                    <tr>
                                        <th>Code</th>
                                        <th>Subject name</th>
                                        <th>Section</th>
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
        </div>

    </div>
    <x-footer/>
</body>

</html>
