<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeWhereLike
{
    /**
     * Apply a where like query to multiple columns.
     *
     * @param  Builder  $query
     * @param  array  $columns
     * @param  string  $searchTerm
     * @return Builder
     */
    public function scopeWhereLike(Builder $query, array $columns, string $searchTerm): Builder
    {
        return $query->where(function (Builder $query) use ($columns, $searchTerm) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', "%{$searchTerm}%");
            }
        });
    }
}
