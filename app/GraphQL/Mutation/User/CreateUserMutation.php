<?php

namespace App\GraphQL\Mutation\User;

use App\Models\User;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateUserMutation',
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'user' => ['name' => 'user', 'type' => GraphQL::type('UserInput')],
        ];
    }

    public function rules()
    {
        return [
            'user.uuid'       => [
                'required',
                'regex:/^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$/i',
            ],
            'user.email'      => ['required', 'email'],
            'user.first_name' => ['required'],
            'user.last_name'  => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $params = collect($args['user'])
            ->only(
                [
                    'uuid',
                    'email',
                    'first_name',
                    'last_name',
                    'middle_name',
                ]
            )
            ->toArray();

        return User::create($params);
    }
}