<!-- resources/views/components/systemuser-list-item.blade.php -->
<div class="rsans card systemuser-list-item h-100" id="systemuser-list-item" data-category="{{ $user->profile_faculty }}" data-account-role="{{ $user->account_role }}">
    <div class="row g-0 align-items-center py-2">
        <div class="col-lg-2 text-center">
            <img id="user-profile" alt="User profile" src="{{ empty($user->profile_picture_filepath) ? asset('images/no_profile_pic_default.png') : Storage::url($user->profile_picture_filepath) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            @if ($user->account_role == 1)
                <div class="user-tag bg-muted text-white py-1 px-2 mt-2 rounded mx-auto">
                    <p class="fw-semibold mb-0">Student</p>
                </div>
            @elseif ($user->account_role == 2)
                <div class="user-tag bg-primary text-white py-1 px-2 mt-2 rounded mx-auto">
                    <p class="fw-semibold mb-0">Faculty Member</p>
                </div>
            @endif
        </div>
        <!-- Content section -->
        <div class="col-lg-10 text-start justify-content-center align-items-center">
            <div class="card-body">
                <div class="row align-items-center d-flex">
                    <div class="col-lg-auto col-12">
                        <p class="card-title fw-bold fs-5 mb-0">{{ $user->account_full_name }}</p>
                    </div>
                    <div class="col-lg-auto col-12">
                        <p class="fst-italic text-muted mb-0">
                            @if ($user->profile_nickname == '')
                                (No nickname)
                            @else
                                ({{ $user->profile_nickname }})
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row align-items-center text-muted mt-2">
                    <div class="col-1 text-center">
                        <i class="fa fa-university"></i>
                    </div>
                    <div class="col-10">
                        @if ($user->profile_faculty == '')
                            Unspecified
                        @else
                            {{ $user->profile_faculty }}
                        @endif
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
                    <div class="col-auto">
                        {{ $user->account_email_address }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
