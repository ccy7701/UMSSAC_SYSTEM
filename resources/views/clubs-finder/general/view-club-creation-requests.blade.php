<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Club Creation Requests</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/clubRequests.js')
    <x-topnav/>
    <x-about/>
    <x-response-popup
        messageType="sent"
        iconClass="text-success fa-regular fa-circle-check"
        title="Request sent"/>
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center px-0">
                        <h3 class="rserif fw-bold w-100 mb-3">Club creation requests</h3>
                        <!-- VIEW ICONS -->
                        <div class="row pb-3 d-flex justify-content-center px-0 mx-0">
                            <div id="club-requests-view-toggle" class="rsans input-group d-flex justify-content-center px-0 mb-2">
                                <!-- List of requests marked as pending -->
                                <button id="toggle-pending-view" class="btn d-flex justify-content-center align-items-center fw-semibold w-30 border px-0">
                                    Pending
                                </button>
                                <!-- List of requests marked as accepted -->
                                <button id="toggle-accepted-view" class="btn d-flex justify-content-center align-items-center fw-semibold w-30 border px-0">
                                    Accepted
                                </button>
                                <!-- List of requsts marked as rejected -->
                                <button id="toggle-rejected-view" class="btn d-flex justify-content-center align-items-center fw-semibold w-30 px-0 border">
                                    Rejected
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BODY OF CONTENT -->
        <div class="row-container">
            <div id="content-body" class="rsans justify-content-center align-items-center py-3 px-5 align-self-center">
                <!-- Requests marked as pending -->
                <div id="pending-view">
                    @foreach ($pendingRequests as $request)
                        <div class="row pb-3">
                            <x-club-request-list-item :request="$request"/>
                        </div>
                    @endforeach
                </div>
                <!-- Requests marked as accepted -->
                <div id="accepted-view">
                    @foreach ($acceptedRequests as $request)
                        <div class="row pb-3">
                            <x-club-request-list-item :request="$request"/>
                        </div>
                    @endforeach
                </div>
                <!-- Requests marked as rejected -->
                <div id="rejected-view">
                    @foreach ($rejectedRequests as $request)
                        <div class="row pb-3">
                            <x-club-request-list-item :request="$request"/>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>