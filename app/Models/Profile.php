<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    // ACCESSOR: Profile picture filepath
    public function getProfilePictureAttribute() {
        return $this->profile_picture_filepath ? Storage::url($this->profile_picture_filepath) : asset('images/no_profile_pic_default.png');
    }

    // ACCESSOR: Profile nickname
    public function getProfileNicknameAttribute() {
        return !empty($this->attributes['profile_nickname']) ? $this->attributes['profile_nickname'] : 'Not filled yet';
    }

    // ACCESSOR: Profile enrolment session
    public function getProfileEnrolmentSessionAttribute() {
        return !empty($this->attributes['profile_enrolment_session']) ? $this->attributes['profile_enrolment_session'] : 'Not filled yet';
    }

    // ACCESSOR: Profile faculty
    public function getProfileFacultyAttribute() {
        return !empty($this->attributes['profile_faculty']) ? $this->attributes['profile_faculty'] : 'Not filled yet';
    }

    // ACCESSOR: Profile course
    public function getProfileCourseAttribute() {
        return !empty($this->attributes['profile_course']) ? $this->attributes['profile_course'] : 'Not filled yet';
    }
}
