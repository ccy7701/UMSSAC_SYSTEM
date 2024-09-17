<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';
    protected $primaryKey = 'profile_id';
    public $timestamps = false;  // KIV, will you need this in the future?

    protected $fillable = [
        'account_id',
        'profile_nickname',
        'profile_personal_desc',
        'profile_enrolment_session',
        'profile_faculty',
        'profile_course',
        'profile_picture_filepath',
        'profile_colour_theme',
    ];

    // Define inverse relationship with Account model
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }

    public function semesterProgressLogs() {
        return $this->hasMany(SemesterProgressLog::class, 'profile_id', 'profile_id');
    }

    public function timetableSlots() {
        return $this->hasMany(TimetableSlot::class, 'profile_id', 'profile_id');
    }

    public function userPreference() {
        return $this->hasOne(UserPreference::class, 'profile_id', 'profile_id');
    }

    // ACCESSOR: Profile picture filepath
    public function getProfilePictureAttribute() {
        return $this->profile_picture_filepath ? Storage::url($this->profile_picture_filepath) : asset('images/no_profile_pic_default.png');
    }

    // ACCESSOR: Profile nickname
    public function getProfileNicknameAttribute() {
        return !empty($this->attributes['profile_nickname']) ? $this->attributes['profile_nickname'] : '';
    }

    // ACCESSOR: Profile enrolment session
    public function getProfileEnrolmentSessionAttribute() {
        return !empty($this->attributes['profile_enrolment_session']) ? $this->attributes['profile_enrolment_session'] : '';
    }

    // ACCESSOR: Profile faculty
    public function getProfileFacultyAttribute() {
        return !empty($this->attributes['profile_faculty']) ? $this->attributes['profile_faculty'] : '';
    }

    // ACCESSOR: Profile course
    public function getProfileCourseAttribute() {
        return !empty($this->attributes['profile_course']) ? $this->attributes['profile_course'] : '';
    }

    // ACCESSOR: Profile personal description
    public function getProfilePersonalDescAttribute() {
        return !empty($this->attributes['profile_personal_desc']) ? $this->attributes['profile_personal_desc'] : '';
    }
}
