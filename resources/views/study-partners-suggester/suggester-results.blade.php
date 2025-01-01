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

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    <x-topnav/>
    <x-about/>
    <x-feedback/>
    <x-response-popup
        messageType="bookmark-create"
        iconClass="text-primary fa-solid fa-bookmark"
        title="Bookmark created"/>
    <x-response-popup
        messageType="bookmark-delete"
        iconClass="text-primary fa-regular fa-bookmark"
        title="Bookmark deleted"/>
    <x-response-popup
        messageType="added-to-list"
        iconClass="text-primary fa fa-user-plus"
        title="Study partner added"/>
    <main class="flex-grow-1 d-flex justify-content-center mt-xl-5 mt-lg-5">
        <div id="main-card-suggester" class="card">
            <!-- PAGE HEADER -->
            <div class="row-container align-items-center px-3 mt-lg-0 mt-md-3 mt-sm-3 mt-xs-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div id="results-text" class="col-12 text-center">
                        <h3 class="rserif fw-bold py-2 mb-0">Suggested for you</h3>
                        <p id="header-subtitle" class="rserif fs-4 w-100 mt-0">
                            Here are some potential study partners most similar to your characteristics
                        </p>
                    </div>
                </div>
            </div>
            <div class="row-container">
                <!-- BODY OF CONTENT -->
                <div id="content-body-standard" class="rsans justify-content-center align-items-center py-3 px-5 align-self-center">
                    <!-- LOOPING COMPONENT GOES HERE -->
                    @php
                        $data = json_decode($suggestions, true);
                    @endphp
                    <div id="suggested-sps-standard">
                        <x-suggested-sps :data="$data"/>
                    </div>
                    <div id="suggested-sps-compact">
                        <x-suggested-sps-compact :data="$data"/>
                    </div>
                </div>
            </div>
            <!-- REDO SUGGESTER FORM -->
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-12">
                            <h3 class="rserif fw-bold w-100">Redo the form</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-container d-flex justify-content-center align-items-center py-3 mb-3">
                <div class="row w-75">
                    <div class="rsans card text-center p-0">
                        <div class="card-body align-items-center justify-content-center">
                            <p class="card-text">
                                Click the button below to redo the study partner suggester form. Once you complete the form, your previous submission will be updated.
                            </p>
                            <a href="{{ route('study-partners-suggester.suggester-form') }}" class="section-button-short rsans btn btn-primary fw-semibold text-center">Redo the form</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
