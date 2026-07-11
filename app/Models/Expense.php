<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'property_id',
        'unit_id',
        'category',
        'title',
        'amount',
        'expense_date',
        'vendor',
        'payment_method',
        'reference_number',
        'status',
        'notes',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}