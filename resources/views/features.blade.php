<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features | UMSSACS</title>
    <meta name="description" content="Make the most of uni life. From managing academic activities to uncovering events, UMSSACS helps you to stay organised and engaged.">
    @vite('resources/sass/app.scss')
</head>

<body class="features-body d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    <main class="flex-grow-1 m-0">
        <div class="container p-3">
            <div class="row align-items-center">
                <!-- Logo section -->
                <div class="col-md-3 col-sm-4 col-xs-12 py-2 text-center">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="features-website-logo img-fluid">
                    </a>
                </div>
                <!-- Links and buttons section -->
                <div class="features-nav col-md-9 col-sm-8 col-xs-12 py-2">
                    <a href="{{ route('login') }}" class="rsans text-decoration-none text-dark fw-bold px-3">Login</a>
                    <a href="{{ route('register') }}" class="rsans btn btn-primary fw-bold px-3 mx-2">Get started</a>
                </div>
            </div>
        </div>
        <div class="container p-3">
            <div class="midsection row align-items-center">
                <!-- Illustration section -->
                <div class="col-md-6 col-xs-12 text-center pb-3">
                    <img src="{{ asset('images/features_illustration.png') }}" alt="Features illustration" class="features-illustration img-fluid">
                </div>
                <!-- Text section -->
                <div class="features-text col-md-6 col-xs-12">
                    <h2 class="rserif fw-bold fs-1">Make the most of uni life</h2>
                    <p class="rserif fs-4">From managing academic activities to uncovering events, UMSSACS helps you to stay organised and engaged.</p>
                </div>
            </div>
        </div>
        <div class="row p-5 m-0" style="background-color: white;">
            <p class="benefits-subtitle rserif fs-5 text-uppercase text-center mb-1">Benefits overview</p>
            <h2 class="rserif fw-bold fs-2 text-center mt-1 mb-5">Why use UMSSACS?</h2>
            <br><br><br>
            <div id="benefits-carousel-standard" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card h-100 text-center shadow p-xl-5 p-md-4">
                                    <div class="card-img-top text-start">
                                        <div class="feature-card-circle rounded-circle mb-3 mt-xl-0 mt-md-2 p-3 d-flex justify-content-center align-items-center" style="background-color: #D8D1E7;">
                                            <i class="fa fa-calendar-days"></i>
                                        </div>
                                    </div>
                                    <div class="card-body justify-content-center align-items-start text-start px-0 pb-0">
                                        <h4 class="rserif card-title fw-bold">Stay organized</h4>
                                        <p class="rserif card-text">Easily manage your academic schedule, track your progress, and set goals to ensure you stay on top of your studies.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card h-100 text-center shadow p-xl-5 p-md-4">
                                    <div class="card-img-top text-start">
                                        <div class="feature-card-circle rounded-circle mb-3 mt-xl-0 mt-md-2 p-3 d-flex justify-content-center align-items-center" style="background-color: #D1E7D3;">
                                            <i class="fa fa-ticket"></i>
                                        </div>
                                    </div>
                                    <div class="card-body justify-content-center align-items-start text-start px-0 pb-0">
                                        <h4 class="rserif card-title fw-bold">Discover campus events</h4>
                                        <p class="rserif card-text">Find events, clubs and activities from around campus that match your interests and passions.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card h-100 text-center shadow p-xl-5 p-md-4">
                                    <div class="card-img-top text-start">
                                        <div class="feature-card-circle rounded-circle mb-3 mt-xl-0 mt-md-2 p-3 d-flex justify-content-center align-items-center" style="background-color: #E7D1D5;">
                                            <i class="fa fa-user-group"></i>
                                        </div>
                                    </div>
                                    <div class="card-body justify-content-center align-items-start text-start px-0 pb-0">
                                        <h4 class="rserif card-title fw-bold">Find study partners</h4>
                                        <p class="rserif card-text">Use our study partner suggester tool to connect with fellow students that share your characteristics.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card h-100 text-center shadow p-xl-5 p-md-4">
                                    <div class="card-img-top text-start">
                                        <div class="feature-card-circle rounded-circle mb-3 mt-xl-0 mt-md-2 p-3 d-flex justify-content-center align-items-center" style="background-color: #F9DFBB;">
                                            <i class="fa fa-clock"></i>
                                        </div>
                                    </div>
                                    <div class="card-body justify-content-center align-items-start text-start px-0 pb-0">
                                        <h4 class="rserif card-title fw-bold">Timetable builder</h4>
                                        <p class="rserif card-text">Create and customize your academic timetable. Choose your courses, plan your days, and avoid conflicts with the timetable builder.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card h-100 text-center shadow p-xl-5 p-md-4">
                                    <div class="card-img-top text-start">
                                        <div class="feature-card-circle rounded-circle mb-3 mt-xl-0 mt-md-2 p-3 d-flex justify-content-center align-items-center" style="background-color: #F9C0BB;">
                                            <i class="fa fa-users-viewfinder"></i>
                                        </div>
                                    </div>
                                    <div class="card-body justify-content-center align-items-start text-start px-0 pb-0">
                                        <h4 class="rserif card-title fw-bold">Explore campus clubs</h4>
                                        <p class="rserif card-text">Find and join clubs that match your passions. Whether you're into sports, arts, or academics, our club search tool connects you with like-minded peers.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card h-100 text-center shadow p-xl-5 p-md-4">
                                    <div class="card-img-top text-start">
                                        <div class="feature-card-circle rounded-circle mb-3 mt-xl-0 mt-md-2 p-3 d-flex justify-content-center align-items-center" style="background-color: #BBF9DB;">
                                            <i class="fa fa-user-tie"></i>
                                        </div>
                                    </div>
                                    <div class="card-body justify-content-center align-items-start text-start px-0 pb-0">
                                        <h4 class="rserif card-title fw-bold">Administrative tools</h4>
                                        <p class="rserif card-text">Efficiently manage clubs, events, memberships, and handle administrative duties with tools for committee members and administrators.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="benefits-carousel-small" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card h-100 text-center p-4">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-start text-start">
                                        <div class="rounded-circle mb-3 p-3 d-flex justify-content-center align-items-center" style="background-color: #D8D1E7; width: 15vh; height: 15vh;">
                                            <i class="fa fa-calendar-days" style="font-size: 3.5rem; color: #3C3C3C"></i>
                                        </div>
                                        <h4 class="rserif card-title fw-bold">Stay organized</h4>
                                        <p class="rserif card-text">Easily manage your academic schedule, track your progress, and set goals to ensure you stay on top of your studies.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card h-100 text-center p-4">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-start text-start">
                                        <div class="rounded-circle mb-3 p-3 d-flex justify-content-center align-items-center" style="background-color: #D1E7D3; width: 15vh; height: 15vh;">
                                            <i class="fa fa-ticket" style="font-size: 3.5rem; color: #3C3C3C"></i>
                                        </div>
                                        <h4 class="rserif card-title fw-bold">Discover campus events</h4>
                                        <p class="rserif card-text">Find events, clubs and activities from around campus that match your interests and passions.</p>
                                    </div>
                                </div>
                            </diV>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card h-100 text-center p-4">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-start text-start">
                                        <div class="rounded-circle mb-3 p-3 d-flex justify-content-center align-items-center" style="background-color: #E7D1D5; width: 15vh; height: 15vh;">
                                            <i class="fa fa-user-group" style="font-size: 3.5rem; color: #3C3C3C"></i>
                                        </div>
                                        <h4 class="rserif card-title fw-bold">Find study partners</h4>
                                        <p class="rserif card-text">Use our study partner suggester tool to connect with fellow students that share your characteristics.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card h-100 text-center p-4">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-start text-start">
                                        <div class="rounded-circle mb-3 p-3 d-flex justify-content-center align-items-center" style="background-color: #D8D1E7; width: 15vh; height: 15vh;">
                                            <i class="fa fa-clock" style="font-size: 3.5rem; color: #3C3C3C"></i>
                                        </div>
                                        <h4 class="rserif card-title fw-bold">Timetable builder</h4>
                                        <p class="rserif card-text">Create and customize your academic timetable. Choose your courses, plan your days, and avoid conflicts with the timetable builder.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card h-100 text-center p-4">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-start text-start">
                                        <div class="rounded-circle mb-3 p-3 d-flex justify-content-center align-items-center" style="background-color: #D1E7D3; width: 15vh; height: 15vh;">
                                            <i class="fa fa-ticket" style="font-size: 3.5rem; color: #3C3C3C"></i>
                                        </div>
                                        <h4 class="rserif card-title fw-bold">Explore campus clubs</h4>
                                        <p class="rserif card-text">Find and join clubs that match your passions. Whether you're into sports, arts, or academics, our club search tool connects you with like-minded peers.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card h-100 text-center p-4">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-start text-start">
                                        <div class="rounded-circle mb-3 p-3 d-flex justify-content-center align-items-center" style="background-color: #E7D1D5; width: 15vh; height: 15vh;">
                                            <i class="fa fa-user-group" style="font-size: 3.5rem; color: #3C3C3C"></i>
                                        </div>
                                        <h4 class="rserif card-title fw-bold">Administrative tools</h4>
                                        <p class="rserif card-text">Efficiently manage clubs, events, memberships, and handle administrative duties with tools for committee members and administrators.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </main>
    <x-footer/>
</body>

</html>
