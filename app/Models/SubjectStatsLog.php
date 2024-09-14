<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjectStatsLog extends Model
{
    use HasFactory;

    protected $table = 'subject_stats_log';
    public $incrementing = false;
    protected $primaryKey = null;   // Fully dependent on its parent's existence
    public $timestamps = false;

    protected $fillable = [
        'sem_prog_log_id',
        'subject_code',
        'subject_name',
        'subject_credit_hours',
        'subject_grade',
        'subject_grade_point',
    ];

    public function semesterProgressLog() {
        return $this->belongsTo(SemesterProgressLog::class, 'sem_prog_log_id', 'sem_prog_log_id');
    }

    // Override the save method to skip PK validation
    public function save(array $options = []) {
        if (!$this->exists) {
            $this->exists = true;   // "Trick Eloquent into thinking the record exists
        }
        return parent::save($options);
    }
}
