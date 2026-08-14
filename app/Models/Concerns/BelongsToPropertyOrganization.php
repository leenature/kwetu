<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToPropertyOrganization
{
    protected static function bootBelongsToPropertyOrganization(): void
    {
        static::addGlobalScope('organization', function (Builder $builder): void {
            $user = auth()->user();

            if (! $user || $user->role === 'Super Admin') {
                return;
            }

            if (! $user->organization_id) {
                $builder->whereRaw('1 = 0');

                return;
            }

            $builder->whereHas('property', function (Builder $propertyQuery) use ($user): void {
                $propertyQuery
                    ->withoutGlobalScopes()
                    ->where('organization_id', $user->organization_id);
            });
        });
    }
}
