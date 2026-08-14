<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToOrganization
{
    protected static function bootBelongsToOrganization(): void
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

            $builder->where(
                $builder->getModel()->qualifyColumn('organization_id'),
                $user->organization_id
            );
        });
    }
}
