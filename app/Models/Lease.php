<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    protected $fillable = [
        'tenant_id',
        'unit_id',
        'start_date',
        'end_date',
        'rent_amount',
        'deposit_amount',
        'payment_frequency',
        'status',
        'notes',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}