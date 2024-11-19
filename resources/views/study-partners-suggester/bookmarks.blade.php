<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bookmarked Study Partners</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/searchInputToggle.js')
    <x-topnav/>
    <x-about/>
    <x-response-popup
        messageType="bookmark-delete"
        iconClass="text-primary fa-regular fa-bookmark"
        title="Bookmark deleted"/>
    <x-response-popup
        messageType="added-to-list"
        iconClass="text-primary fa fa-user-plus"
        title="Study partner added"/>
    <main class="flex-grow-1 d-flex justify-content-center mt-xl-5 mt-lg-5">
        <div id="main-card" class="card">
            <!-- PAGE HEADER -->
            <div class="row-container align-items-center px-3 mt-lg-0 mt-md-3 mt-sm-3 mt-xs-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center mt-md-0 mt-sm-0 mt-xs-3 mt-3">
                        <h3 class="rserif fw-bold w-100 mb-1">Bookmarked study partners</h3>
                        <p id="header-subtitle" class="rserif w-100 mt-0">
                            @if ($totalBookmarks == 0)
                                No bookmarks found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @elseif ($totalBookmarks == 1)
                                1 bookmark found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @else
                                {{ $totalBookmarks }} bookmarks found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @endif
                        </p>
                        <!-- SEARCH BAR -->
                        <div class="row pb-3">
                            <div class="col-12 px-0">
                                <form class="d-flex justify-content-center" method="GET" action="{{ route('study-partners-suggester.bookmarks') }}">
                                    <div id="search-bar-standard" class="input-group w-70">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                        <input type="search" id="search-standard" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                        <button class="rsans btn btn-primary fw-bold">Search</button>
                                    </div>
                                    <div id="search-bar-compact" class="input-group w-80">
                                        <input type="search" id="search-compact" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                        <button class="rsans btn btn-primary fw-bold">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BODY OF CONTENT -->
            <div class="row-container">
                <div id="bookmarked-sps-standard" class="py-3 px-5">
                    <x-bookmarked-sps :bookmarks="$bookmarks"/>
                </div>
                <div id="bookmarked-sps-compact" class="py-3 px-5">
                    <x-bookmarked-sps-compact :bookmarks="$bookmarks"/>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
