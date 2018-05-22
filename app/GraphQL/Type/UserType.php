<?php

namespace App\GraphQL\Type;

use App\Models\User;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'User',
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
            'uuid'          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the user',
            ],
            'email'       => [
                'type'        => Type::string(),
                'description' => 'The email of user',
            ],
            'first_name'    => [
                'type'        => Type::string(),
                'description' => 'The first name of user',
            ],
            'last_name'     => [
                'type'        => Type::string(),
                'description' => 'The last name of user',
            ],
            'middle_name'   => [
                'type'        => Type::string(),
                'description' => 'The middle name of user',
            ],
            'name'          => [
                'type'        => Type::string(),
                'description' => 'The name of user',
            ],
            'organizations' => [
                'type'        => Type::listOf(GraphQL::type('Organization')),
                'description' => 'Organizations owned by user',
            ],
            'cost_rate'     => [
                'type'        => Type::float(),
                'description' => 'The cost rate of the user',
            ]
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveNameField(User $user, $args)
    {
        return $user->first_name . ' ' . $user->last_name;
    }
}