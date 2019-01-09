<?php

namespace App\GraphQL\Type;

use App\Models\User;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class TokenType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Token',
        'description' => 'A user',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

    public function fields()
    {
        return [
            'access_token'          => [
                'type'        => Type::string(),
                'description' => 'User access token',
            ],
            'refresh_token'       => [
                'type'        => Type::string(),
                'description' => 'User refresh token',
            ],
            'expires_in'    => [
                'type'        => Type::string(),
                'description' => 'Expires token date',
            ],
        ];
    }
}
