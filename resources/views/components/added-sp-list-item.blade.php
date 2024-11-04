<!-- resources/views/components/added-sp-list-item.blade.php -->
@php
    // Evaluate the type of profile data to be used;
    // 1 - those who the user has added, 2 - those who have added the user
    $profile = ($type == 1) ? $record->studyPartnerProfile : $record->profile;
@endphp
<div class="rsans card added-sp-list-item h-100" id="added-sp-list-item-{{ $record->profile_id }}-{{ $record->study_partner_profile_id }}">
    <div class="row g-0 align-items-center pb-2 pt-md-2 pt-3">
        <div class="col-md-2 text-center">
            <img id="user-profile" src="{{ $profile->profile_picture }}" alt="User profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
        </div>
        <div class="col-md-7 text-start justify-content-center align-items-center">
            <div class="card-body">
                <span class="d-inline-flex align-items-center">
                    <p class="card-title fw-bold fs-5 mb-0 me-1">
                        {{ $profile->account->account_full_name }}
                    </p>
                    <p class="fst-italic text-muted mb-0 ms-1">
                        ({{ $profile->profile_nickname != '' ? $profile->profile_nickname : 'No nickname' }})
                    </p>
                    @if ($type == 2 && in_array($profile->profile_id, $intersectionarray))
                        <button class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none" disabled>
                            &emsp;<i class="fa fa-user-plus text-primary fs-5"></i>
                            <p class="text-primary ms-2 mb-0 align-middle">Added</p>
                        </button>
                    @endif
                </span>
                <div class="row align-self-center text-muted">
                    <div class="col-1 text-center"><i class="fa fa-university"></i></div>
                    <div class="col-11">{{ $profile->profile_faculty }}</div>
                </div>
                <div class="row align-items-center text-muted">
                    <div class="col-1 text-center"><i class="fa fa-id-badge"></i></div>
                    <div class="col-11">{{ $profile->account->account_matric_number }}</div>
                </div>
                <div class="row align-items-center text-muted">
                    <div class="col-1 text-center"><i class="fa fa-envelope"></i></div>
                    <div class="col-11">{{ $profile->account->account_email_address }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-1 text-center">
            @if (!($type == 2 && in_array($profile->profile_id, $intersectionarray)))
                <button class="btn btn-muted toggle-details" data-bs-toggle="collapse" data-bs-target="#details-{{ $record->profile_id }}-{{ $record->study_partner_profile_id }}">
                    <i class="fa fa-chevron-down fs-1 chevron-icon"></i>
                </button>
            @endif
        </div>
        <div id="details-{{ $record->profile_id }}-{{ $record->study_partner_profile_id }}" class="collapse">
            <hr class="divider-gray-300 mb-4 mt-2">
            <div class="container px-2">
                @if ($type == 1)
                    <div class="row">
                        <div class="added-sps-actions-row d-flex justify-content-center col-12 mb-3 px-0">
                            <a href="{{ route('view-user-profile', ['profile_id' => $record->study_partner_profile_id]) }}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-3 me-2">View profile</a>
                            <button type="button" class="section-button-extrashort rsans btn btn-danger fw-semibold px-2"
                                data-bs-toggle="modal"
                                data-bs-target="#delete-sp-confirmation-modal"
                                data-study-partner-name="{{ $profile->account->account_full_name }}"
                                data-study-partner-profile-id="{{ $profile->profile_id }}">
                                Remove from list
                            </button>
                        </div>
                    </div>
                @elseif ($type == 2 && !in_array($profile->profile_id, $intersectionarray))
                    <div class="row">
                        <div class="added-sps-actions-row d-flex justify-content-center col-12 mb-3 px-0">
                            <form class="w-100 d-flex justify-content-center" method="POST" action="{{ route('study-partners-suggester.add-to-list') }}">
                                @csrf
                                <input type="hidden" name="operation_page_source" value="added">
                                <input type="hidden" name="study_partner_profile_id" value="{{ $profile->profile_id }}">
                                <a href="{{ route('view-user-profile', ['profile_id' => $profile->profile_id]) }}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-3 me-2">View profile</a>
                                <button type="submit" class="section-button-extrashort rsans btn btn-primary fw-semibold px-3 ms-2">Add to my list</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
