<!-- resources/views/components/delete-subject.blade.php -->
<div class="rsans modal fade" id="delete-confirmation-modal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0">
                    Delete confirmation
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this subject?
            </div>
            <div class="modal-footer">
                <form id="delete-subject-form" method="DELETE" action="">
                    @csrf
                    <input type="hidden" id="sem-prog-log-id" name="sem_prog_log_id" value="">
                    <input type="hidden" id="subject-code" name="subject_code" value="">
                    <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                    <button type="submit" class="btn btn-danger fw-semibold ms-1">Yes, continue</button>
                </form>
            </div>
        </div>
    </div>
</div>