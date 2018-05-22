<?php

namespace App\GraphQL\Query\Team;

use App\Models\Organization;
use App\Models\Team;
use App\Models\User;
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
            'team_uuid'       => ['name' => 'uuid', 'type' => Type::string()],
            'name'       => ['name' => 'name', 'type' => Type::string()],
            'owner_type' => ['name' => 'owner_type', 'type' => Type::string()],
            'owner_uuid' => ['name' => 'owner_uuid', 'type' => Type::string()],
            'query_string' => ['name' => 'query_string', 'type' => Type::string()],
            'organization_uuid' => ['name' => 'organization_uuid', 'type' => Type::string()],
            'user_uuid' => ['name' => 'user_uuid', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Team::query();

        if (isset($args['query_string'])) {
            $query->where('name', 'LIKE', "{$args['query_string']}%");
        }

        if (isset($args['team_uuid'])) {
            $query->where('uuid', $args['team_uuid']);
        } elseif (isset($args['organization_uuid'])) {
            $query->getTeams(Organization::MORPH_NAME, $args['organization_uuid']);
        } elseif (isset($args['user_uuid'])) {
            $query->getTeams(User::MORPH_NAME, $args['user_uuid']);
        } elseif (isset($args['owner_type']) && isset($args['owner_uuid'])) {
            $query->getTeams($args['owner_type'], $args['owner_uuid']);
        }

        return $query->get();
    }


}