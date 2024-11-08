<!-- resources/views/components/accept-request.blade.php -->
<div class="rsans modal fade" id="accept-confirmation-modal" tabindex="-1" aria-labelledby="acceptConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0">
                    Accept Club Creation Request
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="accept-request-body">
                    You are about to approve the request to create (club_name). This action will finalise the club creation. Are you sure you want to continue?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">
                    No, go back
                </button>
                <form id="accept-request-form" method="POST" action="{{ route('club-creation.requests.accept') }}">
                    @csrf
                    <input type="hidden" name="creation_request_id" value="">
                    <button type="submit" class="btn btn-primary fw-semibold ms-1">
                        Yes, continue
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
