<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Team;

class FetchTeams
{
    public function resolve($rootValue, array $args)
    {
        $query = Team::query();

        if (isset($args['ownerType']) && isset($args['ownerUuid']) && isset($args['userUuid'])) {
            $query->getTeams($args['ownerType'], $args['ownerUuid'], $args['userUuid']);
        } elseif (isset($args['ownerType']) && isset($args['ownerUuid'])) {
            $query->getTeams($args['ownerType'], $args['ownerUuid']);
        }

        return $query->get();
    }
}
