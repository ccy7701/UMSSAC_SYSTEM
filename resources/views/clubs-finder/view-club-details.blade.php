<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $club->club_name }} | Clubs Finder</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    <x-topnav/>
    <br>

    <div class="container p-3">
        Club id = {{ $club->club_id }}<br>
        Club name = {{ $club->club_name }}<br>
        Club faculty = {{ $club->club_faculty }}<br>
        Club description = {{ $club->description }}<br>
        Image = 
        <img src="{{ asset($club->club_logo_filepath) }}" class="card-img-top w-50" alt="Club illustration"><br>
        CREATED AT = {{ $club->created_at }}<br>
        UPDATED AT = {{ $club->updated_at }}<br>
    </div>

    <x-footer/>
</body>

</html>