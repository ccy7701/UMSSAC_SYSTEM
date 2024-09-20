<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableSlot extends Model
{
    use HasFactory;

    protected $table = 'timetable_slot';
    protected $primaryKey = 'timetable_slot_id';
    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'class_subject_code',
        'class_name',
        'class_category',
        'class_section',
        'class_lecturer',
        'class_location',
        'class_day',
        'class_start_time',
        'class_end_time'
    ];

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }
}
