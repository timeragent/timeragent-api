<?php

namespace App\GraphQL\Query\User;

use App\Models\User;
use App\Models\Organization;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'uuid'        => ['name' => 'uuid', 'type' => Type::string()],
            'email'       => ['name' => 'email', 'type' => Type::string()],
            'first_name'  => ['name' => 'first_name', 'type' => Type::string()],
            'last_name'   => ['name' => 'last_name', 'type' => Type::string()],
            'middle_name' => ['name' => 'middle_name', 'type' => Type::string()],
            'query_string' => ['name' => 'query_string', 'type' => Type::string()],
            'organization_uuid' => ['name' => 'organization_uuid', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['uuid'])) {
            return User::where('uuid', $args['uuid'])->get();
        } else if (isset($args['email'])) {
            return User::where('email', $args['email'])->get();
        } else if (isset($args['organization_uuid']) && isset($args['query_string'])) {
            $organization = Organization::find($args['organization_uuid']);
            return $organization->users()->where('first_name', 'LIKE', "{$args['query_string']}%")->get();
        } else if (isset($args['query_string'])) {
            return User::where('first_name', 'LIKE', "{$args['query_string']}%")->get();
        } else {
            return User::all();
        }
    }
}