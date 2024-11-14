<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Added Study Partners</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/suggester/addedListOperations.js')
    @vite('resources/js/searchInputToggle.js')
    <x-topnav/>
    <x-about/>
    <x-response-popup
        messageType="added-to-list"
        iconClass="text-primary fa fa-user-plus"
        title="Study partner added"/>
    <x-response-popup
        messageType="deleted-from-list"
        iconClass="text-secondary fa fa-user-times"
        title="Study partner removed"/>
    <main class="flex-grow-1 d-flex justify-content-center mt-xl-5 mt-lg-5">
        <div id="main-card" class="card">
            <!-- PAGE HEADER -->
            <div class="row-container align-items-center px-3 mt-lg-0 mt-md-3 mt-sm-3 mt-xs-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center mt-md-0 mt-sm-0 mt-xs-3 mt-3">
                        <h3 class="rserif fw-bold w-100 mb-3">Added study partners list</h3>
                        <!-- SEARCH TAB -->
                        <div class="row pb-3">
                            <form class="d-flex justify-content-center" method="GET" action="{{ route('study-partners-suggester.added-list') }}">
                                <div id="search-bar-standard" class="input-group w-70 mb-1">
                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                    <input type="search" id="search-standard" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                    <button class="rsans btn btn-primary fw-bold">Search</button>
                                </div>
                                <div id="search-bar-compact" class="input-group w-80 mb-1">
                                    <input type="search" id="search-compact" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                    <button class="rsans btn btn-primary fw-bold">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- VIEW ICONS -->
                        <div class="row pb-3 d-flex justify-content-center">
                            <div id="added-sp-view-toggle" class="rsans input-group d-flex justify-content-center px-0">
                                <!-- list of SPs added by the user; -->
                                <button id="toggle-self-view" class="btn d-flex justify-content-center align-items-center fw-semibold w-40 border">
                                    Added by me ({{ $totalAddedSPs }})
                                </button>
                                <!-- list of SPs that have added the user -->
                                <button id="toggle-others-view" class="btn d-flex justify-content-center align-items-center fw-semibold w-40 border">
                                    Added by others ({{ $totalAddedBySPs }})
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BODY OF CONTENT -->
            <div class="row-container">
                <!-- SPs added by the user -->
                <div id="self-view">
                    <div id="added-sps-standard" class="py-3 px-5">
                        <x-added-sps 
                            :addedstudypartners="$addedStudyPartners"
                            :type="'1'"
                            :intersectionarray="$intersectionArray"/>
                    </div>
                    <div id="added-sps-compact" class="py-3 px-5">
                        <x-added-sps-compact
                            :addedstudypartners="$addedStudyPartners"
                            :type="'1'"
                            :intersectionarray="$intersectionArray"/>
                    </div>
                </div>
                <!-- SPs who have added the user -->
                <div id="others-view">
                    <div id="added-by-sps-standard" class="py-3 px-5">
                        <x-added-sps
                            :addedstudypartners="$addedByStudyPartners"
                            :type="'2'"
                            :intersectionarray="$intersectionArray"/>
                    </div>
                    <div id="added-by-sps-compact" class="py-3 px-5">
                        <x-added-sps-compact
                            :addedstudypartners="$addedByStudyPartners"
                            :type="'2'"
                            :intersectionarray="$intersectionArray"/>
                    </div>
                </div>
                <x-delete-added-sp/>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
