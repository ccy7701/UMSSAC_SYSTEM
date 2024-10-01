<!-- resources/views/components/manage-club-list-item.blade.php -->
<div class="px-3">
    <div class="card" id="club-list-item-manage">
        <div class="row g-0 align-items-center">
            @php
                $clubImagePaths = json_decode($club->club_image_paths, true);
            @endphp
            <!-- Image section -->
            <div class="col-md-2 col-3">
                @if (empty($clubImagePaths))
                    <img src="{{ asset('images/no_club_images_default.png') }}" class="img-fluid rounded-start border-end" alt="No club illustration default" style="aspect-ratio: 4/4; object-fit: cover; width: 100%; height: auto;">
                @else
                    <img src="{{ Storage::url($clubImagePaths[0]) }}" class="img-fluid rounded-start border-end" alt="Club list item illustration" style="aspect-ratio: 4/4; object-fit: cover; width: 100%; height: auto;">
                @endif
            </div>
            <!-- Content section -->
            <div class="col-md-10 col-9">
                <div class="rsans card-body py-1 px-3">
                    <h5 class="card-title fw-bold">
                        <span class="d-inline-block text-truncate" style="width: 100%;">
                            {{ $club->club_name }}
                        </span>
                    </h5>
                    <div class="card-text">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <i class="fa fa-university"></i>
                            </div>
                            <div class="col-10">
                                {{ $club->club_category }}
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Hidden buttons for edit and view to be revealed on hover -->
            <div class="overlay d-flex flex-row justify-content-center align-items-center">
                <div class="overlay-btn p-2">
                    <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-primary fw-semibold">Manage club details</a>
                </div>
                <div class="overlay-btn p-2">
                    <a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-secondary fw-semibold">View club details</a>
                </div>
            </div>
        </div>
    </div>
</div>
