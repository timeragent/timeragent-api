<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\Type as GraphQLType;
use Folklore\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;

class TimeEntryInputType extends InputType
{
    protected $attributes = [
        'name'        => 'TimeEntryInput',
        'description' => 'A time entry',
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
            'active'        => [
                'type'        => Type::boolean(),
                'description' => 'Status of the time entry',
            ],
            'taskUuid'   => [
                'type'        => Type::string(),
                'description' => 'The uuid of task',
            ],
            'startTime'     => [
                'type'        => Type::string(),
                'description' => 'The start time of the time entry',
            ],
            'endTime'  => [
                'type'        => Type::string(),
                'description' => 'The end time of the time entry',
            ]
        ];
    }
}