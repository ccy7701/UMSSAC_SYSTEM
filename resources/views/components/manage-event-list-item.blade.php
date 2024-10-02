<!-- resources/views/components/manage-event-list-item.blade.php -->
<div class="px-3">
    <div class="card" id="event-list-item-manage">
        <div class="row g-0 align-items-center">
            @php
                $eventImagePaths = json_decode($event->event_image_paths, true);
            @endphp
            <!-- Image section -->
            <div class="col-xl-2 col-lg-3 col-md-3 col-4">
                @if (empty($eventImagePaths))
                    <img src="{{ asset('images/no_event_images_default.png') }}" class="img-fluid rounded-start border-end" alt="No event illustration default" style="aspect-ratio: 4/4; object-fit: cover; width: 100%; height: auto;">
                @else
                    <img src="{{ Storage::url($eventImagePaths[0]) }}" class="img-fluid rounded-start border-end" alt="Event list item illustration" style="aspect-ratio: 4/4; object-fit: cover; width: 100%; height: auto;">
                @endif
            </div>
            <!-- Content section -->
            <div class="col-xl-10 col-lg-9 col-md-9 col-8">
                <div class="rsans card-body py-0 px-3">
                    <h5 class="card-title fw-bold mb-0">
                        <span class="d-inline-block text-truncate" style="width: 100%;">
                            {{ $event->event_name }}
                        </span>
                    </h5>
                    <div class="card-text">
                        <div class="row align-items-center">
                            <div class="col-1 text-center">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="col-10 text-truncate">
                                {{ $event->event_location }}
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-1 text-center">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="col-10">
                                {{ \Carbon\Carbon::parse($event->event_datetime)->format('Y-m-d h:i A') }}
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-1 text-center">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="col-10 text-truncate">
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
        <!-- Hidden buttons for edit and view to be revealed on hover -->
        <div class="overlay d-flex flex-row justify-content-center align-items-center">
            <div class="overlay-btn p-2 w-40">
                <a href="{{ route('events-finder.manage-details', [
                    'event_id' => $event->event_id,
                    'club_id' => $event->club->club_id,
                ]) }}" class="rsans btn btn-primary fw-semibold w-100">Manage event details</a>
            </div>
            <div class="overlay-btn p-2 w-40">
                <a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}" class="rsans btn btn-secondary fw-semibold w-100">View event details</a>
            </div>
        </div>
    </div>
</div>
