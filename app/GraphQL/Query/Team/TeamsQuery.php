<?php

namespace App\GraphQL\Query\Team;

use App\Models\Team;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

class TeamsQuery extends Query
{
    protected $attributes = [
        'name' => 'teams',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Team'));
    }

    public function args()
    {
        return [
            'uuid'       => ['name' => 'uuid', 'type' => Type::string()],
            'name'       => ['name' => 'name', 'type' => Type::string()],
            'owner_type' => ['name' => 'owner_type', 'type' => Type::string()],
            'owner_uuid' => ['name' => 'owner_uuid', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['uuid'])) {
            return Team::where('uuid', $args['uuid'])->get();
        } else {
//            dd(Team::getTeams($args['owner_type'], $args['owner_uuid']));
            return Team::getTeams($args['owner_type'], $args['owner_uuid']);
        }
    }


}