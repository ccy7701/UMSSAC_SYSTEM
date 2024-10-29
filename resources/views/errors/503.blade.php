<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 Service Unavailable</title>
    @vite('resources/sass/app.scss')
</head>

<body class="error-page-body">
    @vite('resources/js/app.js')
    <main class="d-flex justify-content-center align-items-center vh-100">
        <div class="text-center px-5">
            <h1 class="rserif display-1 fw-bold">503</h1>
            <p class="rserif fw-bold fs-2">SERVICE UNAVAILABLE</p>
            <p class="rsans">Be right back! We're doing some housekeeping right now. Please check back soon.</p>
        </div>
    </main>
</body>

</html>