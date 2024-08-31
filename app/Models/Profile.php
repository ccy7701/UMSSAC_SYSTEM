<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'profile_programme',
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
        return $this->profile_nickname ?? 'Not filled yet';
    }

    // ACCESSOR: Profile enrolment session
    public function getProfileEnrolmentSessionAttribute() {
        return $this->profile_enrolment_session ?? 'Not filled yet';
    }

    // ACCESSOR: Profile faculty
    public function getProfileFacultyAttribute() {
        return $this->profile_faculty ?? 'Not filled yet';
    }

    // ACCESSOR: Profile programme
    public function getProfileProgrammeAttribute() {
        return $this->profile_programme ?? 'Not filled yet';
    }
}
