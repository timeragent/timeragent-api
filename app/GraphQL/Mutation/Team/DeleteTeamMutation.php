<?php

namespace App\GraphQL\Mutation\Team;

use App\Validation\Rules\Uuid;
use App\Models\Team;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class DeleteTeamMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteTeam',
    ];

    public function type()
    {
        return GraphQL::type('Team');
    }

    public function args()
    {
        return [
            'uuid' => ['name' => 'uuid', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function rules()
    {
        return [
            'uuid' => [
                'required',
                new Uuid(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $team = Team::find($args['uuid']);

        $team->delete();
    }
}