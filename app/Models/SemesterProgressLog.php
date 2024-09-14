<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SemesterProgressLog extends Model
{
    use HasFactory;

    protected $table = 'semester_progress_log';
    protected $primaryKey = 'sem_prog_log_id';
    public $timestamps = false;     // KIV, will you need this in the future?

    protected $fillable = [
        'profile_id',
        'semester',
        'academic_session',
        'semester_gpa',
    ];

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }

    public function subjectStatsLogs() {
        return $this->hasMany(SubjectStatsLog::class, 'sem_prog_log_id', 'sem_prog_log_id');
    }
}
