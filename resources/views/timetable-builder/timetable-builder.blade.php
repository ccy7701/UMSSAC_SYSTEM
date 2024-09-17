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

        <div class="row align-items-center py-3">

        </div>

    </div>
    <x-footer/>
</body>

</html>