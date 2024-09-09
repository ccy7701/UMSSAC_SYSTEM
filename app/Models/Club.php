<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $table = 'club';
    protected $primaryKey = 'club_id';
    public $timestamps = true;   // timestamps enabled for this model

    protected $fillable = [
        'club_name',
        'club_faculty',
        'club_description',
        'club_logo_filepath',
    ];

    public function events() {
        return $this->hasMany(Event::class, 'club_id', 'club_id');
    }
}
