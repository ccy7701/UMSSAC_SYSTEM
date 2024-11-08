<!-- resources/views/components/reject-request.blade.php -->
<div class="rsans modal fade" id="reject-confirmation-modal" tabindex="-1" aria-labelledby="rejectConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0">
                    Reject Club Creation Request
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="reject-request-body" class="modal-body">
                Are you sure you want to reject the request to create (club name)? This action cannot be undone!
            </div>
            <div class="modal-footer">
                <form id="reject-request-form" method="POST" action="{{ route('club-creation.requests.reject') }}">
                    @csrf
                    <input type="hidden" id="creation-request-id" name="creation_request_id" value="">
                    <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">
                        No, cancel
                    </button>
                    <button type="submit" class="btn btn-danger fw-semibold ms-1">
                        Yes, continue
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
