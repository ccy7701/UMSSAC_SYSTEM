<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventBookmark extends Model
{
    use HasFactory;

    protected $table = 'event_bookmark';
    public $incrementing = false;
    public $timestamps = true;

    // composite PK
    protected $primaryKey = ['event_id', 'club_id'];

    protected $fillable = [
        'event_id',
        'profile_id',
        'created_at',
    ];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }
}
