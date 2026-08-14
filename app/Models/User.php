<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
    'organization_id',
    'name',
    'email',
    'password',
    'role',
    'permissions',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
        ];
    }

    public function canAccessModule(string $module): bool
    {
        if (in_array($this->role, ['Super Admin', 'Owner'], true)) return true;
        $defaults = [
            'Manager' => ['properties', 'units', 'tenants', 'leases', 'payments', 'expenses', 'reports', 'maintenance'],
            'Accountant' => ['payments', 'expenses', 'reports'],
            'Caretaker' => ['properties', 'units', 'tenants', 'maintenance'],
        ];
        return in_array($module, $this->permissions ?? ($defaults[$this->role] ?? []), true);
    }
}
