<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $primaryKey = 'event_id';
    public $timestamps = true;   // timestamps enabled for this model

    protected $fillable = [
        'club_id',
        'event_name',
        'event_location',
        'event_datetime',
        'event_description',
        'event_entrance_fee',
        'event_sdp_provided',
        'event_image_paths',
        'event_registration_link',
        'event_status',
    ];

    public function club() {
        return $this->belongsTo(Club::class, 'club_id', 'club_id');
    }

    public function eventBookmark() {
        return $this->hasMany(EventBookmark::class, 'event_id', 'event_id');
    }
}
