<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;
use GraphQL;

class ProjectInputType extends InputType
{
    protected $attributes = [
        'name'        => 'ProjectInput',
        'description' => 'A Project'
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
            'client_uuid'     => [
                'type'        => Type::string(),
                'description' => 'The uuid of the client',
            ],
            'owner_type' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Type of team owner',
            ],
            'owner_uuid' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Uuid of the team owner',
            ],
            'teams'      => [
                'type' => Type::listOf(GraphQL::type('TeamInput')),
                'description' => 'List of project teams',
            ],
            'users'      => [
                'type'        => Type::listOf(GraphQL::type('ProjectUserInput')),
                'description' => 'List of team members',
            ]
        ];
    }
}