<!-- resources/views/components/manage-club-list-item.blade.php -->
<div class="card" id="list-item-manage">
    <div class="row g-0 align-items-center">
        @php
            $clubImagePaths = json_decode($club->club_image_paths, true);
        @endphp
        <!-- Image section -->
        <div class="col-md-2">
            <img src="{{ asset($clubImagePaths[0]) }}" class="img-fluid rounded-start border-end" alt="Club list item illustration" style="aspect-ratio: 4/4;">
        </div>
        <!-- Content section -->
        <div class="col-md-10">
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
        </div>
    </div>
    <!-- Hidden buttons for edit and view to be revealed on hover -->
    <div class="list-item-manage-overlay d-flex flex-row justify-content-center align-items-center">
        <div class="p-2 w-40">
            <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="btn btn-primary fw-semibold w-100">Manage club details</a>
        </div>
        <div class="p-2 w-40">
            <a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}" class="btn btn-secondary fw-semibold w-100">View club details</a>
        </div>
    </div>
</div>
