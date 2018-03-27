<?php

namespace App\Models;

/**
 * App\Models\OrganizationInvite
 *
 * @mixin \Eloquent
 */
class OrganizationInvite extends BaseModel
{
    protected $fillable = [
        'user_id',
        'organization_id',
        'email',
        'accept_token',
        'deny_token',
    ];
}
