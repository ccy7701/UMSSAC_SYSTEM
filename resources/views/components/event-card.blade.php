<!-- resources/views/components/event-card.blade.php -->
<a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}" class="text-decoration-none">
    <div class="card h-100" id="event-card-standard">
        @php
            $eventImagePaths = json_decode($event->event_image_paths, true);
        @endphp
        @if (empty($eventImagePaths))
            <img src="{{ asset('images/no_event_images_default.png') }}" alt="No event illustration default" style="aspect-ratio: 4/4;">
        @else
            <img src="{{ Storage::url($eventImagePaths[0]) }}" class="card-img-top border-bottom" alt="Event card illustration" style="aspect-ratio: 4/4;">
        @endif
        @if (in_array($event->event_id, $intersectionarray))
            <div class="bookmark position-absolute top-0 end-0 p-2">
                <span class="bookmark-span rounded-circle d-inline-flex justify-content-center align-items-center">
                    <i class="fa fa-bookmark text-primary fs-4"></i>
                </span>
            </div>
        @endif
        <div class="rsans card-body p-3">
            <h5 class="card-title fw-bold">
                <span class="d-inline-block text-truncate" style="width: 100%;">
                    {{ $event->event_name }}
                </span>
            </h5>
            <div class="card-text">
                <div class="row align-items-center">
                    <div class="col-2 text-center">
                        <i class="fa fa-map-marker-alt"></i>
                    </div>
                    <div class="col-10 text-truncate">
                        {{ $event->event_location }}
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-2 text-center">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="col-10 text-truncate">
                        {{ \Carbon\Carbon::parse($event->event_datetime)->format('Y-m-d h:i A') }}
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-2 text-center">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="col-10 text-truncate">
                        {{ $event->club->club_name }}
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-2 text-center">
                        <i class="fa fa-university"></i>
                    </div>
                    <div class="col-10 text-truncate">
                        {{ $event->club->club_category }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
