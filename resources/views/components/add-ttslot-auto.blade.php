<!-- resources/views/components/add-ttslot-auto.blade.php -->
<div class="rsans modal fade" id="add-ttslot-auto" tabindex="-1" aria-labelledby="addTimetableSlotAutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0">
                    Add Timetable Slot
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-ttslot-auto-form" method="POST" action="{{ route('timetable-builder.add') }}">
                @csrf
                <input type="hidden" name="profile_id" value="{{ profile()->profile_id }}">
                <div class="modal-body px-5">
                    <div class="form-group mb-3">
                        <label for="class-subject-code" class="fw-bold form-label">Code</label>
                        <input type="text" class="form-control" id="class-subject-code" name="class_subject_code" autocomplete="off" required">
                        <div id="subject-list" class="list-group mt-2 overflow-y-auto" style="max-height: 200px;"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="class-name" class="fw-bold form-label">Subject name</label>
                        <input type="text" class="form-control" id="class-name" name="class_name" readonly required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="class-category" class="fw-bold form-label">Category</label>
                        <select class="form-select" id="class-category" name="class_category" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="cocurricular">Co-curricular</option>
                            <option value="lecture">Lecture</option>
                            <option value="labprac">Lab/Practical</option>
                            <option value="tutorial">Tutorial</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="class-section" class="fw-bold form-label">Section/Group</label>
                        <input type="number" class="form-control" id="class-section" name="class_section" readonly required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="class-lecturer" class="fw-bold form-label">Lecturer</label>
                        <input type="text" class="form-control" id="class-lecturer" name="class_lecturer" readonly required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="class-location" class="fw-bold form-label">Location</label>
                        <input type="text" class="form-control" id="class-location" name="class_location" readonly required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="day" class="fw-bold form-label">Day and time</label>
                        <input type="text" class="form-control" id="class-day" name="class_day" readonly required>
                        <label for="start-time" class="align-self-center p-2">from</label>
                        <input type="text" class="form-control" id="class-start-time" name="class_start_time" readonly required>
                        <label for="end-time" class="align-self-center p-2">to</label>
                        <input type="text" class="form-control" id="class-end-time" name="class_end_time" readonly required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row w-100 px-0">
                        <div class="col-6 d-flex justify-content-start">
                            <a href="#" class="text-decoration-none text-dark fw-semibold align-content-center" data-bs-toggle="modal" data-bs-target="#add-ttslot-manual" data-bs-dismiss="modal">
                                Fill manually
                            </a>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary fw-semibold me-1 w-50" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary fw-semibold ms-1 w-50">Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
