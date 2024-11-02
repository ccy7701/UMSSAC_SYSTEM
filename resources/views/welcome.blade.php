<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    @vite('resources/sass/app.scss')
</head>

<body class="welcome-body">
    @vite('resources/js/app.js')
    <main>
        <div class="container p-3 mb-xl-3 mb-lg-3 mb-md-4 mb-sm-5">
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
        <br>
        <div class="container pb-3 mb-xl-3 mb-lg-3 mb-md-4 mb-sm-5">
            <h1 class="rserif welcome-title fw-bold text-center">Enrich your student life with UMSSACS</h1>
            <p class="rserif welcome-subtitle text-center">UMSSACS is designed to help you keep track of your uni life</p>
        </div>
        <br>
        <div class="image-carousel px-sm-5">
            <div id="carousel-track-standard" class="carousel-track">
                <img src="{{ asset('images/welcome-standard/study_partner_suggester.png') }}" alt="Study partner suggester placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/study_partner_list.png') }}" alt="Study partner list placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/bookmarked_events.png') }}" alt="Bookmarked events placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/acad_prog_tracker.png') }}" alt="Academic progress tracker placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/timetable_builder.png') }}" alt="Timetable builder placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/system_users.png') }}" alt="System users placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/study_partner_suggester.png') }}" alt="Study partner suggester placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/study_partner_list.png') }}" alt="Study partner list placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/bookmarked_events.png') }}" alt="Bookmarked events placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/acad_prog_tracker.png') }}" alt="Academic progress tracker placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/timetable_builder.png') }}" alt="Timetable builder placeholder illustration" class="img-fluid mx-3 border shadow">
                <img src="{{ asset('images/welcome-standard/system_users.png') }}" alt="System users placeholder illustration" class="img-fluid mx-3 border shadow">
            </div>
        </div>
    </main>
</body>

</html>
