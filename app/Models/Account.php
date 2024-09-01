<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\user as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'account';
    protected $primaryKey = 'account_id';
    public $timestamps = false;  // KIV, will you need this in the future?

    protected $fillable = [
        'account_full_name',
        'account_email_address',
        'account_password',
        'account_role',
        'account_matric_number',
    ];

    protected $hidden = [
        'account_password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'account_password' => 'hashed',
        ];
    }

    public function profile() {
        return $this->hasOne(Profile::class, 'account_id', 'account_id');
    }

    // ACCESSOR: Get the user's full profile information
    public function getFullProfileAttribute() {
        return $this->profile;
    }

    // Override method to get email address for password reset
    public function getEmailForPasswordReset() {
        return $this->account_email_address;
    }

    // Define the email attribute to satisfy the password reset broker
    public function getEmailAttribute() {
        return $this->account_email_address;
    }
}
