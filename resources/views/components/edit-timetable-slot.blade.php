<!-- resources/views/components/edit-timetable-item.blade.php -->
<div class="rsans modal fade" id="edit-timetable-slot-modal" tabindex="-1" aria-labelledby="editTimetableSlotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0">
                    Edit Timetable Slot
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-timetable-slot-form" method="POST" action="">
                @csrf
                <input type="hidden" id="edit-timetable-slot-id" name="timetable_slot_id" value="">
                <input type="hidden" name="profile_id" value="{{ profile()->profile_id }}">
                <div class="modal-body px-5">
                    <div class="form-group mb-3">
                        <label for="edit-class-subject-code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="edit-class-subject-code" name="class_subject_code" readonly required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit-class-name" class="form-label">Subject name</label>
                        <input type="text" class="form-control" id="edit-class-name" name="class_name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit-class-category" class="form-label">Category</label>
                        <select class="form-select" id="edit-class-category" name="class_category" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="cocurricular">Co-curricular</option>
                            <option value="lecture">Lecture</option>
                            <option value="labprac">Lab/Practical</option>
                            <option value="tutorial">Tutorial</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit-class-section" class="fw-bold form-label">Section/Group</label>
                        <input type="number" class="form-control" id="edit-class-section" name="class_section" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit-class-lecturer" class="fw-bold form-label">Lecturer</label>
                        <input type="text" class="form-control" id="edit-class-lecturer" name="class_lecturer" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit-class-location" class="fw-bold form-label">Location</label>
                        <input type="text" class="form-control" id="edit-class-location" name="class_location" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit-day" class="fw-bold form-label">Day and time</label>
                        <select class="form-select" id="edit-day" name="class_day" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="7">Sunday</option>
                        </select>
                        <label for="edit-start-time" class="align-self-center p-2">from</label>
                        <select class="form-select" id="edit-start-time" name="class_start_time" required>
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
                        <label for="edit-end-time" class="align-self-center p-2">to</label>
                        <select class="form-select" id="edit-end-time" name="class_end_time" required>
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
                    <button type="button" class="btn btn-secondary fw-semibold w-20" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary fw-semibold w-20">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
