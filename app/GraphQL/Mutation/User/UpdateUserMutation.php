<?php

namespace App\GraphQL\Mutation\User;

use App\Models\User;
use App\Validation\Rules\Unique;
use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use GraphQL\Type\Definition\Type;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            'user' => [
                'name' => 'user',
                'type' => GraphQL::type('UserInput'),
            ],
        ];
    }

    public function rules()
    {
        return [
            'user.uuid'       => [
                'required',
                new Uuid(),
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
            'user.firstName' => [
                'required',
            ],
            'user.lastName'  => [
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


        $params     = collect($args['user']);
        $targetUser = User::whereUuid($params->get('uuid'))->first();

        $filteredParams = $params
            ->only(
                [
                    'email',
                    'first_name',
                    'last_name',
                    'middle_name',
                ]
            )
            ->toArray();

        if ( ! empty($filteredParams['password'])) {
            $filteredParams['password'] = Hash::make($filteredParams['password']);
        }

        $targetUser->update($filteredParams);

        return $targetUser->fresh();
    }
}