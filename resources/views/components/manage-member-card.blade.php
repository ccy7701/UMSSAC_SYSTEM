<!-- resources/views/components/manage-member-card.blade.php -->
<div class="card h-100 align-items-center justify-content-center" id="card-member">
    <div class="rsans w-100 px-2 card-body text-center d-flex flex-column align-items-center justify-content-center">
        <input type="hidden" name="profile_id" value="{{ $member->profile_id }}">
        <input type="hidden" name="club_id" value="{{ $club->club_id }}">
        <!-- Membership Type Display -->
        <!-- Conditional set; the logged in user cannot set their own access level -->
        @if (profile()->profile_id !== $member->profile_id)
            <div id="membership-type" class="input-group py-1 px-2 mb-2">
                <label id="membership-type-label" for="membership-select-{{ $member->profile_id }}"  class="input-group-text">Level</label>
                <select id="membership-select-{{ $member->profile_id }}" name="new_membership_type" class="form-select" data-current-role="{{ $member->membership_type }}" style="cursor: pointer;">
                    <option value="1" {{ $member->membership_type == 1 ? 'selected' : '' }}>Member</option>
                    <option value="2" {{ $member->membership_type == 2 ? 'selected' : '' }}>Committee</option>
                </select>
            </div>
        @endif
        <!-- Profile Picture -->
        <img id="user-profile" src="{{ $member->profile->profile_picture }}" alt="User profile" class="rounded-circle mb-2">
        <!-- Name and Nickname -->
        <p class="fw-bold mb-0">
            @if($member->profile_id == profile()->profile_id)
                You
            @else
                {{ $member->profile->account->account_full_name }}
            @endif
        </p>
        <p class="fst-italic text-muted mb-0">({{ $member->profile->profile_nickname != '' ? $member->profile->profile_nickname : 'No nickname' }})</p>
        <!-- Faculty and Email -->
        <div class="d-flex flex-column align-items-center">
            <div class="d-inline-flex align-items-center text-muted">
                <i class="fa fa-university me-2"></i>
                <p class="mb-0">{{ $member->profile->profile_faculty != '' ? $member->profile->profile_faculty : 'Unspecified' }}</p>
            </div>
            <div class="px-0 d-inline-block align-items-center text-muted w-100">
                <span class="d-flex justify-content-center align-items-center text-truncate">
                    <i class="fa fa-id-badge me-2"></i>
                    @if ($member->profile->account->account_role == 1)
                        <p class="mb-0">Student: {{ $member->profile->account->account_matric_number }}</p>
                    @else
                        <p class="mb-0">Faculty Member</p>
                    @endif
                </span>
            </div>
        </div>
        <div class="px-0 d-inline-block align-items-center text-muted w-100">
            <span class="d-flex justify-content-center align-items-center">
                <i class="fa fa-envelope me-2"></i>
                <p class="mb-0 text-truncate">{{ $member->profile->account->account_email_address }}</p>
            </span>
        </div>
        @if (profile()->profile_id !== $member->profile_id)
            <button id="edit-access-level-submit-{{ $member->profile_id }}" class="btn btn-primary fw-semibold w-50 mx-auto mt-2" disabled
                data-bs-toggle="modal"
                data-bs-target="#edit-confirmation-modal"
                data-profile-id="{{ $member->profile_id }}">Save
            </button>
        @endif
    </div>
</div>
