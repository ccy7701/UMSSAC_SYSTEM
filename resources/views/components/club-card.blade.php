<!-- resources/views/components/club-card.blade.php -->
<a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}" class="text-decoration-none">
    <div class="card" id="card-standard">
        @php
            $clubImagePaths = json_decode($club->club_image_paths, true);
        @endphp
        <img src="{{ asset($clubImagePaths[0]) }}" class="card-img-top border-bottom" alt="Event card illustration" style="aspect-ratio: 4/4;">
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
</a>
