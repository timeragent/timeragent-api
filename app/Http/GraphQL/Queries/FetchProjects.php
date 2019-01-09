<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Project;

class FetchProjects
{
    public function resolve($rootValue, array $args)
    {
        $query = Project::query();

        if (isset($args['ownerType']) && isset($args['ownerUuid']) && isset($args['userUuid']) ) {
            $query->getProjects($args['ownerType'], $args['ownerUuid'], $args['userUuid']);
        } else {
            $query->getProjects($args['ownerType'], $args['ownerUuid']);
        }

        return $query->get();
    }
}
