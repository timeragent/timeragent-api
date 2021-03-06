<?php

namespace App\Models;

/**
 * App\Models\Contact
 *
 * @mixin \Eloquent
 */
class Contact extends BaseModel
{
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'telephone',
    ];
}
