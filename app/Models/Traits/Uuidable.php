<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;

trait Uuidable
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                $key = $model->getKeyName();
                if (empty($model->{$key})) {
                    $model->{$key} = Uuid::uuid4()->toString();
                }
            }
        );
    }


    // OVERRIDES
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}