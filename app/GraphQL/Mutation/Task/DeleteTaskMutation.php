<?php

namespace App\GraphQL\Mutation\Task;

use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\Task;

class DeleteTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteTask',
    ];

    public function type()
    {
        return GraphQL::type('Task');
    }

    public function args()
    {
        return [
            'uuid' => ['name' => 'uuid', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function rules()
    {
        return [
            'uuid'       => [
                'required',
                new Uuid(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $task = Task::find($args['uuid']);

        $task->delete();
    }
}