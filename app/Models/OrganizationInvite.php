<?php

namespace App\Models;

/**
 * App\Models\OrganizationInvite
 *
 * @mixin \Eloquent
 */
class OrganizationInvite extends BaseModel
{
    const STATUS_PENDING = 1;

    const STATUS_DECLINED = 2;

    const STATUS_ACCEPTED = 3;

    protected $fillable = [
        'organization_uuid',
        'email',
        'token',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
