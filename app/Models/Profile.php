<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';
    protected $primaryKey = 'profileID';
    public $timestamps = false;  // KIV, will you need this in the future?

    protected $fillable = [
        'accountID',
        'profileNickname',
        'profilePersonalDesc',
        'profileEnrolmentSession',
        'profileFaculty',
        'profileProgramme',
        'profilePictureFilePath',
        'profileColourTheme',
    ];

    // Define inverse relationship with Account model
    public function account() {
        return $this->belongsTo(Account::class, 'accountID', 'accountID');
    }

    // ACCESSOR: Profile picture filepath
    public function getProfilePictureAttribute() {
        return $this->profilePictureFilePath ? Storage::url($this->profilePictureFilePath) : asset('images/no-pic-default.png');
    }

    // ACCESSOR: Profile nickname
    public function getProfileNicknameAttribute() {
        return $this->profileNickname ?? 'Not filled yet';
    }

    // ACCESSOR: Profile enrolment session
    public function getProfileEnrolmentSessionAttribute() {
        return $this->profileEnrolmentSession ?? 'Not filled yet';
    }

    // ACCESSOR: Profile faculty
    public function getProfileFacultyAttribute() {
        return $this->profileFaculty ?? 'Not filled yet';
    }

    // ACCESSOR: Profile programme
    public function getProfileProgrammeAttribute() {
        return $this->profileProgramme ?? 'Not filled yet';
    }
}
