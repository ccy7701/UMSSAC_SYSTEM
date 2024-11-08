<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Internal Server Error | UMSSACS</title>
    @vite('resources/sass/app.scss')
</head>

<body class="error-page-body">
    @vite('resources/js/app.js')
    <main class="d-flex justify-content-center align-items-center vh-100">
        <div class="text-center px-5">
            <h1 class="rserif display-1 fw-bold">500</h1>
            <p class="rserif fw-bold fs-2">INTERNAL SERVER ERROR</p>
            <p class="rsans">Oops! Something went wrong on our end. Please try again later.</p>
            <a href="{{ route('welcome') }}" class="rsans btn btn-secondary fw-semibold w-50 mt-2">Go back</a>
        </div>
    </main>
</body>

</html>
