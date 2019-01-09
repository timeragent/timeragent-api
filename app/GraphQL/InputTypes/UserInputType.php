<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\InputType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UserInputType extends InputType
{
    protected $attributes = [
        'name'        => 'UserInput',
        'description' => 'A user',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'uuid'        => [
                'type'        => Type::string(),
                'description' => 'The uuid of the user',
            ],
            'email'       => [
                'type'        => Type::string(),
                'description' => 'The email of user',
            ],
            'password'    => [
                'type'        => Type::string(),
                'description' => 'The password of user',
            ],
            'firstName'  => [
                'type'        => Type::string(),
                'description' => 'The first name of user',
            ],
            'lastName'   => [
                'type'        => Type::string(),
                'description' => 'The last name of user',
            ],
            'middleName' => [
                'type'        => Type::string(),
                'description' => 'The middle name of user',
            ],
            'name'        => [
                'type'        => Type::string(),
                'description' => 'The name of user',
            ],
            'costRate'   => [
                'type'        => Type::float(),
                'description' => 'The cost rate of user',
            ],
            'statusInOrganization' => [
                'type'        => Type::int(),
                'description' => 'Status on organization',
            ],
            'organizations' => [
                'type'        => Type::listOf(GraphQL::type('OrganizationInput')),
                'description' => 'List of organizations',
            ]
        ];
    }
}