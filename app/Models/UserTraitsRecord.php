<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTraitsRecord extends Model
{
    use HasFactory;

    protected $table = 'user_traits_record';
    protected $primaryKey = 'user_traits_record_id';
    public $timestamps = true;

    protected $fillable = [
        'profile_id',
        'wtc_data',
        'personality_data',
        'skills_data',
        'learning_style'
    ];

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }
}
