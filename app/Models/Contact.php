<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @mixin \Eloquent
 */
class Contact extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'telephone',
    ];
}
