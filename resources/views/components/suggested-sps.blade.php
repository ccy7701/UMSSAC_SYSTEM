<!-- resources/views/components/suggested-sps.blade.php -->
@foreach ($data as $index => $suggestion)
    <div class="row pb-3">
        <div class="rsans card suggested-sp-list-item h-100" id="suggested-sp-list-item-{{ $index }}">
            <!-- CARD HEADER -->
            <div class="row g-0 align-items-center pb-2 pt-md-2 pt-3">
                <div class="col-md-2 text-center">
                    <img id="user-profile" src="{{ $suggestion['profile']['profile_picture_filepath'] }}" alt="User profile" class="sp-circle rounded-circle">
                </div>
                <div class="col-md-7 text-start justify-content-center align-items-center">
                    <div class="card-body">
                        <span class="d-inline-flex align-items-center">
                            <p class="card-title fw-bold fs-5 mb-0 me-1">{{ $suggestion['profile']['account']['account_full_name'] }}</p>
                            <p class="fst-italic text-muted mb-0 ms-1">({{ $suggestion['profile']['profile_nickname'] }})</p>
                            <form class="d-inline-flex" method="POST" action="{{ route('study-partners-suggester.bookmarks.toggle') }}">
                                @csrf
                                <input type="hidden" name="study_partner_profile_id" value="{{ $suggestion['profile']['profile_id'] }}">
                                <input type="hidden" name="operation_page_source" value="results">
                                @switch ($suggestion['connectionType'])
                                    @case (0)
                                        <button type="submit" class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none">
                                            &emsp;<i class="fa-regular fa-bookmark text-primary fs-3"></i>
                                        </button>
                                    @break
                                    @case (1)
                                        <button type="submit" class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none">
                                            &emsp;<i class="fa-solid fa-bookmark text-primary fs-3"></i>
                                        </button>
                                    @break
                                    @case (2)
                                        <button class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none" disabled>
                                            &emsp;<i class="fa fa-user-plus text-primary fs-5"></i>
                                            <p class="text-primary ms-2 mb-0 align-middle">Added</p>
                                        </button>
                                    @break
                                @endswitch
                            </form>
                        </span>
                        <div class="row align-self-center text-muted">
                            <div class="col-1 text-center"><i class="fa fa-university"></i></div>
                            <div class="col-11">{{ $suggestion['profile']['profile_faculty'] }}</div>
                        </div>
                        <div class="row align-items-center text-muted">
                            <div class="col-1 text-center"><i class="fa fa-id-badge"></i></div>
                            <div class="col-11">{{ $suggestion['profile']['account']['account_matric_number'] }}</div>
                        </div>
                        <div class="row align-items-center text-muted">
                            <div class="col-1 text-center"><i class="fa fa-envelope"></i></div>
                            <div class="col-11">{{ $suggestion['profile']['account']['account_email_address'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    @php
                        $similarity = $suggestion['similarity'];
                        
                        // Define colors in RGB format
                        $minColor = [192, 210, 224];        #C0D2E0 (approaching -1.00)
                        $maxColor = [40, 167, 69];          #28A745 (approaching 1.00)
                        
                        // Calculate interpolation factor between 0 and 1
                        $factor = ($similarity + 1) / 2;    // Maps -1 to 0 and 1 to 1
                        
                        // Interpolate each color channel
                        $r = (int) ($minColor[0] + ($maxColor[0] - $minColor[0]) * $factor);
                        $g = (int) ($minColor[1] + ($maxColor[1] - $minColor[1]) * $factor);
                        $b = (int) ($minColor[2] + ($maxColor[2] - $minColor[2]) * $factor);
                        
                        // Combine into a hex color
                        $color = sprintf("#%02x%02x%02x", $r, $g, $b);
                    @endphp
                    <h4 style="color: {{ $color }}">Similarity</h4>
                    <h1 class="mb-0" style="color: {{ $color }}">{{ number_format($suggestion['similarity'], 2) }}</h1>
                </div>
                <div class="col-md-1 text-center">
                    <button class="btn btn-muted toggle-details" data-bs-toggle="collapse" data-bs-target="#details-{{ $index }}">
                        <i class="fa fa-chevron-down chevron-icon fs-1" id="suggested-sp-chevron"></i>
                    </button>
                </div>
            </div>
            <!-- CARD BODY -->
            <div id="details-{{ $index }}" class="collapse">
                <hr class="divider-gray-300 mb-4 mt-2">
                <div class="container px-2">
                    <div class="row">
                        <div class="suggester-actions-row d-flex justify-content-center col-12 mb-4 px-0">
                            <form class="w-100 d-flex justify-content-center" method="POST" action="{{ route('study-partners-suggester.add-to-list') }}">
                                @csrf
                                <input type="hidden" name="operation_page_source" value="results">
                                <input type="hidden" name="study_partner_profile_id" value="{{ $suggestion['profile']['profile_id'] }}">
                                @if ($suggestion['connectionType'] == 2)
                                    <a href="{{ route('view-user-profile', ['profile_id' => $suggestion['profile']['profile_id']]) }}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-3">View profile</a>
                                @else
                                    <a href="{{ route('view-user-profile', ['profile_id' => $suggestion['profile']['profile_id']]) }}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-3 me-2">View profile</a>
                                    <button type="submit" class="section-button-extrashort rsans btn btn-primary fw-semibold px-3 ms-2">Add to my list</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
