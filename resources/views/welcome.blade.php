<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    @vite('resources/sass/app.scss')
</head>

<body class="welcome-body">
    <div class="container p-3">
        <div class="row align-items-center">
            <!-- Logo section -->
            <div class="col-md-3 col-sm-4 col-xs-12 py-2 text-center">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="welcome-website-logo img-fluid">
                </a>
            </div>
            <!-- Links and buttons section -->
            <div class="welcome-nav col-md-9 col-sm-8 col-xs-12 py-2">
                <a href="{{ route('features') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Features</a>
                <a href="{{ route('login') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Login</a>
                <a href="{{ route('register') }}" class="rsans btn btn-primary fw-bold px-3 mx-2">Get started</a>
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="container px-6 mx-6">
        <h1 class="rserif welcome-title fw-bold text-center">Enrich your student<br>life with UMSSACS</h1>
        <p class="rserif welcome-subtitle text-center">UMSSACS is designed to help you keep track of your uni life.</p>
    </div>

    <br><br><br><br>

    <div class="image-carousel px-sm-5">
        <div class="carousel-track">
            <img src="{{ asset('placeholder_images/welcome_img_1.png') }}" alt="Welcome image 1" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_2.png') }}" alt="Welcome image 2" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_3.png') }}" alt="Welcome image 3" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_4.png') }}" alt="Welcome image 4" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_5.png') }}" alt="Welcome image 5" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_6.png') }}" alt="Welcome image 6" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_1.png') }}" alt="Welcome image 1" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_2.png') }}" alt="Welcome image 2" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_3.png') }}" alt="Welcome image 3" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_4.png') }}" alt="Welcome image 4" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_5.png') }}" alt="Welcome image 5" class="img-fluid mx-3">
            <img src="{{ asset('placeholder_images/welcome_img_6.png') }}" alt="Welcome image 6" class="img-fluid mx-3">
        </div>
    </div>

    @vite('resources/js/app.js')
</body>

</html>