<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;

class Expense extends Model
{
    use BelongsToOrganization;

    protected $fillable = [
        'organization_id',
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

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    protected function casts(): array
    {
        return ['expense_date' => 'date', 'amount' => 'decimal:2'];
    }
}
