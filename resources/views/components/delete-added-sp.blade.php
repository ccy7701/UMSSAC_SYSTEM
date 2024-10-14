<!-- resources/views/components/delete-added-sp.blade.php -->
<div class="rsans modal fade" id="delete-sp-confirmation-modal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0">
                    Delete Confirmation
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="delete-added-sp-body" class="modal-body">
                Are you sure you want to remove (study_partner) from your study partners list?
            </div>
            <div class="modal-footer">
                <form id="delete-sp-form" method="POST" action="{{ route('study-partners-suggester.delete-from-list') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="study-partner-profile-id" name="study_partner_profile_id" value="">
                    <button type="button" class="btn btn-secondary fw-semibold me-1" data-bs-dismiss="modal">No, cancel</button>
                    <button type="submit" class="btn btn-danger fw-semibold ms-1">Yes, continue</button>
                </form>
            </div>
        </div>
    </div>
</div>
