<!-- resources/views/components/add-ttslot-manual.blade.php -->
<div class="rsans modal fade" id="add-ttslot-manual" tabindex="-1" aria-labelledby="addTimetableSlotManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0">
                    Add Timetable Slot (Manual)
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-ttslot-manual-form" method="POST" action="{{ route('timetable-builder.add') }}">
                @csrf
                <input type="hidden" name="profile_id" value="{{ profile()->profile_id }}">
                <div class="modal-body px-5">
                    <div class="form-group mb-3">
                        <label for="class-subject-code" class="fw-bold form-label">Code</label>
                        <input type="text" class="form-control" id="class-subject-code" name="class_subject_code" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="class-name" class="fw-bold form-label">Subject name</label>
                        <input type="text" class="form-control" id="class-name" name="class_name" required>
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
                        <input type="number" class="form-control" id="class-section" name="class_section" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="class-lecturer" class="fw-bold form-label">Lecturer</label>
                        <input type="text" class="form-control" id="class-lecturer" name="class_lecturer" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="class-location" class="fw-bold form-label">Location</label>
                        <input type="text" class="form-control" id="class-location" name="class_location" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="day" class="fw-bold form-label">Day and time</label>
                        <select class="form-select" id="day" name="class_day" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="7">Sunday</option>
                        </select>
                        <label for="start-time" class="align-self-center p-2">from</label>
                        <select class="form-select" id="start-time" name="class_start_time" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="07:00:00">7:00 AM</option>
                            <option value="08:00:00">8:00 AM</option>
                            <option value="09:00:00">9:00 AM</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="11:00:00">11:00 AM</option>
                            <option value="12:00:00">12:00 PM</option>
                            <option value="13:00:00">1:00 PM</option>
                            <option value="14:00:00">2:00 PM</option>
                            <option value="15:00:00">3:00 PM</option>
                            <option value="16:00:00">4:00 PM</option>
                            <option value="17:00:00">5:00 PM</option>
                            <option value="18:00:00">6:00 PM</option>
                            <option value="19:00:00">7:00 PM</option>
                            <option value="20:00:00">8:00 PM</option>
                            <option value="21:00:00">9:00 PM</option>
                        </select>
                        <label for="end-time" class="align-self-center p-2">to</label>
                        <select class="form-select" id="end-time" name="class_end_time" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="08:00:00">8:00 AM</option>
                            <option value="09:00:00">9:00 AM</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="11:00:00">11:00 AM</option>
                            <option value="12:00:00">12:00 PM</option>
                            <option value="13:00:00">1:00 PM</option>
                            <option value="14:00:00">2:00 PM</option>
                            <option value="15:00:00">3:00 PM</option>
                            <option value="16:00:00">4:00 PM</option>
                            <option value="17:00:00">5:00 PM</option>
                            <option value="18:00:00">6:00 PM</option>
                            <option value="19:00:00">7:00 PM</option>
                            <option value="20:00:00">8:00 PM</option>
                            <option value="21:00:00">9:00 PM</option>
                            <option value="22:00:00">10:00 PM</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row w-100 px-0">
                        <div class="col-6 d-flex justify-content-start">
                            <a href="#" class="text-decoration-none text-dark fw-semibold align-content-center" data-bs-toggle="modal" data-bs-target="#add-ttslot-auto" data-bs-dismiss="modal">
                                Fill automatically
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
