<!-- resources/views/components/manage-member-card.blade.php -->
<div class="card h-100 d-flex align-items-center justify-content-center" id="card-member" style="min-height: 50vh;">
    <div class="rsans card-body text-center d-flex flex-column align-items-center justify-content-center">
        <form action="{{ route($route) }}" method="POST">
            @csrf
            <input type="hidden" name="profile_id" value="{{ $member->profile_id }}">
            <input type="hidden" name="club_id" value="{{ $club->club_id }}">
            <!-- Membership Type Display -->
            <!-- Conditional set; the logged in user cannot set their own access level -->
            @if (profile()->profile_id !== $member->profile_id)
                <div class="input-group py-1 px-2 mb-2">
                    <label for="membership-select-{{ $member->profile_id }}"  class="input-group-text">Level</label>
                    <select id="membership-select-{{ $member->profile_id }}" name="new_membership_type" class="form-select" data-current-role="{{ $member->membership_type }}">
                        <option value="1" {{ $member->membership_type == 1 ? 'selected' : '' }}>Member</option>
                        <option value="2" {{ $member->membership_type == 2 ? 'selected' : '' }}>Committee</option>
                    </select>
                </div>
            @endif
            <!-- Profile Picture -->
            <img src="{{ $member->profile->profile_picture }}" alt="User profile" class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #AAAAAA;">
            <!-- Name and Nickname -->
            <p class="fw-bold mb-0">
                @if($member->profile_id == profile()->profile_id)
                    You
                @else
                    {{ $member->profile->account->account_full_name }}
                @endif
            </p>
            <p class="fst-italic text-muted mb-0">({{ $member->profile->profile_nickname }})</p>
            <!-- Faculty and Email -->
            <div class="d-flex flex-column align-items-center">
                <div class="d-inline-flex align-items-center text-muted">
                    <i class="fa fa-university me-2"></i>
                    <p class="mb-0">{{ $member->profile->profile_faculty }}</p>
                </div>
                <div class="d-inline-flex align-items-center text-muted">
                    <i class="fa fa-envelope me-2"></i>
                    <p class="mb-0">{{ $member->profile->account->account_email_address }}</p>
                </div>
            </div>
            @if (profile()->profile_id !== $member->profile_id)
                <button id="membership-type-submit-{{ $member->profile_id }}" type="submit" class="btn btn-primary w-50 mx-auto mt-2" disabled onclick="return confirm('Are you sure you want to change access level for {{ $member->profile->account->account_full_name }}?');">Save</button>
            @endif
        </form>
    </div>
</div>
