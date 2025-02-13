<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            $model->uuid = empty($model->uuid) ? self::generateUniqueUuid(get_class($model)) : $model->uuid;
        });
    }

    /**
     * Generate a unique 6-character UUID for the given model.
     *
     * @param string $modelClass
     * @return string
     */
    private static function generateUniqueUuid($modelClass)
    {
        do {
            $uuid = Str::upper(Str::random(6)); // Generate a 6-character random string
        } while ($modelClass::where('uuid', $uuid)->exists());

        return $uuid;
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
