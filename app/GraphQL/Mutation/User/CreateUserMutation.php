<?php

namespace App\GraphQL\Mutation\User;

use App\Models\User;
use App\Validation\Rules\Unique;
use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use \Illuminate\Support\Facades\Hash;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser',
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
                new Uuid(),
            ],
            'user.email'      => [
                'required',
                'email',
                new Unique('users', 'email'),
            ],
            'user.password'   => [
                'required',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ],
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
                    'password',
                    'first_name',
                    'last_name',
                    'middle_name',
                ]
            )
            ->toArray();

        $params['password']           = Hash::make($params['password']);
        $params['verification_token'] = $this->generateUserToken($params['uuid']);

        return User::create($params);
    }

    /**
     * Generate the verification token.
     *
     * @param string $uuid
     *
     * @return string|bool
     */
    protected function generateUserToken(string $uuid)
    {
        return hash_hmac('sha256', $uuid, env('APP_KEY'));
    }
}