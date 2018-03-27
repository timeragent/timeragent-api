<?php

namespace App\GraphQL\Mutation\User;

use App\Models\User;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UpdateUserEmailMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUserEmail',
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'uuid'  => ['name' => 'uuid', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
        ];
    }

    public function rules()
    {
        return [
            'uuid'  => ['required'],
            'email' => ['required', 'email'],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::find($args['uuid']);

        if ( ! $user) {
            return null;
        }

        $user->email = $args['email'];
        $user->save();

        return $user;
    }
}