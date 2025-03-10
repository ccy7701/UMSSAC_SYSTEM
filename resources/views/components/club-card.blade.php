<!-- resources/views/components/club-card.blade.php -->
@php
    $route = currentAccount()->account_role != 3
        ? 'clubs-finder.fetch-club-details'
        : 'manage-clubs.fetch-club-details';
@endphp
<a href="{{ route($route, ['club_id' => $club->club_id]) }}" class="text-decoration-none">
    <div class="card h-100" id="club-card-standard">
        @php
            $clubImagePaths = json_decode($club->club_image_paths, true);
        @endphp
        @if (empty($clubImagePaths))
            <img src="{{ asset('images/no_club_images_default.png') }}" class="card-img-top border-bottom" alt="No club illustration default" style="aspect-ratio: 4/4;">
        @else
            <img src="{{ Storage::url($clubImagePaths[0]) }}" class="card-img-top border-bottom" alt="Club card illustration" style="aspect-ratio: 4/4;">
        @endif
        <div class="rsans card-body px-3 px-xl-3 px-lg-3 px-sm-3 px-xs-2 py-3">
            <h5 class="card-title fw-bold mb-xs-0">
                <span class="d-inline-block text-truncate" style="width: 100%">
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
</a>
