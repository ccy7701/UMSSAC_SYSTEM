<!-- resources/views/components/manage-join-request-card.blade.php -->
<div class="card h-100 align-items-center justify-content-center" id="card-join-request">
    <div class="rsans w-100 px-2 card-body text-center d-flex flex-column align-items-center justify-content-center">
        <input type="hidden" name="profile_id" value="{{ $user->profile_id }}">
        <input type="hidden" name="club_id" value="{{ $club->club_id }}">
        <!-- Profile picture -->
        <img id="user-profile" src="{{ $user->profile->profile_picture }}" alt="User profile" class="rounded-circle mb-2">
        <!-- Name and nickname -->
        <p class="fw-bold mb-0">
            {{ $user->profile->account->account_full_name }}
        </p>
        <p class="fst-italic text-muted mb-0">({{ $user->profile->profile_nickanme != '' ? $user->profile->profile_nickname : 'No nickname' }})</p>
        <!-- Faculty and email -->
        <div class="d-flex flex-column align-items-center">
            <div class="d-inline-flex align-items-center text-muted">
                <i class="fa fa-university me-2"></i>
                <p class="mb-0">{{ $user->profile->profile_faculty }}</p>
            </div>
            <div class="px-0 d-inline-block align-items-center text-muted w-100">
                <span class="d-flex justify-content-center align-items-center text-truncate">
                    @if ($user->profile->account->account_role == 1)
                        <p class="mb-0">Student: {{ $user->profile->account->account_matric_number }}</p>
                    @else
                        <p class="mb-0">Faculty Member</p>
                    @endif
                </span>
            </div>
        </div>
        <div class="px-0 d-inline-block align-items-center text-muted w-100">
            <span class="d-flex justify-content-center align-items-center">
                <i class="fa fa-envelope me-2"></i>
                <p class="mb-0 text-truncate">{{ $user->profile->account->account_email_address }}</p>
            </span>
        </div>
        <div class="row w-sm-60 w-100 my-2">
            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12 col-12 px-1">
                <button id="reject-request-submit-{{ $user->profile_id }}" class="btn btn-danger fw-semibold w-100 px-0"
                    data-bs-toggle="modal"
                    data-bs-target="#reject-confirmation-modal"
                    data-profile-id="{{ $user->profile_id }}">
                    Reject
                </button>
            </div>
            <div class="col-xl-6 col-md-6 col-xs-12 col-12 px-1 mt-xl-0 mt-md-0 mt-sm-1 mt-xs-1 mt-1">
                <button id="accept-request-submit-{{ $user->profile_id }}" class="btn btn-primary fw-semibold w-100 px-0"
                    data-bs-toggle="modal"
                    data-bs-target="#accept-confirmation-modal"
                    data-profile-id="{{ $user->profile_id }}">
                    Accept
                </button>
            </div>
        </div>
    </div>
</div>
