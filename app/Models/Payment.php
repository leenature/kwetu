<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'lease_id',
        'payment_date',
        'amount_paid',
        'payment_method',
        'reference_number',
        'receipt_number',
        'payment_for',
        'notes',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}