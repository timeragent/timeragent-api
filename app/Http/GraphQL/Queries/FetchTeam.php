<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Team;

class FetchTeam
{
    public function resolve($rootValue, array $args)
    {
        return Team::find($args['uuid']);
    }
}
