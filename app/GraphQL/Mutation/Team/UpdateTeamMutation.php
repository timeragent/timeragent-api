<?php

namespace App\GraphQL\Mutation\Team;

use App\Validation\Rules\Uuid;
use App\Models\Team;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UpdateTeamMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateTeam',
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

        $filteredParams = $params->only([
            'uuid',
            'name',
            'owner_type',
            'owner_uuid'
        ])
        ->toArray();

        $team = Team::find($args['team']['uuid']);

        $team->update($filteredParams);

        $users_uuids = collect($args['team']['users'])->pluck('uuid')->toArray();

        $team->users()->sync($users_uuids);

        return $team;
    }
}