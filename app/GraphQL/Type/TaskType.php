<?php

namespace App\GraphQL\Type;

use App\Models\Task;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class TaskType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Task',
        'description' => 'A task',
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
                'resolve'     => function ($task) {
                    return $task->user->uuid;
                }
            ],
            'projectUuid'  => [
                'type'        => Type::string(),
                'description' => 'The uuid of the project',
                'resolve'     => function ($task) {
                    return $task->project_uuid;
                }
            ],
            'project' => [
                'type'        => GraphQL::type('Project'),
                'description' => 'The project of task',
            ],
            'timeEntries'  => [
                'type'        => Type::listOf(GraphQL::type('TimeEntry')),
                'description' => 'The list of tome entries',
                'args' => [
                    'date' => [
                        'type'        => Type::string(),
                        'description' => 'Date of time entries',
                    ],
                ]
            ],
            'total' => [
                'type' => Type::int(),
                'description' => 'Total spend time in seconds',
                'args' => [
                    'date' => [
                        'type'        => Type::string(),
                        'description' => 'Date of time entries',
                    ],
                ]
            ],
            'createdAt' => [
                'type' => Type::string(),
                'description' => 'createdAt time'
            ]
        ];
    }

    public function resolveTotalField(Task $task, $args) {
        return $task->totalDuration($args['date']);
    }

    public function resolveTimeEntriesField(Task $task, $args) {
        if (isset($args['date'])) {
            return $task->timeEntries()->whereDate('start_time', $args['date'])->get();
        } else {
            return $task->timeEntries;
        }
    }

}