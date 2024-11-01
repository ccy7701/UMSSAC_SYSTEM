<!-- resources/views/components/bookmarked-sp-list-item.blade.php -->
<div class="rsans card bookmarked-sp-list-item h-100" id="bookmarked-sp-list-item-{{ $bookmark->study_partner_profile_id }}">
    <div class="row g-0 align-items-center pb-2 pt-md-2 pt-3">
        <div class="col-md-2 text-center">
            <img id="user-profile" src="{{ $bookmark->studyPartnerProfile->profile_picture }}" alt="User profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
        </div>
        <div class="col-md-7 text-start justify-content-center align-items-center">
            <div class="card-body">
                <span class="d-inline-flex align-items-center">
                    <p class="card-title fw-bold fs-5 mb-0 me-1">
                        {{ $bookmark->studyPartnerProfile->account->account_full_name }}
                    </p>
                    <p class="fst-italic text-muted mb-0 ms-1">
                        ({{ $bookmark->studyPartnerProfile->profile_nickname != '' ? $bookmark->studyPartnerProfile->profile_nickname : 'No nickname' }})
                    </p>
                    <form class="d-inline-flex" method="POST" action="{{ route('study-partners-suggester.bookmarks.toggle') }}">
                        @csrf
                        <input type="hidden" name="study_partner_profile_id" value="{{ $bookmark->study_partner_profile_id }}">
                        <input type="hidden" name="operation_page_source" value="bookmarks">
                        <button type="submit" class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none">
                            &emsp;<i class="fa-solid fa-bookmark text-primary fs-3"></i>
                        </button>
                    </form>
                </span>
                <div class="row align-self-center text-muted">
                    <div class="col-1 text-center"><i class="fa fa-university"></i></div>
                    <div class="col-11">{{ $bookmark->studyPartnerProfile->profile_faculty }}</div>
                </div>
                <div class="row align-items-center text-muted">
                    <div class="col-1 text-center"><i class="fa fa-id-badge"></i></div>
                    <div class="col-11">{{ $bookmark->studyPartnerProfile->account->account_matric_number }}</div>
                </div>
                <div class="row align-items-center text-muted">
                    <div class="col-1 text-center"><i class="fa fa-envelope"></i></div>
                    <div class="col-11">{{ $bookmark->studyPartnerProfile->account->account_email_address }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-1 text-center">
            <button class="btn btn-muted toggle-details" data-bs-toggle="collapse" data-bs-target="#details-{{ $bookmark->study_partner_profile_id }}">
                <i class="fa fa-chevron-down fs-1 chevron-icon"></i>
            </button>
        </div>
        <div id="details-{{ $bookmark->study_partner_profile_id }}" class="collapse">
            <hr class="divider-gray-300 mb-4 mt-2">
            <div class="container px-2">
                <div class="row">
                    <div class="bookmarks-actions-row d-flex justify-content-center col-12 mb-3 px-0">
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
