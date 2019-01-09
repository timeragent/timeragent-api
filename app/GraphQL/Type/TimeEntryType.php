<?php

namespace App\GraphQL\Type;

use App\Models\User;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class TimeEntryType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'TimeEntry',
        'description' => 'A time entry',
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
            'active'        => [
                'type'        => Type::boolean(),
                'description' => 'Status of the time entry',
            ],
            'taskUuid'   => [
                'type'        => Type::string(),
                'description' => 'The uuid of task',
                'resolve'     => function ($timeEntry) {
                    return $timeEntry->task_uuid;
                }
            ],
            'startTime'     => [
                'type'        => Type::string(),
                'description' => 'The start time of the time entry',
                'resolve'     => function ($timeEntry) {
                    return $timeEntry->start_time;
                }
            ],
            'endTime'  => [
                'type'        => Type::string(),
                'description' => 'The end time of the time entry',
                'resolve'     => function ($timeEntry) {
                    return $timeEntry->end_time;
                }
            ]
        ];
    }
}