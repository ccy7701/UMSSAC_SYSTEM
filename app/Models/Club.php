<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    use HasFactory;

    protected $table = 'club';
    protected $primaryKey = 'club_id';
    public $timestamps = true;

    protected $fillable = [
        'club_name',
        'club_category',
        'club_description',
        'club_image_paths',
    ];

    public function events() {
        return $this->hasMany(Event::class, 'club_id', 'club_id');
    }

    public function clubMemberships() {
        return $this->hasMany(ClubMembership::class, 'club_id', 'club_id');
    }

    // ACCESSOR: Club image JSON attribute
    public function getClubImagePathsAttribute() {
        return $this->attributes['club_image_paths'];
    }
}
