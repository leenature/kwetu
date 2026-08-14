<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\Concerns\BelongsToPropertyOrganization;

class Unit extends Model
{
    use BelongsToPropertyOrganization;

    protected $fillable = [
        'property_id',
        'unit_number',
        'unit_type',
        'bedrooms',
        'bathrooms',
        'floor',
        'monthly_rent',
        'deposit',
        'status',
        'description',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }
    public function maintenanceRequests() { return $this->hasMany(MaintenanceRequest::class); }
}
