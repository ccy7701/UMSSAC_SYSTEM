<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Club</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    <x-topnav/>
    <br>
    <div class="container p-3">
        <!--
            In this form include
                1. CLUB INFO
                    1.1 Club name
                    1.2 Category
                    1.3 Description
                2. CLUB IMAGES
            When done modify existing pages to show if there are no events for that club yet
        -->
    </div>
    <x-footer/>
    {{ dd("Hello there") }}
</body>

</html>
