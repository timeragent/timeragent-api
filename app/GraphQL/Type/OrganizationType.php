<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
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

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'uuid'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the user',
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
            'owners'  => [
                'type'        => Type::listOf(GraphQL::type('User')),
                'description' => 'Owners list',
            ],
        ];
    }
}