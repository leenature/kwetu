<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'account_type',
        'registration_number',
        'kra_pin',
        'phone',
        'email',
        'website',
        'address',
        'city',
        'country',
        'logo',
        'status',
        'plan',
        'subscription_status',
        'trial_ends_at',
    ];

    protected function casts(): array
    {
        return [
            'trial_ends_at' => 'datetime',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }
}
