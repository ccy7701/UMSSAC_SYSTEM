<!-- resources/views/components/club-request-list-item.blade.php -->
<div class="rsans card club-request-list-item h-100 px-0" id="club-request-list-item-{{ $request->creation_request_id }}">
    <div class="row g-0 align-items-center">
        @php
            $clubImagePaths = json_decode($request->club_image_paths, true);
        @endphp
        <!-- Image section-->
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-xs-3 col-3" data-bs-toggle="collapse" data-bs-target="#actions-{{ $request->creation_request_id }}" aria-expanded="false" aria-controls="actions-{{ $request->creation_request_id }}">
            @if (empty($clubImagePaths))
                <img src="{{ asset('images/no_club_images_default.png') }}" class="img-fluid rounded-start border-end" alt="No club illustration default" style="aspect-ratio: 4/4; object-fit: cover; width: 100%; height: auto;">
            @else
                <img src="{{ Storage::url($clubImagePaths[0]) }}" class="img-fluid rounded-start border-end" alt="Club list item illustation" style="aspect-ratio: 4/4; object-fit: cover; width: 100%; height: auto;">
            @endif
        </div>
        <!-- Content section -->
        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9 col-xs-9 col-9 py-xl-5 py-lg-4 py-md-2 py-sm-3 py-2" data-bs-toggle="collapse" data-bs-target="#actions-{{ $request->creation_request_id }}" aria-expanded="false" aria-controls="actions-{{ $request->creation_request_id }}">
            <div class="rsans card-body px-3 py-0">
                <h5 class="card-title fw-bold my-0">
                    <span class="d-inline-block text-truncate" style="width: 100%;">
                        {{ $request->club_name }}
                    </span>
                </h5>
                <div class="card-text">
                    <!-- include club_category, created_at -->
                    <div class="row align-items-center">
                        <div class="col-1">
                            <i class="fa fa-university"></i>
                        </div>
                        <div class="col-10">
                            {{ $request->club_category }}
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-1">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="col-10">
                            {{ \Carbon\Carbon::parse($request->created_at)->format('Y-m-d h:i A') }}
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>
            </div>
        </div>
        @if ($request->request_status == 0)
            <!-- Collapsible actions sections -->
            <div id="actions-{{ $request->creation_request_id }}" class="request-section collapse">
                <hr class="divider-gray-300 mb-3 mt-0">
                <div class="container px-2 py-xl-2 py-lg-2 py-md-2 py-0">
                    <div class="row">
                        <div class="club-request-actions-row d-flex justify-content-center col-12 mb-3 px-0">
                            <a href="{{ route('club-creation.requests.review', ['creation_request_id' => $request->creation_request_id]) }}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-3 me-3">Review request</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
