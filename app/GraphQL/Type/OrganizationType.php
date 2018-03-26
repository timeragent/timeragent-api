<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class OrganizationType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Organization',
        'description' => 'An organization',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

    public function fields()
    {
        return [
            'id'      => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The id of the user',
            ],
            'email'   => [
                'type'        => Type::string(),
                'description' => 'The email of user',
            ],
            'name'    => [
                'type'        => Type::string(),
                'description' => 'The name',
            ],
            'address' => [
                'type'        => Type::string(),
                'description' => 'The address',
            ],
            'phone'   => [
                'type'        => Type::string(),
                'description' => 'The phone',
            ],
            'website' => [
                'type'        => Type::string(),
                'description' => 'The website',
            ],
        ];
    }
}