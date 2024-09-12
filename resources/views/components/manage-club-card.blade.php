<!-- resources/views/components/manage-club-card.blade.php -->
<div class="card" id="card-manage">
    @php
        $clubImagePaths = json_decode($club->club_image_paths, true);
    @endphp
    <div id="card-image">
        <img src="{{ asset($clubImagePaths[0]) }}" class="card-img-top border-bottom" alt="Event card illustration" style="aspect-ratio: 4/4;">
    </div>
    <div class="rsans card-body p-3">
        <h5 class="card-title fw-bold">{{ $club->club_name }}</h5>
        <div class="card-text">
            <div class="row align-items-center">
                <div class="col-1">
                    <i class="fa fa-university"></i>
                </div>
                <div class="col-10">
                    {{ $club->club_faculty }}
                </div>
                <div class="col-1"></div>
            </div>
        </div>
    </div>
    <!-- Hidden buttons for edit and view to be revealed on hover -->
    <div class="card-manage-overlay d-flex flex-column justify-content-center align-items-center">
        <div class="py-2 w-60">
            <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="btn btn-primary fw-semibold w-100">Edit club details</a>
        </div>
        <div class="py-2 w-60">
            <a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}" class="btn btn-secondary fw-semibold w-100">View club details</a>
        </div>
    </div>
</div>
