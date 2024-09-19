<!-- resources/views/components/edit-subject.blade.php -->
<div class="rsans modal fade" id="edit-subject-modal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-subject-form" method="POST" action="">
                @csrf
                <input type="hidden" id="edit-selected-semester" name="sem_prog_log_id"> <!-- Selected semester will be added here -->
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label for="edit-subject-code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="edit-subject-code" name="subject_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-subject-name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="edit-subject-name" name="subject_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-subject-credit-hours" class="form-label">Credit Hours</label>
                        <input type="number" class="form-control" id="edit-subject-credit-hours" name="subject_credit_hours" min="1" max="12" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-subject-grade" class="form-label">Grade</label>
                        <select class="form-select" id="edit-subject-grade" name="subject_grade" required>
                            <option selected disabled value="">Choose...</option>
                            @if (profile()->profile_enrolment_session > "2021/2022")
                                <option value="A+">A+</option>
                            @endif
                            <option value="A">A</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B">B</option>
                            <option value="B-">B-</option>
                            <option value="C+">C+</option>
                            <option value="C">C</option>
                            <option value="C-">C-</option>
                            <option value="D+">D+</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="X">X</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>
