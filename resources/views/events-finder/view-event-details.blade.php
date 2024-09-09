<!DOCTYPE HTML>
<html lang="en" xml:lang="en">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->event_name }} | Events Finder</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    <x-topnav/>
    <br>

    <div class="container p-3">
        Event id = {{ $event->event_id }}<br>
        Club id = {{ $event->club_id }}<br>
        Event name = {{ $event->event_name }}<br>
        Event datetime = {{ $event->event_datetime }}<br>
        Event description = {{ $event->event_description }}<br>
        Event entrance fee = RM{{ number_format($event->event_entrance_fee, 2) }}<br>
        Event SDP provided = {{ $event->event_sdp_provided }}<br>
        Image =
        @php
            $eventImagePaths = json_decode($event->event_image_paths, true);
        @endphp
        <img src="{{ asset($eventImagePaths[0]) }}" class="card-img-top w-50" alt="Event illustration"><br>
        Event registration link = {{ $event->event_registration_link }}<br>
        Event status = {{ $event->event_status }}<br>
        CREATED AT = {{ $event->created_at }}<br>
        UPDATED AT = {{ $event->updated_at }}<br>
    </div>

    <x-footer/>
</body>

</html>
