<!-- resources/views/components/event-list-item.blade.php -->
<a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}" class="text-decoration-none">
    <div class="card" id="list-item-standard">
        <div class="row g-0 align-items-center">
            @php
                $eventImagePaths = json_decode($event->event_image_paths, true);
            @endphp
            @if (empty($eventImagePaths))
                <div class="col-md-2">
                    <img src="{{ asset('images/no_event_images_default.png') }}" class="img-fluid rounded-start border-end" alt="No event illustration default" style="aspect-ratio: 4/4;">
                </div>
            @else
                <div class="col-md-2">
                    <img src="{{ asset($eventImagePaths[0]) }}" class="img-fluid rounded-start border-end" alt="Event list item illustration" style="aspect-ratio: 4/4; object-fit: cover;">
                </div>
            @endif
            <!-- Content section -->
            <div class="col-md-10">
                <div class="rsans card-body px-3 py-2">
                    <h5 class="card-title fw-bold">{{ $event->event_name }}</h5>
                    <div class="card-text">
                        <div class="row align-items-center">
                            <div class="col-1 text-center">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="col-10">
                                {{ $event->event_location }}
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-1 text-center">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="col-10">
                                {{ $event->event_datetime }}
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-1 text-center">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="col-10">
                                {{ $event->club->club_name }}
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-1 text-center">
                                <i class="fa fa-university"></i>
                            </div>
                            <div class="col-10">
                                {{ $event->club->club_category }}
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
