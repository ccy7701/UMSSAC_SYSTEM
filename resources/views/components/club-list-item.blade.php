<!-- resources/views/components/club-list-item.blade.php -->
<a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}" class="text-decoration-none">
    <div class="card" id="list-item-standard">
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
    </div>
</a>
