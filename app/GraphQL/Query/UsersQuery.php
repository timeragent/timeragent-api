<?php

namespace App\GraphQL\Query;

use App\Models\User;
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
            'id'          => ['name' => 'id', 'type' => Type::string()],
            'email'       => ['name' => 'email', 'type' => Type::string()],
            'first_name'  => ['name' => 'first_name', 'type' => Type::string()],
            'last_name'   => ['name' => 'last_name', 'type' => Type::string()],
            'middle_name' => ['name' => 'middle_name', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return User::where('id', $args['id'])->get();
        } else if (isset($args['email'])) {
            return User::where('email', $args['email'])->get();
        } else {
            return User::all();
        }
    }
}