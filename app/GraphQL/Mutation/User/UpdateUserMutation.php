<?php

namespace App\GraphQL\Mutation\User;

use App\Models\User;
use App\Validation\Rules\Unique;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use GraphQL\Type\Definition\Type;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateUser',
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'uuid' => ['name' => 'uuid', 'type' => Type::string()],
            'user' => ['name' => 'user', 'type' => GraphQL::type('UserInput')],
        ];
    }

    public function rules()
    {
        return [
            'uuid'            => [
                'required',
                'regex:/^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$/i',
                'exists:users,uuid',
            ],
            'user.email'      => [
                'required',
                'email',
                (new Unique('users', 'email'))
                    ->ignore(
                        array_get(
                            app('request')->all(),
                            'variables.uuid'
                        ),
                        'uuid'
                    ),
            ],
            'user.password'   => [
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ],
            'user.first_name' => [
                'required',
            ],
            'user.last_name'  => [
                'required',
            ],
        ];
    }

    public function resolve($root, $args): User
    {
        $user = app('auth')->guard('api')->user();

        if (Gate::denies('update_user', $user)) {
            throw new AccessDeniedHttpException('You don\'t have permissions to complete this operation.');
        }

        $targetUser = User::whereUuid($args['uuid'])->first();

        $params = collect($args['user'])
            ->only(
                [
                    'email',
                    'first_name',
                    'last_name',
                    'middle_name',
                ]
            )
            ->toArray();

        if (isset($args['password'])) {
            $params['password'] = Hash::make($args['password']);
        }

        $targetUser->update($params);

        return $targetUser->fresh();
    }
}