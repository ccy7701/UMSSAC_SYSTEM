<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 Page Expired | UMSSACS</title>
    @vite('resources/sass/app.scss')
</head>

<body class="error-page-body">
    @vite('resources/js/app.js')
    <main class="d-flex justify-content-center align-items-center vh-100">
        <div class="text-center px-5">
            <h1 class="rserif display-1 fw-bold">419</h1>
            <p class="rserif fw-bold fs-2">PAGE EXPIRED</p>
            <p class="rsans">Oops, it looks like your session timed out. Please log in again to continue.</p>
            <a href="{{ route('login') }}" class="rsans btn btn-secondary fw-semibold w-50 mt-2">Go to login page</a>
        </div>
    </main>
</body>

</html>
