<!-- resources/views/components/manage-event-list-item.blade.php -->
<div class="card" id="list-item-manage">
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
                <img src="{{ Storage::url($eventImagePaths[0]) }}" class="img-fluid rounded-start border-end" alt="Event list item illustration" style="aspect-ratio: 4/4; object-fit: cover;">
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
                            {{ \Carbon\Carbon::parse($event->event_datetime)->format('Y-m-d h:i A') }}
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
    <!-- Hidden buttons for edit and view to be revealed on hover -->
    <div class="list-item-manage-overlay d-flex flex-row justify-content-center align-items-center">
        <div class="p-2 w-40">
            <a href="{{ route('events-finder.manage-details', [
                'event_id' => $event->event_id,
                'club_id' => $event->club->club_id,
            ]) }}" class="rsans btn btn-primary fw-semibold w-100">Manage event details</a>
        </div>
        <div class="p-2 w-40">
            <a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}" class="rsans btn btn-secondary fw-semibold w-100">View event details</a>
        </div>
    </div>
</div>