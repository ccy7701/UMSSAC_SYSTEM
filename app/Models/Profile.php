<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
