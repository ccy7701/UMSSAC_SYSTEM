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
            <div class="modal-body">
                <div id="reject-request-body">
                    You are about to reject the request to create (club_name). This action cannot be undone.
                </div>
                <br>
                <form id="reject-request-form" method="POST" action="{{ route('club-creation.requests.reject') }}">
                    @csrf
                    <input type="hidden" id="creation-request-id" name="creation_request_id" value="">
                    <div class="form-group mb-3">
                        <label for="request-remarks" class="form-label">Please provide your remarks before proceeding:</label>
                        <textarea id="request-remarks" name="request_remarks" class="rsans form-control" rows="3" style="resize: none;" maxlength="1024" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button form="reject-request-form" type="submit" class="btn btn-danger fw-semibold ms-1">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>
