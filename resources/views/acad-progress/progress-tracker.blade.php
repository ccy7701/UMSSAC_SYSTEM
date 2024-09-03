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
    <x-topnav/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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

            <div class="form-group mb-3">
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

            

        </div>

    </div>

    <x-footer/>
    @vite('resources/js/app.js')
</body>