<?php

namespace App\GraphQL\Mutation\TimeEntry;

use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use App\Models\TimeEntry;

class CreateTimeEntryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createTimeEntry',
    ];

    public function type()
    {
        return GraphQL::type('TimeEntry');
    }

    public function args()
    {
        return [
            'time_entry' => ['name' => 'time_entry', 'type' => GraphQL::type('TimeEntryInput')],
        ];
    }

    public function rules()
    {
        return [
            'time_entry.uuid'       => [
                'required',
                new Uuid(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $time_entry = $args['time_entry'];

        $time_entry_data = [
            'uuid' => $time_entry['uuid'],
            'active' => $time_entry['active'],
            'task_uuid' => $time_entry['taskUuid'],
            'start_time' => $time_entry['startTime'],
            'end_time' => $time_entry['endTime']
        ];

        return TimeEntry::create($time_entry_data);
    }
}