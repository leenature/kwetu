<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;

class Tenant extends Model
{
    use BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'full_name',
        'id_number',
        'phone',
        'email',
        'portal_token',
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
public function currentLease()
{
    return $this->hasOne(Lease::class)
        ->where('status', 'Active')
        ->latestOfMany();
}
    public function leases()
    {
        return $this->hasMany(Lease::class);
    }
    public function maintenanceRequests() { return $this->hasMany(MaintenanceRequest::class); }
}
