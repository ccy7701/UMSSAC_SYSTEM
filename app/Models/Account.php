<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\user as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'account';
    protected $primaryKey = 'accountID';
    public $timestamps = false;  // KIV, will you need this in the future?

    protected $fillable = [
        'accountFullName',
        'accountEmailAddress',
        'accountPassword',
        'accountRole',
        'accountMatricNumber',
    ];

    protected $hidden = [
        'accountPassword',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'accountPassword' => 'hashed',
        ];
    }

    public function profile() {
        return $this->hasOne(Profile::class, 'accountID', 'accountID');
    }

    // ACCESSOR: Get the user's full profile information
    public function getFullProfileAttribute() {
        return $this->profile;
    }

}
