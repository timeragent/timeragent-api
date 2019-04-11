<?php

namespace App\GraphQL\Mutation\Project;

use App\Validation\Rules\Uuid;
use App\Models\Team;
use App\Models\Project;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UpdateProjectMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateProject',
    ];

    public function type()
    {
        return GraphQL::type('Project');
    }

    public function args()
    {
        return [
            'project' => ['name' => 'project', 'type' => GraphQL::type('ProjectInput')],
        ];
    }

    public function rules()
    {
        return [
            'project.uuid' => [
                'required',
                new Uuid(),
            ],
            'project.name' => [
                'required',
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $params = collect($args['project']);

        $project_data = [
            'uuid' => $params['uuid'],
            'name' => $params['name'],
            'client_uuid' => $params['clientUuid'],
            'owner_type' => $params['ownerType'],
            'owner_uuid' => $params['ownerUuid'],
        ];

        $project = Project::find($args['project']['uuid']);

        $project->update($project_data);

        $teams_uuids = collect($args['project']['teams'])
            ->pluck('uuid')
            ->toArray();


        $team_users_uuids = collect($args['project']['teams'])
            ->map(function ($team) {
                foreach($team['users'] as $user) {
                    $users[$user['uuid']] = [
                        'team_uuid' => $team['uuid'],
                        'cost_rate' => $user['options']['costRate'] ?? null,
                        'time_limit' => $user['options']['time_limit'] ?? 8,
                    ];
                }
                return $users;
            })
            ->toArray();
        $users_uuids = collect($args['project']['users'])
            ->map(function($user) {

                return [$user['uuid'] => [
                    'team_uuid' => null,
                    'cost_rate' => $user['options']['costRate'],
                    'time_limit' => $user['options']['time_limit'] ?? 8,
                ]];
            })
            ->toArray();

        $project->teams()->sync($teams_uuids);

        $uuids = array_merge($team_users_uuids, $users_uuids);

        $uuids = array_merge(...$uuids);

        $project->users()->sync($uuids);

        return $project;
    }
}
