<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmarked Study Partners</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    <x-topnav/>
    <x-response-popup
        messageType="bookmark-delete"
        iconClass="text-primary fa-regular fa-bookmark"
        title="Bookmark deleted"/>
    <x-response-popup
        messageType="added-to-list"
        iconClass="text-primary fa fa-user-plus"
        title="Study partner added"/>
    <br>
    <main class="flex-grow-1">
        <!-- PAGE HEADER -->
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-0 d-flex align-items-center">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">Bookmarked study partners</h3>
                        <p id="study-partner-bookmark-count-display" class="rserif fs-4 w-100 mt-0">
                            @if ($totalBookmarks == 0)
                                No bookmarks found
                            @elseif ($totalBookmarks == 1)
                                1 bookmark found
                            @else
                                {{ $totalBookmarks }} bookmarks found
                            @endif
                        </p>
                        <!-- SEARCH TAB -->
                        <form class="d-flex justify-content-center" method="GET" action="{{ route('study-partners-suggester.bookmarks') }}">
                            <div class="search-tab mb-4">
                                <div class="input-group">
                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                    <input type="search" id="bookmarks-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
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
                @foreach ($bookmarks as $bookmark)
                    <div class="row pb-3">
                        <x-bookmarked-sp-list-item :bookmark="$bookmark"/>
                    </div>
                @endforeach
            </div>
        </div>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
