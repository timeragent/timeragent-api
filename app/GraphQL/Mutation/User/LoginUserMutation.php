<?php

namespace App\GraphQL\Mutation\User;

use App\Models\User;
use App\Traits\PassportToken;
use App\Validation\Rules\Unique;
use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use \Illuminate\Support\Facades\Hash;

class LoginUserMutation extends Mutation
{
    use PassportToken;

    protected $attributes = [
        'name' => 'loginUser',
    ];

    public function type()
    {
        return GraphQL::type('Token');
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
            'user.email'      => [
                'required',
                'email',
            ],
            'user.password'   => [
                'required',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $userCredentials = collect($args['user']);

        $user = User::where('email', $userCredentials['email'])->first();

        if ($user && Hash::check($userCredentials['password'], $user->password)) {
            return $this->getBearerTokenByUser($user, env('CLIENT_ID'));
        } else {
            response()->json('', 500);
        }
    }

}
