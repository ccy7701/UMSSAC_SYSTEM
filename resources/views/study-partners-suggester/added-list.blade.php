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
                    </div>
                </div>
            </div>
        </div>
        <!-- BODY OF CONTENT -->
        <div class="row-container">
            <div id="content-body" class="rsans justify-content-center align-items-center py-3 px-5 align-self-center">
                <p class="rsans fs-1">Study partners that I have added ({{ $totalAddedSPs }})</p>
                @foreach ($addedStudyPartners as $record)
                    <div class="row pb-3">
                        <x-added-sp-list-item
                        :record="$record"
                        :type="1"
                        :intersectionarray="$intersectionArray"/>
                    </div>
                @endforeach
                <x-delete-added-sp/>
                <p class="rsans fs-1">Study partners that have added me ({{ $totalAddedBySPs }})</p>
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
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
