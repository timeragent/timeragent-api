<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
