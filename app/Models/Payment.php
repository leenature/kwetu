<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;

class Payment extends Model
{
    use BelongsToOrganization;

    protected $fillable = [

        'organization_id',

        'lease_id',

        'payment_date',

        'amount_paid',

        'payment_method',

        'reference_number',

        'receipt_number',

        'payment_for',

        'notes',

    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    protected function casts(): array
    {
        return ['payment_date' => 'date', 'amount_paid' => 'decimal:2'];
    }
}
