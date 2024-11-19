<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $primaryKey = 'notification_id';
    public $timestamps = true;

    protected $fillable = [
        'profile_id',
        'notification_type',
        'notification_title',
        'notification_message',
        'is_read',
    ];

    public function profile() {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }
}
