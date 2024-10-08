<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPartner extends Model
{
    use HasFactory;

    protected $table = 'study_partner';
    public $incrementing = false;
    public $timestamps = true;

    // composite PK
    protected $primaryKey = ['profile_id', 'study_partner_profile_id'];

    protected $fillable = [
        'profile_id',
        'study_partner_profile_id',
        'connection_type',
    ];

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }
}
