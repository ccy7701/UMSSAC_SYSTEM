<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Account extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'account';
    protected $primaryKey = 'account_id';
    public $timestamps = true;

    protected $fillable = [
        'account_full_name',
        'account_email_address',
        'account_password',
        'account_contact_number',
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
        return $this->getEmailAttribute();
    }

    // Override method to get email address for email verification
    public function getEmailForVerification() {
        return $this->getEmailAttribute();
    }

    // Define the email attribute to satisfy the password reset broker
    public function getEmailAttribute() {
        return $this->account_email_address;
    }

    public function getContactNumberAttribute() {
        return $this->account_contact_number;
    }
}
