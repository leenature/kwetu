<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;

class Lease extends Model
{
    use BelongsToOrganization;

    protected $fillable = [

        'organization_id',

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

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

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

    protected function casts(): array { return ['start_date' => 'date', 'end_date' => 'date']; }
}
