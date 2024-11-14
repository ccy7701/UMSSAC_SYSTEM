<!-- resources/views/components/bookmarked-sps-compact.blade.php -->
@foreach ($bookmarks as $index => $bookmark)
    <div class="row pb-3">
        <div class="rsans card px-2 bookmarked-sp-list-item h-100" id="bookmarked-sp-list-item-{{ $index }}">
            <!-- CARD HEADER -->
            <div class="row g-0 align-items-center py-2" data-bs-toggle="collapse" data-bs-target="#details-compact-{{ $index }}" aria-expanded="false" aria-controls="details-collapse-{{ $index }}">
                <div class="col-3 text-center align-items-center">
                    <img id="user-profile" src="{{ $bookmark->studyPartnerProfile->profile_picture }}" alt="User profile" class="sp-circle rounded-circle">
                </div>
                <div class="col-9 text-start ps-1 pe-1">
                    <div class="row px-0 mx-0 mt-1">
                        <div class="col-9 d-flex align-items-center px-0">
                            <h5 class="card-title fw-bold mb-0 w-100 text-truncate">{{ $bookmark->studyPartnerProfile->account->account_full_name }}</h5>
                        </div>
                        <div class="col-3 d-flex align-items-center justify-content-end px-0">
                            <form method="POST" action="{{ route('study-partners-suggester.bookmarks.toggle') }}">
                                @csrf
                                <input type="hidden" name="study_partner_profile_id" value="{{ $bookmark->study_partner_profile_id }}">
                                <input type="hidden" name="operation_page_source" value="bookmarks">
                                <button type="submit" class="bookmark-inline d-flex justify-content-end align-items-center bg-transparent border-0 p-0 text-decoration-none">
                                    <i class="fa-solid fa-bookmark text-primary"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="fst-italic text-muted py-0 my-1">
                        ({{ $bookmark->studyPartnerProfile->profile_nickname != '' ? $bookmark->studyPartnerProfile->profile_nickname : 'No nickname' }})
                    </p>
                    <div class="row d-flex align-items-center text-muted px-0 mx-0">
                        <div class="col-1 px-0"><i class="fa fa-university"></i></div>
                        <div class="col-11 px-0">{{ $bookmark->studyPartnerProfile->profile_faculty }}</div>
                    </div>
                    <div class="row d-flex align-items-center text-muted px-0 mx-0">
                        <div class="col-1 px-0"><i class="fa fa-id-badge"></i></div>
                        <div class="col-11 px-0">{{ $bookmark->studyPartnerProfile->account->account_matric_number }}</div>
                    </div>
                    <div class="row d-flex align-items-center text-muted p-0 m-0">
                        <div class="col-1 px-0"><i class="fa fa-envelope"></i></div>
                        <div class="col-11 px-0 text-truncate">{{ $bookmark->studyPartnerProfile->account->account_email_address }}</div>
                    </div>
                </div>
            </div>
            <!-- CARD BODY -->
            <div id="details-compact-{{ $index }}" class="collapse" style="cursor: default;">
                <hr class="divider-gray-300 mb-3 mt-0">
                <div class="container px-2">
                    <div class="row">
                        <div class="bookmark-actions-row d-flex justify-content-center col-12 mb-3 px-0">
                            <form class="w-100 d-flex justify-content-center" method="POST" action="{{ route('study-partners-suggester.add-to-list') }}">
                                @csrf
                                <input type="hidden" name="operation_page_source" value="bookmarks">
                                <input type="hidden" name="study_partner_profile_id" value="{{ $bookmark->study_partner_profile_id }}">
                                <a href="{{ route('view-user-profile', ['profile_id' => $bookmark->study_partner_profile_id]) }}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-3 me-2">View profile</a>
                                <button type="submit" class="section-button-extrashort rsans btn btn-primary fw-semibold px-3 ms-2">Add to my list</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
