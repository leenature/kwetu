<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'organization_id',
        'code',
        'name',
        'type',
        'county',
        'town',
        'address',
        'floors',
        'description',
        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}