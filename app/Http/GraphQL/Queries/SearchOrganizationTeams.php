<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Organization;
use App\Models\Team;

class SearchOrganizationTeams
{
    public function resolve($rootValue, array $args)
    {
        $query = Team::query();

        $query->where('name', 'LIKE', "{$args['queryString']}%");

        $query->where('owner_type', Organization::MORPH_NAME)
              ->where('owner_uuid', $args['organizationUuid']);

        return $query->get();
    }
}
