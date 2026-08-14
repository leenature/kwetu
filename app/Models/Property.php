<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;

class Property extends Model
{
    use BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'property_client_id',
        'code',
        'name',
        'type',
        'county',
        'town',
        'address',
        'latitude',
        'longitude',
        'floors',
        'description',
        'amenities',
        'status',
        'verification_status',
        'verification_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function client() { return $this->belongsTo(PropertyClient::class, 'property_client_id'); }
    public function verificationItems() { return $this->hasMany(PropertyVerificationItem::class); }

   public function units()
{
    return $this->hasMany(Unit::class);
}

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function files() { return $this->hasMany(PropertyFile::class); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
    public function servicePartners() { return $this->belongsToMany(ServicePartner::class, 'property_service_partner')->withTimestamps(); }
    public function maintenanceRequests() { return $this->hasMany(MaintenanceRequest::class); }

    protected function casts(): array
    {
        return ['amenities' => 'array', 'reviewed_at' => 'datetime'];
    }
    
}
