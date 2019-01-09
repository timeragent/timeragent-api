<?php

namespace App\GraphQL\Mutation\Task;

use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use App\Models\Task;

class CreateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createTask',
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
        $task = $args['task'];
        $task_data = [
            'uuid' => $task['uuid'],
            'description' => $task['description'],
            'eta' => $task['eta'],
            'user_uuid' => $task['userUuid'],
            'project_uuid' => $task['projectUuid'],
            'created_at' => $task['createdAt'],
        ];

        return Task::create($task_data);
    }
}