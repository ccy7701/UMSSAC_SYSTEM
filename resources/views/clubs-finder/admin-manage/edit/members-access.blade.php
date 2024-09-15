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

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/manageMemberOperations.js')
    <x-topnav/>
    <x-success-message/>
    <br>
    <div class="container p-3">

        <!-- TOP SECTION -->
        <div class="d-flex align-items-center">
            <div class="row w-100">
                <div class="col-12 text-center">
                    <!-- BREADCRUMB NAV -->
                    <div class="row pb-3">
                        <div class="col-8 align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>';">
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Details</a></li>
                                    <li class="breadcrumb-item active">Edit Members and Access Levels
                                </ol>
                            </nav>
                        </div>
                        <div class="col-4"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <div class="container-fluid align-items-center py-4">
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Members and access levels</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans btn btn-secondary fw-bold px-3 mx-2 w-25">Go back</a>
                    </div>
                </div>
            </div>
            <div class="container px-3 py-4">
                <div id="member-grid-view" class="row grid-view">
                    @foreach ($clubMembers as $member)
                        <div class="col-lg-3 col-md-4 py-2">
                            <x-manage-member-card
                                :member="$member"
                                :club="$club"
                            />
                        </div>
                    @endforeach
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
            </div>
        </div>
    </div>
    <x-footer/>
</body>

</html>
