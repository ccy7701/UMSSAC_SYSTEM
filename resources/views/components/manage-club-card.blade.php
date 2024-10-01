<!-- resources/views/components/manage-club-card.blade.php -->
<div class="card h-100" id="club-card-manage">
    @php
        $clubImagePaths = json_decode($club->club_image_paths, true);
    @endphp
    <div id="card-image">
        @if (empty($clubImagePaths))
            <img src="{{ asset('images/no_club_images_default.png') }}" class="card-img-top border-bottom" alt="No club illustration default" style="aspect-ratio: 4/4;">
        @else
            <img src="{{ Storage::url($clubImagePaths[0]) }}" class="card-img-top border-bottom" alt="Event card illustration" style="aspect-ratio: 4/4;">
        @endif
    </div>
    <div class="rsans card-body p-3">
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
    <!-- Hidden buttons for edit and view to be revealed on hover -->
    <div class="overlay d-flex flex-column justify-content-center align-items-center">
        <div class="py-2 w-75">
            <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-primary fw-semibold w-100">Manage club details</a>
        </div>
        <div class="py-2 w-75">
            <a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-secondary fw-semibold w-100">View club details</a>
        </div>
    </div>
</div>
