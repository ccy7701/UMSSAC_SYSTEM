<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubMembership extends Model
{
    use HasFactory;

    protected $table = 'club_membership';
    public $incrementing = false;
    public $timestamps = true;

    // composite PK
    protected $primaryKey = ['profile_id', 'club_id'];

    protected $fillable = [
        'profile_id',
        'club_id',
        'membership_type'
    ];

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }

    public function club() {
        return $this->belongsTo(Club::class, 'club_id', 'club_id');
    }

    // override to handle composite PK
    public function getKeyName() {
        return ['profile_id', 'club_id'];
    }
}
