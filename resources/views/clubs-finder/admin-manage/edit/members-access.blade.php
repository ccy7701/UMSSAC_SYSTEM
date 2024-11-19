<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Members, Roles and Requests</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #F8F8F8;">
    @vite('resources/js/app.js')
    @vite('resources/js/manageMemberOperations.js')
    <x-admin-topnav/>
    <x-about/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <x-response-popup
        messageType="accepted"
        iconClass="text-success fa-solid fa-right-to-bracket"
        title="Request accepted"/>
    <x-response-popup
        messageType="rejected"
        iconClass="text-muted fa-solid fa-user-slash"
        title="Request rejected"/>
    <!-- BREADCRUMB NAV -->
    <div id="club-breadcrumb" class="row w-80 justify-content-start mx-auto py-4">
        <div class="col-auto align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="rsans breadcrumb mb-0" style="--bs-breadcrumb-divider: '>';">
                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Details</a></li>
                    <li class="breadcrumb-item active">Manage Members, Roles and Requests
                </ol>
            </nav>
        </div>
    </div>
    <!-- ALT BREADCRUMB (COMPACT) -->
    <div id="club-breadcrumb-alt" class="row w-100 mx-auto py-2 border">
        <div class="col-4 d-flex justify-content-start align-items-start my-2">
            <nav aria-label="breadcrumb">
                <ol class="rsans breadcrumb m-0" style="--bs-breadcrumb-divider: '<'; font-size: 1.20em;">
                    <li class="breadcrumb-item"></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}">
                            Go back
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <main class="flex-grow-1 d-flex justify-content-center">
        <div id="main-card" class="card">
            <div class="row-container align-items-center px-3 mt-md-2 mt-sm-0 mt-xs-0 mt-0">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-left-alt col-xl-8 col-lg-9 col-md-12 col-12 mt-xl-2 mt-md-2 mt-sm-2 mt-2 mb-sm-1 mb-xs-2">
                        <h3 class="rserif fw-bold w-100">Manage Members, Roles and Requests</h3>
                    </div>
                    <div id="col-right-membership-edit" class="col-right-alt col-xl-4 col-lg-3 col-md-7 col-12 align-self-center mb-xl-0 mb-md-0 mb-sm-3 mb-3">
                        <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans w-xxl-50 w-lg-100 w-100 btn btn-secondary fw-semibold px-3">Go back</a>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <br>
                <div class="rsans alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {!! $error !!}
                        <br>
                    @endforeach
                </div>
            @endif
            <!-- BODY OF CONTENT -->
            <div class="row-container">
                <div class="align-items-center w-100 px-3">
                    <div id="member-grid-view" class="row grid-view px-3 mt-3">
                        @if ($clubMembers->isNotEmpty())
                            @foreach ($clubMembers as $member)
                                <div class="col-xl-4 col-lg-6 col-md-4 col-6 py-2 px-2 align-items-center text-center">
                                    <x-manage-member-card
                                        :member="$member"
                                        :club="$club"/>
                                </div>
                            @endforeach
                        @else
                            <p class="rsans text-center w-100 py-4">No members in this club yet</p>
                        @endif
                    </div>
                </div>
            </div>
            <br>
            <!-- JOIN REQUESTS -->
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-lg-12 text-start mt-2">
                            <h3 class="rserif fw-bold w-100">Join requests</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-container">
                <div class="align-items-center w-100 px-3">
                    <div id="member-grid-view" class="row grid-view px-3 mt-3">
                        @if ($joinRequests->isNotEmpty())
                            @foreach ($joinRequests as $joinRequest)
                                <div class="col-xl-4 col-lg-6 col-md-4 col-6 py-2 px-2 align-items-center text-center">
                                    <x-manage-join-request-card
                                        :user="$joinRequest"
                                        :club="$club"/>
                                </div>
                            @endforeach
                        @else
                            <p class="rsans text-center w-100 py-4">No pending join requests</p>
                        @endif
                    </div>
                </div>
            </div>
            <br>
            <!-- Edit confirmation modal -->
            <div class="rsans modal fade" id="edit-confirmation-modal" tabindex="-1" aria-labelledby="editConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                            <p class="fw-semibold fs-5 mb-0">
                                Edit Confirmation
                            </p>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to change access level for (user)?
                        </div>
                        <div class="modal-footer">
                            <form id="edit-access-level-form" method="POST" action="{{ route('admin-manage.edit-member-access.action', ['club_id' => $club->club_id]) }}">
                                @csrf
                                <input type="hidden" name="profile_id">
                                <input type="hidden" name="new_membership_type">
                                <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                                <button type="submit" class="btn btn-primary fw-semibold ms-1">Yes, continue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Reject confirmation modal -->
            <div class="rsans modal fade" id="reject-confirmation-modal" tabindex="-1" aria-labelledby="rejectConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                            <p class="fw-semibold fs-5 mb-0">
                                Reject Confirmation
                            </p>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to reject the join request of (user)?
                        </div>
                        <div class="modal-footer">
                            <form id="reject-join-request-form" method="POST" action="{{ route('admin-manage.join-requests.reject', ['club_id' => $club->club_id]) }}">
                                @csrf
                                <input type="hidden" name="profile_id">
                                <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                                <button type="submit" class="btn btn-danger fw-semibold ms-1">Yes, continue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Accept confirmation modal -->
            <div class="rsans modal fade" id="accept-confirmation-modal" tabindex="-1" aria-labelledby="rejectConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                            <p class="fw-semibold fs-5 mb-0">
                                Accept Confirmation
                            </p>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to accept (user)'s join request?
                        </div>
                        <div class="modal-footer">
                            <form id="accept-join-request-form" method="POST" action="{{ route('admin-manage.join-requests.accept', ['club_id' => $club->club_id]) }}">
                                @csrf
                                <input type="hidden" name="profile_id">
                                <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                                <button type="submit" class="btn btn-primary fw-semibold ms-1">Yes, continue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
