<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Organization;

class FetchOrganizationMembers
{
    public function resolve($rootValue, array $args)
    {
        $organization = Organization::find($args['organizationUuid']);

        return $organization->users()->get();
    }
}
