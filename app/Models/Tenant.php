<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'organization_id',
        'full_name',
        'id_number',
        'phone',
        'email',
        'gender',
        'date_of_birth',
        'occupation',
        'employer',
        'emergency_contact_name',
        'emergency_contact_phone',
        'relationship',
        'notes',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }
}