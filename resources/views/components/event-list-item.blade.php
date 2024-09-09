<!-- resources/views/components/event-list-item.blade.php -->
<a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}" class="text-decoration-none">
    <div class="card" id="list-item-standard">
        <div class="row g-0 align-items-center">
            @php
                $eventImagePaths = json_decode($event->event_image_paths, true);
            @endphp
            <!-- Image section -->
            <div class="col-md-4">
                <img src="{{ asset($eventImagePaths[0]) }}" class="img-fluid rounded-start border-end" alt="Event list item illustration" style="aspect-ratio: 16/10;">
            </div>
            <!-- Content section -->
            <div class="col-md-8">
                <div class="rsans card-body p-3">
                    <h5 class="card-title fw-bold">{{ $event->event_name }}</h5>
                    <div class="card-text">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="col-10">
                                DB-COL-!confirmed
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-1">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="col-10">
                                {{ $event->event_datetime }}
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-1">
                                <i class="fa fa-university"></i>
                            </div>
                            <div class="col-10">
                                DB-COL-!finalised
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
