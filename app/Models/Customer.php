<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'default_billing_address_id', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function billingAddresses()
    {
        return $this->hasMany(BillingAddress::class);
    }

    public function defaultBillingAddress()
    {
        return $this->belongsTo(BillingAddress::class, 'default_billing_address_id');
    }
    public function isActive()
    {
        return $this->status === 'active'; // Adjust according to your status field
    }
}

