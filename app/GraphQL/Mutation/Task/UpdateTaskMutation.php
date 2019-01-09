<?php

namespace App\GraphQL\Mutation\Task;

use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use App\Models\Task;

class UpdateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateTask',
    ];

    public function type()
    {
        return GraphQL::type('Task');
    }

    public function args()
    {
        return [
            'task' => ['name' => 'task', 'type' => GraphQL::type('TaskInput')],
        ];
    }

    public function rules()
    {
        return [
            'task.uuid'       => [
                'required',
                new Uuid(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $params = collect($args['task'])
            ->only(
                [
                    'description',
                    'eta',
                    'userUuid',
                    'projectUuid',
                ]
            )
            ->toArray();

        $task_data = [
            'description' => $params['description'],
            'eta' => $params['eta'],
            'user_uuid' => $params['userUuid'],
            'project_uuid' => $params['projectUuid'],
        ];

        $task = Task::find($args['task']['uuid']);

        $task->update($task_data);

        return $task;
    }
}