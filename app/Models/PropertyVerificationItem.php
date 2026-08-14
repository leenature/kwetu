<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyVerificationItem extends Model
{
    protected $fillable = [
        'property_id',
        'check_key',
        'label',
        'status',
        'notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return ['reviewed_at' => 'datetime'];
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
