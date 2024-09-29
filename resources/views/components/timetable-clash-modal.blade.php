<!-- resources/views/components/timetable-clash-modal.blade.php -->
<div class="rsans modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="timetableClashModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center justify-content-center">
                <p class="fw-semibold fs-5 mb-0">
                    Timetable Clash Detected
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                The selected timetable slot overlaps with one or more existing slots. Please check your input again.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Go back</button>
            </div>
        </div>
    </div>
</div>
