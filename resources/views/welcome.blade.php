<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="welcome-background">
    <div class="container p-3">
        <div class="row align-items-center">
            <!-- Logo section -->
            <div class="col-md-3 col-sm-2 col-xs-2">
                <img src="{{ asset('images/UMSSACS_LOGO_FINAL.png') }}" alt="UMSSACS logo" class="img-fluid">
            </div>
            <!-- Links and buttons section -->
            <div class="col-md-9 col-sm-2 col-xs-2 text-end">
                <a href="#" class="text-decoration-none text-dark fw-bold px-3">Features</a>
                <a href="#" class="text-decoration-none text-dark fw-bold px-3">Login</a>
                <a href="#" class="btn btn-primary fw-bold px-3 mx-2">Get started</a>
            </div>
        </div>
    </div>

    <!-- 
    <div class="container">
        <div class="row">
            <div class="col-7 border">
                <b>Hello world!</b>
                <br>
                <button type="button" class="btn btn-primary">PRIMARY</button>
            </div>
            <div class="col-5 border">
                <b>I am using Bootstrap.</b>
                <br>
                <button type="button" class="btn btn-secondary">SECONDARY</button>
            </div>
        </div>
    </div>
-->

    <!-- BOOTSTRAP JS -->
    <script src="resources/js/bootstrap.js"></script>
</body>

</html>