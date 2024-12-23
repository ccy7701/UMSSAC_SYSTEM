<!-- resources/views/components/add-subject.blade.php -->
<div class="rsans modal fade" id="add-subject-modal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0" id="add-subject-modal-label">
                    Add New Subject
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-subject-form" method="POST" action="{{ route('subject-stats-log.add') }}">
                @csrf
                <input type="hidden" id="selected-semester" name="sem_prog_log_id">
                <div class="modal-body px-5">
                    <div class="form-group mb-3">
                        <label for="subject-code" class="fw-bold form-label">Code</label>
                        <input type="text" class="form-control" id="subject-code" name="subject_code" oninput="this.value = this.value.toUpperCase();" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="subject-name" class="fw-bold form-label">Subject Name</label>
                        <input type="text" class="form-control" id="subject-name" name="subject_name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="subject-credit-hours" class="fw-bold form-label">Credit Hours</label>
                        <input type="number" class="form-control" id="subject-credit-hours" name="subject_credit_hours" min="1" max="12" required placeholder="Enter credit hours...">
                    </div>
                    <div class="form-group mb-3">
                        <label for="subject-grade" class="fw-bold form-label">Grade</label>
                        <select class="form-select" id="subject-grade" name="subject_grade" required>
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
                    <button type="button" class="btn btn-secondary fw-semibold me-1 w-20" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary fw-semibold ms-1 w-20">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
