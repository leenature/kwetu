<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ServicePartner extends Model
{
    protected $fillable = ['name', 'website', 'icon', 'description', 'is_active', 'available_to_all_properties', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'available_to_all_properties' => 'boolean'];
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_service_partner')->withTimestamps();
    }

    public function scopeAvailableForProperty($query, Property $property)
    {
        return $query->where('is_active', true)
            ->where(function ($availability) use ($property) {
                $availability->where('available_to_all_properties', true)
                    ->orWhereHas('properties', fn ($properties) => $properties->whereKey($property->id));
            });
    }
}
