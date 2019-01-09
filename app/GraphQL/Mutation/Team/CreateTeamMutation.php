<?php

namespace App\GraphQL\Mutation\Team;

use App\Validation\Rules\Uuid;
use App\Models\Team;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class CreateTeamMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createTeam',
    ];

    public function type()
    {
        return GraphQL::type('Team');
    }

    public function args()
    {
        return [
            'team' => ['name' => 'team', 'type' => GraphQL::type('TeamInput')],
        ];
    }

    public function rules()
    {
        return [
            'team.uuid' => [
                'required',
                new Uuid(),
            ],
            'team.name' => [
                'required',
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $params = collect($args['team']);

        $team_data = [
            'uuid' => $params['uuid'],
            'name' => $params['name'],
            'owner_type' => $params['ownerType'],
            'owner_uuid' => $params['ownerUuid'],
        ];

        $team = Team::create($team_data);

        $users_uuids = collect($args['team']['users'])->pluck('uuid')->toArray();

        $team->users()->sync($users_uuids);

        return $team;
    }
}