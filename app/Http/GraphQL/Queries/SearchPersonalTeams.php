<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Team;
use App\Models\User;

class SearchPersonalTeams
{
    public function resolve($rootValue, array $args)
    {
        $query = Team::query();

        $query->where('name', 'LIKE', "{$args['queryString']}%");

        $query->where('owner_type', User::MORPH_NAME)
            ->where('owner_uuid', $args['userUuid']);

        return $query->get();
    }
}
