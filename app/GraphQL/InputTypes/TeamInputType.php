<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;
use GraphQL;

class TeamInputType extends InputType
{
    protected $attributes = [
        'name'        => 'TeamInput',
        'description' => 'A Team'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'uuid' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the team',
            ],
            'name' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The name of the team',
            ],
            'owner_type' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Type of team owner',
            ],
            'owner_uuid' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Uuid of the team owner',
            ],
            'users'      => [
                'type'        => Type::listOf(GraphQL::type('UserInput')),
                'description' => 'List of team members',
            ]
        ];
    }
}