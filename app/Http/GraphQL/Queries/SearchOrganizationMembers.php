<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Organization;

class SearchOrganizationMembers
{
    public function resolve($rootValue, array $args)
    {
        $organization = Organization::find($args['organizationUuid']);
        return $organization
            ->users()
            ->where('email', 'LIKE', "{$args['queryString']}%")
            ->get();
    }
}
