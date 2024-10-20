<!-- resources/views/components/event-list-item.blade.php -->
<a href="{{ route('events-finder.fetch-event-details', ['event_id' => $event->event_id]) }}" class="text-decoration-none">
    <div class="card" id="event-list-item-standard">
        <div class="row g-0 align-items-center">
            @php
                $eventImagePaths = json_decode($event->event_image_paths, true);
            @endphp
            <!-- Image section -->
            <div class="col-xl-3 col-lg-3 col-md-3 col-4 position-relative">
                @if (empty($eventImagePaths))
                    <img src="{{ asset('images/no_event_images_default.png') }}" class="img-fluid rounded-start border-end" alt="No event illustration default" style="aspect-ratio: 4/4; object-fit: cover; width: 100%; height: auto;">
                @else
                    <img src="{{ Storage::url($eventImagePaths[0]) }}" class="img-fluid rounded-start border-end" alt="Event list item illustration" style="aspect-ratio: 4/4; object-fit: cover; width: 100%; height: auto;">
                @endif
                @if (in_array($event->event_id, $intersectionarray))
                    <div class="bookmark position-absolute top-0 end-0 p-2">
                        <span class="bookmark-span rounded-circle d-inline-flex justify-content-center align-items-center">
                            <i class="fa fa-bookmark text-primary fs-4"></i>
                        </span>
                    </div>
                @endif
            </div>
            <!-- Content section -->
            <div class="col-xl-9 col-lg-9 col-md-9 col-8">
                <div class="rsans card-body py-0 px-3">
                    <h5 class="card-title fw-bold mb-0">
                        <span class="d-inline-block text-truncate" style="width: 100%;">
                            {{ $event->event_name }}
                        </span>
                    </h5>
                    <div class="card-text">
                        <div class="row align-items-center">
                                <div class="col-1 text-center">
                                    <i class="fa fa-map-marker-alt"></i>
                                </div>
                                <div class="col-10 text-truncate">
                                    {{ $event->event_location }}
                                </div>
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
    </div>
</a>
