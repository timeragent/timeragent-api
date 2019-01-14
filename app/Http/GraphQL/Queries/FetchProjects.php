<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Project;

class FetchProjects
{
    public function resolve($rootValue, array $args)
    {
        $query = Project::query();

        $user_uuid = $args['userUuid'];

        if (isset($args['ownerType']) && isset($args['ownerUuid']) && isset($args['userUuid']) ) {
            $query->getProjects($args['ownerType'], $args['ownerUuid'], $args['userUuid']);
        }

        if (isset($args['key']) && $args['key'] === 'tasks') {
            $query->where(
                function ($query) use ($user_uuid) {
                    $query->whereHas(
                        'teams', function ($query) use ($user_uuid) {
                        $query->whereHas(
                            'users', function ($query) use ($user_uuid) {
                            $query->where('uuid', $user_uuid);
                        }
                        );
                    }
                    )
                          ->orWhereHas(
                              'users', function ($query) use ($user_uuid) {
                              $query->where('uuid', $user_uuid);
                          }
                          );
                }
            );
        }

        return $query->get();
    }
}
