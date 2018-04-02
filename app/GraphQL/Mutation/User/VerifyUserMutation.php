<?php

namespace App\GraphQL\Mutation\User;

use App\Models\User;
use App\Validation\Rules\Unique;
use App\Validation\Rules\Uuid;
use App\Validation\Rules\Verifies;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use GraphQL\Type\Definition\Type;

class VerifyUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'verifyUser',
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'verification_code' => [
                'name' => 'verification_code',
                'type' => Type::string(),
            ],
            'uuid'              => [
                'name' => 'uuid',
                'type' => Type::string(),
            ],
        ];
    }

    public function rules()
    {
        return [
            'verification_code' => [
                'required',
                new Verifies(),
            ],
            'uuid'              => [
                'required',
                new Uuid(),
                'exists:users,uuid',
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