<?php

namespace App\GraphQL\Mutation\TimeEntry;

use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use App\Models\TimeEntry;

class UpdateTimeEntryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateTimeEntry',
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
        $timeEntry = TimeEntry::find($args['time_entry']['uuid']);

        $time_entry_data = [
            'active' => $args['time_entry']['active'],
            'task_uuid' => $args['time_entry']['taskUuid'],
            'start_time' => $args['time_entry']['startTime'],
            'end_time' => $args['time_entry']['endTime'],
        ];

        $timeEntry->update($time_entry_data);

        return $timeEntry;
    }
}