<?php

namespace App\GraphQL\Mutation\Project;

use App\Validation\Rules\Uuid;
use App\Models\Team;
use App\Models\Project;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class CreateProjectMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createProject',
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

        $filteredParams = $params->only([
            'uuid',
            'name',
            'client_uuid',
            'owner_type',
            'owner_uuid'
        ])
        ->toArray();

        $project = Project::create($filteredParams);
        $teams_uuids = collect($args['project']['teams'])
            ->pluck('uuid')
            ->toArray();


        $team_users_uuids = collect($args['project']['teams'])
            ->map(function ($team) {
                foreach($team['users'] as $user) {
                    $users[$user['uuid']] = [
                        'team_uuid' => $team['uuid'],
                        'cost_rate' => $user['options']['cost_rate']
                    ];
                }
                return $users;
            })
            ->toArray();
        $users_uuids = collect($args['project']['users'])
            ->map(function($user) {

                return [$user['uuid'] => [
                    'team_uuid' => null,
                    'cost_rate' => $user['options']['cost_rate']
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