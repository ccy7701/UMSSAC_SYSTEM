<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggested Study Partners</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/suggesterResultsOperations.js')
    <x-topnav/>
    <br>
    <main class="flex-grow-1">
        <div class="container p-3">
            <div class="d-flex align-items-center">
                <!-- TOP SECTION -->
                <div class="section-header row w-100">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">Suggested for you</h3>
                        <p class="rserif fs-4 w-100 mt-0">
                            Here are ten potential study partners most similar to your characteristics
                        </p>
                    </div>
                </div>
            </div>
            <!-- BODY OF CONTENT -->
            <div id="content-body" class="rsans justify-content-center align-items-center py-3 align-self-center">
                <!-- LOOPING COMPONENT GOES HERE -->
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
