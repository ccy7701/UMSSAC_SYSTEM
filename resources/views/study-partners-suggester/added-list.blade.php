<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Added Study Partners</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/suggester/addedListOperations.js')
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
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-3">Added study partners list</h3>
                        <!-- SEARCH TAB -->
                        <form class="d-flex justify-content-center" method="GET" action="{{ route('study-partners-suggester.added-list') }}">
                            <div class="search-tab mb-4">
                                <div class="input-group">
                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                    <input type="search" id="added-sps-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                    <button class="rsans btn btn-primary fw-bold">Search</button>
                                </div>
                            </div>
                        </form>
                        <!-- VIEW ICONS -->
                        <div class="row pb-3 d-flex justify-content-center">
                            <div id="added-sp-view-toggle" class="rsans input-group d-flex justify-content-center">
                                <!-- list of SPs added by the user; -->
                                <button id="toggle-self-view" class="btn d-flex justify-content-center align-items-center fw-semibold w-50 border">
                                    Added by me ({{ $totalAddedSPs }})
                                </button>
                                <!-- list of SPs that have added the user -->
                                <button id="toggle-others-view" class="btn d-flex justify-content-center align-items-center fw-semibold w-50 border">
                                    Added by others ({{ $totalAddedBySPs }})
                                </button>
                            </div>
                        </div>
                        <!-- Filter and sort buttons -->
                        <div class="row pb-3">
                            <!-- Left column: Filters popout for smaller displays -->
                            <div id="sysusers-filters-compact" class="col-xl-6 col-md-12 col-sm-12 col-12 align-items-center justify-content-end">
                                <div class="input-group justify-content-end">
                                    <button id="sysusers-sort-compact" class="rsans btn justify-content-center align-items-center border" data-bs-toggle="modal" data-bs-target="#added-list-sort-modal" aria-controls="added-list-sort-modal" aria-label="Added Study Partners Sort Options">
                                        <i class="fa-solid fa-sort fs-4 text-secondary"></i>
                                        <p class="ms-2 mb-0 text-secondary">
                                            @php
                                                $activeSort = request()->input('sort', '');
                                            @endphp
                                            @switch ($activeSort)
                                                @case ('az') Name (A-Z) @break
                                                @case ('za') Name (Z-A) @break
                                                @default Sort
                                            @endswitch
                                        </p>
                                    </button>
                                </div>
                            </div>
                            @php
                                $categoryFilters = $filters ?? [];
                            @endphp
                            <x-sysusers-filters-tab :categoryfilters="$categoryFilters"/>
                            <!-- Right column: View icons -->
                            <div id="sysusers-view-toggle" class="col-xl-12 col-lg-12 col-md-6 col-sm-4 col-4 align-items-center justify-content-end pe-0">
                                <div class="input-group justify-content-end">
                                    <!-- SORT BUTTON -->
                                    <button id="sysusers-sort-standard" class="rsans btn justify-content-center align-items-center border" data-bs-toggle="modal" data-bs-target="#added-list-sort-modal" aria-controls="added-list-sort-modal" aria-label="Added Study Partners Sort Options">
                                        <i class="fa-solid fa-sort fs-4 text-secondary"></i>
                                        <p class="ms-2 mb-0 text-secondary">
                                            @php
                                                $activeSort = request()->input('sort', '');
                                            @endphp
                                            @switch ($activeSort)
                                                @case ('az') Name (A-Z) @break
                                                @case ('za') Name (Z-A) @break
                                                @default Sort
                                            @endswitch
                                        </p>
                                    </button>
                                </div>
                            </div>
                            <x-sort-modal :type="'addedlist'"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BODY OF CONTENT -->
        <div class="row-container">
            <div id="content-body" class="rsans justify-content-center align-items-center py-3 px-5 align-self-center">
                <!-- SPs added by the user -->
                <div id="self-view">
                    @foreach ($addedStudyPartners as $record)
                        <div class="row pb-3">
                            <x-added-sp-list-item
                                :record="$record"
                                :type="1"
                                :intersectionarray="$intersectionArray"/>
                        </div>
                    @endforeach
                    <x-delete-added-sp/>
                </div>
                <!-- SPs who have added the user -->
                <div id="others-view">
                    @foreach ($addedByStudyPartners as $record)
                        <div class="row pb-3">
                            <x-added-sp-list-item
                                :record="$record"
                                :type="2"
                                :intersectionarray="$intersectionArray"/>
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
