<?php

namespace App\GraphQL\Query\Project;

use App\Models\Organization;
use App\Models\Project;
use App\Models\Client;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

class ProjectsQuery extends Query
{
    protected $attributes = [
        'name' => 'projects',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Project'));
    }

    public function args()
    {
        return [
            'uuid'       => ['name' => 'uuid', 'type' => Type::string()],
            'name'       => ['name' => 'name', 'type' => Type::string()],
            'owner_type' => ['name' => 'owner_type', 'type' => Type::string()],
            'owner_uuid' => ['name' => 'owner_uuid', 'type' => Type::string()],
            'user_uuid'  => ['name' => 'user_uuid', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Project::query();

        if (isset($args['uuid'])) {
            $query->where('uuid', $args['uuid']);
        } elseif (isset($args['owner_type']) && isset($args['owner_uuid']) && isset($args['user_uuid']) ) {
            $query->getProjects($args['owner_type'], $args['owner_uuid'], $args['user_uuid']);
        } else {
            $query->getProjects($args['owner_type'], $args['owner_uuid']);
        }

        return $query->get();
    }


}