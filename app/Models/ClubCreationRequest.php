<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubCreationRequest extends Model
{
    use HasFactory;

    protected $table = 'club_creation_request';
    protected $primaryKey = 'creation_request_id';
    public $timestamps = true;

    protected $fillable = [
        'requester_profile_id',
        'club_name',
        'club_category',
        'club_description',
        'club_image_paths',
        'request_status'
    ];

    // Define relationships
    public function profile() {
        return $this->belongsTo(Profile::class, 'requester_profile_id', 'profile_id');
    }

    // ACCESSOR: Club image JSON attribute
    public function getClubImagePathsAttribute() {
        return $this->attributes['club_image_paths'];
    }
}
