<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class BaseModel extends Model
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


    // HELPERS

    /**
     * @see vendor/laravel/passport/src/Bridge/UserRepository.php:L42
     *
     * @param string $username
     *
     * @return User
     */
    public function findForPassport(string $username): User
    {
        return User::where('email', $username)->first();
    }


    /**
     * @param string $password
     *
     * @return bool
     */
//    public function validateForPassportPasswordGrant(string $password): bool
//    {
//        return false;
//    }

    // OVERRIDES
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
