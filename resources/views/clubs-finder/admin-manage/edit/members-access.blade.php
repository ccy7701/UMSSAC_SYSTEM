<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Members and Access Levels</title>
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/manageMemberOperations.js')
    <x-admin-topnav/>
    <x-about/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <main class="flex-grow-1">
        <div class="row-container">
            <!-- BREADCRUMB NAV -->
            <div id="club-breadcrumb" class="row pb-3">
                <div id="club-breadcrumb" class="col-auto align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>';">
                            <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Details</a></li>
                            <li class="breadcrumb-item active">Edit Members and Access Levels
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row-container">
            <div class="align-items-center px-3">
                <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                    <div class="col-left-alt col-lg-6 col-md-6 col-12 mt-xl-2 mt-sm-0 mt-0">
                        <h3 class="rserif fw-bold w-100">Edit members and access levels</h3>
                    </div>
                    <div class="col-right-alt col-lg-6 col-md-6 col-12 align-items-center mb-xl-0 mb-md-0 mb-sm-3 mb-3">
                        <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="section-button-short rsans btn btn-secondary fw-bold px-3">Go back</a>
                    </div>
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
                            <div class="col-xl-3 col-lg-4 col-md-4 col-6 align-items-center text-center">
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
            <!-- Edit confirmation modal -->
            <div class="rsans modal fade" id="edit-confirmation-modal" tabindex="-1" aria-labelledby="editConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                            <p class="fw-semibold fs-5 mb-0">
                                Edit confirmation
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
        </div>
        <br><br>
    </main>
    <x-footer/>
</body>

</html>
