<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    <div class="container">
        @if(Auth::check())
            <h1>Welcome, {{ Auth::user()->accountFullName }}!</h1>
            <p>Your email: {{ Auth::user()->accountEmailAddress }}</p>
            <p>Your role: 
                @switch(Auth::user()->accountRole)
                    @case(1)
                        Student
                        @break
                    @case(2)
                        Faculty Member
                        @break
                    @case(3)
                        Admin
                        @break
                @endswitch
            </p>
            <form method="POST" action="{{ route('account.logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @else
            <h1>You are not logged in.</h1>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        @endif
    </div>

    @vite('resources/js/app.js')
</body>

</html>