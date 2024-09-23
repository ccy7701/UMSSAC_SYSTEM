<!-- resources/views/components/systemuser-list-item.blade.php -->
<div class="rsans card systemuser-list-item h-100" id="systemuser-list-item" data-category="{{ $user->profile_faculty }}" data-account-role="{{ $user->account_role }}">
    <div class="row g-0 align-items-center py-2">
        @if (empty($user->profile_picture_filepath))
            <div class="col-md-2 text-center">
                <img id="user-profile" src="{{ asset('images/no_profile_pic_default.png') }}" alt="User profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
        @else
            <div class="col-md-2 text-center">
                <img id="user-profile" src="{{ Storage::url($user->profile_picture_filepath) }}" alt="User profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
        @endif
        <!-- Content section -->
        <div class="col-md-10 text-start justify-content-center align-items-center">
            <div class="card-body">
                <span class="d-inline-flex align-items-center">
                    <p class="card-title fw-bold fs-5 mb-0 me-1">{{ $user->account_full_name }}</p>
                    <p class="fst-italic text-muted mb-0 ms-1">
                        @if ($user->profile_nickname == '')
                            (No nickname)
                        @else
                            ({{ $user->profile_nickname }})
                        @endif
                    </p>
                    @if ($user->account_role == 1)
                        <div class="bg-muted text-white py-1 px-2 ms-2 rounded">
                            <p class="fw-semibold mb-0">Student</p>
                        </div>
                    @elseif ($user->account_role == 2)
                        <div class="bg-primary text-white py-1 px-2 ms-2 rounded">
                            <p class="fw-semibold mb-0">Faculty Member</p>
                        </div>
                    @endif
                </span>
                <div class="row align-items-center text-muted">
                    <div class="col-1 text-center">
                        <i class="fa fa-university"></i>
                    </div>
                    <div class="col-10">
                        {{ $user->profile_faculty }}
                    </div>
                    <div class="col-1"></div>
                </div>
                @if ($user->account_role == 1)
                    <div class="row align-items-center text-muted">
                        <div class="col-1 text-center">
                            <i class="fa fa-id-badge"></i>
                        </div>
                        <div class="col-10">
                            {{ $user->account_matric_number }}
                        </div>
                    </div>
                @endif
                <div class="row align-items-center text-muted">
                    <div class="col-1 text-center">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="col-10">
                        {{ $user->account_email_address }}
                    </div>
                    <div class="col-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
