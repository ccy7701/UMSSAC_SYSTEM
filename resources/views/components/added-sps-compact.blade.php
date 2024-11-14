<!-- resources/views/components/added-sp-compact-blade.php -->
@foreach ($addedstudypartners as $record)
    @php
        // Evaluate the type of profile data to be used;
        // 1 - those who the user has added, 2 - those who have added the user
        $profile = ($type == 1) ? $record->studyPartnerProfile : $record->profile;
    @endphp
    <div class="row pb-3">
        <div class="rsans card px-2 added-sp-list-item h-100" id="added-sp-list-item-{{ $record->profile_id }}-{{ $record->study_partner_profile_id }}">
            <!-- CARD HEADER -->
            <div class="row g-0 align-items-center py-2"
                data-bs-toggle="collapse"
                data-bs-target="#details-compact-{{ $record->profile_id }}-{{ $record->study_partner_profile_id }}" aria-expanded="false"
                aria-controls="details-collapse-{{ $record->profile_id }}-{{ $record->study_partner_profile_id }}"
            >
                <div class="col-3 text-center align-items-center">
                    <img id="user-profile" src="{{ $profile->profile_picture }}" alt="User profile" class="sp-circle rounded-circle">
                </div>
                <div class="col-9 text-start ps-1 pe-1">
                    <div class="row px-0 mx-0 mt-1">
                        <div class="col-9 d-flex align-items-center px-0">
                            <h5 class="card-title fw-bold mb-0 w-100 text-truncate">{{ $profile->account->account_full_name }}</h5>
                        </div>
                        <div class="col-3 d-flex align-items-center justify-content-end px-0">
                            @if ($type == 2 && in_array($profile->profile_id, $intersectionarray))
                                <button class="bookmark-inline d-flex justify-content-end align-items-center bg-transparent border-0 p-0 text-decoration-none" disabled>
                                    <i class="fa fa-user-plus text-primary"></i>
                                </button>
                            @endif
                        </div>
                        <p class="fst-italic text-muted px-0 py-0 my-1 ">
                            ({{ $profile->profile_nickname != '' ? $profile->profile_nickname : 'No nickname' }})
                        </p>
                        <div class="row d-flex align-items-center text-muted px-0 mx-0">
                            <div class="col-1 px-0"><i class="fa fa-university"></i></div>
                            <div class="col-11 px-0">{{ $profile->profile_faculty }}</div>
                        </div>
                        <div class="row d-flex align-items-center text-muted px-0 mx-0">
                            <div class="col-1 px-0"><i class="fa fa-id-badge"></i></div>
                            <div class="col-11 px-0">{{ $profile->account->account_matric_number }}</div>
                        </div>
                        <div class="row d-flex align-items-center text-muted p-0 m-0">
                            <div class="col-1 px-0"><i class="fa fa-id-badge"></i></div>
                            <div class="col-11 px-0 text-truncate">{{ $profile->account->account_email_address }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CARD BODY -->
            @if ($type == 1)
                <div id="details-compact-{{ $record->profile_id }}-{{ $record->study_partner_profile_id }}" class="collapse" style="cursor: default;">
                    <hr class="divider-gray-300 mb-3 mt-0">
                    <div class="container px-2">
                        <div class="row">
                            <div class="added-sps-actions-row d-flex justify-content-center col-12 mb-3 px-0">
                                <a href="{{ route('view-user-profile', ['profile_id' => $record->study_partner_profile_id]) }}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-2 me-2">View profile</a>
                                <button type="button" class="section-button-extrashort rsans btn btn-danger fw-semibold px-2 ms-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#delete-sp-confirmation-modal"
                                    data-study-partner-name="{{ $profile->account->account_full_name }}"
                                    data-study-partner-profile-id="{{ $profile->profile_id }}">
                                    Remove from list
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($type == 2 && !in_array($profile->profile_id, $intersectionarray))
                <div id="details-compact-{{ $record->profile_id }}-{{ $record->study_partner_profile_id }}" class="collapse" style="cursor: default;">
                    <hr class="divider-gray-300 mb-3 mt-0">
                    <div class="container px-2">
                        <div class="row">
                            <div class="added-sps-actions-row d-flex justify-content-center col-12 mb-3 px-0">
                                <form id="add-to-list-form" method="POST" action="{{ route('study-partners-suggester.add-to-list') }}">
                                    @csrf
                                    <input type="hidden" name="operation_page_source" value="added">
                                    <input type="hidden" name="study_partner_profile_id" value="{{ $profile->profile_id }}">
                                </form>
                                <a href="{{ route('view-user-profile', ['profile_id' => $profile->profile_id]) }}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-2 me-2">View profile</a>
                                <button type="submit" form="add-to-list-form" class="section-button-extrashort rsans btn btn-primary fw-semibold px-2 ms-2">
                                    Add to my list
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endforeach
