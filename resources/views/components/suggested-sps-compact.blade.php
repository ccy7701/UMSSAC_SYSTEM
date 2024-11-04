<!-- resources/views/components/suggested-sps-compact.blade.php -->
@foreach ($data as $index => $suggestion)
    <div class="row pb-3">
        <div class="rsans card px-2 suggested-sp-list-item h-100" id="suggested-sp-list-item-{{ $index }}">
            <!-- CARD HEADER -->
            <div class="row g-0 align-items-center py-2" data-bs-toggle="collapse" data-bs-target="#details-compact-{{ $index }}" aria-expanded="false" aria-controls="details-collapse-{{ $index }}">
                <div class="col-3 text-center align-items-center ps-0">
                    <img id="user-profile" src="{{ $suggestion['profile']['profile_picture_filepath'] }}" alt="User profile" class="sp-circle rounded-circle">
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
                    <p class="fw-semibold mt-2 mb-0" style="color: {{ $color }}">
                        Similarity<br>{{ number_format($suggestion['similarity'], 2) }}
                    </p>
                </div>
                <div class="col-9 text-start ps-1 pe-1">
                    <div class="row px-0 mx-0 mt-1">
                        <div class="col-9 d-flex align-items-center px-0">
                            <h5 class="card-title fw-bold mb-0 w-100 text-truncate">{{ $suggestion['profile']['account']['account_full_name'] }}</h5>
                        </div>
                        <div class="col-3 d-flex align-items-center justify-content-end px-0">
                            <form method="POST" action="{{ route('study-partners-suggester.bookmarks.toggle') }}">
                                @csrf
                                <input type="hidden" name="study_partner_profile_id" value="{{ $suggestion['profile']['profile_id'] }}">
                                <input type="hidden" name="operation_page_source" value="results">
                                @switch ($suggestion['connectionType'])
                                    @case (0)
                                        <button type="submit" class="bookmark-inline d-flex justify-content-end align-items-center bg-transparent border-0 p-0 text-decoration-none">
                                            <i class="fa-regular fa-bookmark text-primary me-1"></i>
                                        </button>
                                    @break
                                    @case (1)
                                        <button type="submit" class="bookmark-inline d-flex justify-content-end align-items-center bg-transparent border-0 p-0 text-decoration-none">
                                            <i class="fa-solid fa-bookmark text-primary me-1"></i>
                                        </button>
                                    @break
                                    @case (2)
                                        <button class="bookmark-inline d-flex justify-content-end align-items-center bg-transparent border-0 p-0 text-decoration-none" disabled>
                                            <i class="fa fa-user-plus text-primary me-0"></i>
                                        </button>
                                    @break
                                @endswitch
                            </form>
                        </div>
                    </div>
                    <p class="fst-italic text-muted py-0 my-1">({{ $suggestion['profile']['profile_nickname'] }})</p>
                    <div class="row d-flex align-items-center text-muted px-0 mx-0">
                        <div class="col-1 px-0"><i class="fa fa-university"></i></div>
                        <div class="col-11 px-0">{{ $suggestion['profile']['profile_faculty'] }}</div>
                    </div>
                    <div class="row d-flex align-items-center text-muted px-0 mx-0">
                        <div class="col-1 px-0"><i class="fa fa-id-badge"></i></div>
                        <div class="col-11 px-0">{{ $suggestion['profile']['account']['account_matric_number'] }}</div>
                    </div>
                    <div class="row d-flex align-items-center text-muted p-0 m-0">
                        <div class="col-1 px-0"><i class="fa fa-envelope"></i></div>
                        <div class="col-11 px-0 text-truncate">{{ $suggestion['profile']['account']['account_email_address'] }}</div>
                    </div>
                </div>
            </div>
            <!-- CARD BODY -->
            <div id="details-compact-{{ $index }}" class="collapse">
                <hr class="divider-gray-300 mb-3 mt-0">
                <div class="container px-2">
                    <div class="row">
                        <div class="suggester-actions-row d-flex justify-content-center col-12 mb-3 px-0">
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
