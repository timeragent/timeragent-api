<?php

namespace App\GraphQL\Mutation\User;

use App\Models\User;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateUserPassword',
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'uuid'     => ['name' => 'uuid', 'type' => Type::nonNull(Type::string())],
            'password' => ['name' => 'password', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::find($args['uuid']);

        if ( ! $user) {
            return null;
        }

        $user->password = Hash::make($args['password']);
        $user->save();

        return $user;
    }
}