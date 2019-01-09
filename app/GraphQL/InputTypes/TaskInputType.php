<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;
use GraphQL;

class TaskInputType extends InputType
{
    protected $attributes = [
        'name'        => 'TaskInput',
        'description' => 'A task',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
     protected $inputObject = true;

    public function fields()
    {
        return [
            'uuid'          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the task',
            ],
            'description'   => [
                'type'        => Type::string(),
                'description' => 'The description of task',
            ],
            'eta'           => [
                'type'        => Type::int(),
                'description' => 'The eta of task',
            ],
            'userUuid'     => [
                'type'        => Type::string(),
                'description' => 'The uuid of the owner',
            ],
            'projectUuid'  => [
                'type'        => Type::string(),
                'description' => 'The uuid of the project',
            ],
            'createdAt'    => [
                'type'        => Type::string(),
                'description' => 'Time when task has been created',
            ],
            'timeEntries'   => [
                'type'        => Type::listOf(GraphQL::type('TimeEntryInput')),
                'description' => 'The list of time entries',
            ],
            'total' => [
                'type'        => Type::string(),
                'description' => 'Total time entries durations'
            ],
            'project' => [
                'type'        => GraphQL::type('ProjectInput'),
                'description' => 'The project of task',
            ]
        ];
    }
}