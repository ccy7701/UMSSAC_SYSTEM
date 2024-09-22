<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All System Users</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    <x-admin-topnav/>
    <main class="flex-grow-1">
        <br>
        <div class="container p-3">

            <div class="d-flex align-items-center">
                
                <!-- TOP SECTION -->
                <div class="section-header row w-100">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">System users list</h3>
                        <p id="users-count-display" class="rserif fs-4 w-100 mt-0">
                            @if ($totalUsersCount == 0)
                                No users found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @elseif ($totalUsersCount == 1)
                                1 user found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @else
                                {{ $totalUsersCount }} users found{{ $search ? ' for search term "' . $search . '"' : '' }}
                            @endif
                        </p>
                        <!-- SEARCH TAB -->
                        <form class="d-flex justify-content-center" method="GET" action="{{ route('profile.all-system-users') }}">
                            <div class="mb-4 w-50">
                                <div class="input-group">
                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-search"></i></span>
                                    <input type="search" id="users-search" name="search" class="rsans form-control" aria-label="search" placeholder="Search..." value="{{ request()->input('search') }}">
                                    <button class="rsans btn btn-primary fw-bold">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    
            </div>
    
        </div>
    </main>
    <x-footer/>
</body>

</html>
