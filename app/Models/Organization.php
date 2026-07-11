<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
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
    ];

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