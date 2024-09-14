<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPreference extends Model
{
    use HasFactory;

    protected $table = 'user_preference';
    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = true;

    protected $fillable = [
        'profile_id',
        'search_view_preference',
        'event_search_filters',
        'club_search_filters',
    ];

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }
}
