<!-- resources/views/components/member-card.blade.php -->
<div class="card h-100 d-flex align-items-center justify-content-center" id="card-member">
    <div class="rsans card-body text-center d-flex flex-column align-items-center justify-content-center">
        @if($member->membership_type == 1)
            <div class="bg-muted text-white py-1 px-2 mb-2 rounded">
                <p class="fw-bold mb-0">Member</p>
            </div>
        @elseif($member->membership_type == 2)
            <div class="bg-primary text-white py-1 px-2 mb-2 rounded">
                <p class="fw-bold mb-0">Committee</p>
            </div>
        @endif
        <img src="{{ $member->profile->profile_picture }}" alt="User profile" class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #AAAAAA;">
        <p class="fw-bold mb-0">
            @if($member->profile_id == profile()->profile_id)
                You
            @else
                {{ $member->profile->account->account_full_name }}
            @endif
        </p>
        <p class="fst-italic text-muted mb-0">
            @if ($member->profile->profile_nickname == '')
                (No nickname)
            @else
                ({{ $member->profile->profile_nickname }})
            @endif
        </p>
        <span class="d-inline-flex align-items-center text-muted">
            <i class="fa fa-university me-2"></i>
            <p class="mb-0">{{ $member->profile->profile_faculty }}</p>
        </span>
        <span class="d-inline-flex align-items-center text-muted">
            <i class="fa fa-envelope me-2"></i>
            <p class="mb-0">{{ $member->profile->account->account_email_address }}</p>
        </span>
    </div>
</div>
