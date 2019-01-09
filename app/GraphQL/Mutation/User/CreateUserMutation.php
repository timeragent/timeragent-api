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
            'user.firstName' => ['required'],
            'user.lastName'  => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $user = collect($args['user']);

        $user_data = [
            'uuid' => $user->get('uuid'),
            'email' => $user->get('email'),
            'first_name' => $user->get('firstName'),
            'last_name' => $user->get('lastName'),
            'middle_name' => $user->get('middleName'),
        ];

        $user_data['password']           = Hash::make($user->get('password'));
        $user_data['verification_token'] = $this->generateUserToken($user->get('uuid'));

        return User::create($user_data);
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