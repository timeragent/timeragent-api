<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrganizationInvite
 *
 * @mixin \Eloquent
 */
class OrganizationInvite extends Model
{
    protected $fillable = [
        'user_id',
        'organization_id',
        'email',
        'accept_token',
        'deny_token',
    ];
}
