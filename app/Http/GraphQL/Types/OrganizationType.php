<?php

namespace App\Http\GraphQL\Types;

use App\Models\Organization;

class OrganizationType
{
    public function options(Organization $organization)
    {
        return [
            'status' => $organization->pivot->status,
        ];
    }
}
