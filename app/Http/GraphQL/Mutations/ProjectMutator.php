<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\Project;

class ProjectMutator
{
    public function createProject($rootValue, array $args)
    {
        $project_data = $args['project'];

        $project = new Project();

        $project->uuid        = $project_data['uuid'];
        $project->name        = $project_data['name'];
        $project->client_uuid = $project_data['clientUuid'] ?? null;
        $project->owner_type  = $project_data['ownerType'];
        $project->owner_uuid  = $project_data['ownerUuid'];
        $project->save();

        $teams_uuids = collect($args['project']['teams'])
            ->pluck('uuid')
            ->toArray();

        $team_users_uuids = collect($args['project']['teams'])
            ->map(
                function ($team) {
                    foreach ($team['users'] as $user) {
                        $users[$user['uuid']] = [
                            'team_uuid' => $team['uuid'],
                            'cost_rate' => $user['options']['costRate'],
                            'time_limit' => $user['options']['timeLimit'],
                        ];
                    }

                    return $users;
                }
            )
            ->toArray();

        $users_uuids = collect($args['project']['users'])
            ->map(
                function ($user) {

                    return [
                        $user['uuid'] => [
                            'team_uuid' => null,
                            'cost_rate' => $user['options']['costRate'],
                            'time_limit' => $user['options']['timeLimit'],
                        ],
                    ];
                }
            )
            ->toArray();

        $project->teams()->sync($teams_uuids);

        $uuids = array_merge($team_users_uuids, $users_uuids);

        if ($uuids) {
            $uuids = array_merge(...$uuids);
        }

        $project->users()->sync($uuids);

        return $project;
    }

    public function updateProject($root, $args)
    {
        $project_data = $args['project'];

        $project = Project::find($args['project']['uuid']);

        $project->name        = $project_data['name'];
        $project->client_uuid = $project_data['clientUuid'];
        $project->owner_type  = $project_data['ownerType'];
        $project->owner_uuid  = $project_data['ownerUuid'];
        $project->save();

        $teams_uuids = collect($args['project']['teams'])
            ->pluck('uuid')
            ->toArray();


        $team_users_uuids = collect($args['project']['teams'])
            ->map(
                function ($team) {
                    foreach ($team['users'] as $user) {
                        $users[$user['uuid']] = [
                            'team_uuid' => $team['uuid'],
                            'cost_rate' => $user['options']['costRate'] ?? null,
                            'time_limit' => $user['options']['timeLimit'] ?? 8,
                        ];
                    }
                    return $users;
                }
            )
            ->toArray();

        $users_uuids = collect($args['project']['users'])
            ->map(
                function ($user) {
                    return [
                        $user['uuid'] => [
                            'team_uuid' => null,
                            'cost_rate' => $user['options']['costRate'],
                            'time_limit' => $user['options']['timeLimit'],
                        ],
                    ];
                }
            )
            ->toArray();

        $project->teams()->sync($teams_uuids);

        $uuids = array_merge($team_users_uuids, $users_uuids);

        if ($uuids) {
            $uuids = array_merge(...$uuids);
        }

        $project->users()->sync($uuids);

        return $project;
    }

    public function deleteProject($root, $args)
    {
        $project = Project::find($args['uuid']);

        $project->delete();

        return $project;
    }
}
