<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\Task;

class TaskMutator
{
    public function createTask($root, array $args)
    {
        $task_data = $args['task'];
        $task = new Task();
        $task->uuid = $task_data['uuid'];
        $task->description = $task_data['description'];
        $task->eta = $task_data['eta'] ?? null;
        $task->user_uuid = $task_data['userUuid'];
        $task->project_uuid = $task_data['projectUuid'] ?? null;
        $task->created_at = $task_data['createdAt'] ?? date("Y-m-d H:i:s");
        $task->save();

        return $task;
    }

    public function updateTask($root, $args)
    {
        $task = Task::find($args['task']['uuid']);

        $task_data = $args['task'];

        $task->description = $task_data['description'];
        $task->eta = $task_data['eta'] ?? null;
        $task->user_uuid = $task_data['userUuid'];
        $task->project_uuid = $task_data['projectUuid'] ?? null;
        $task->save();

        return $task;
    }

    public function deleteTask($root, $args)
    {
        if (isset($args['uuids'])) {
            Task::whereIn('uuid', $args['uuids'])->delete();

            return null;
        }
        $task = Task::find($args['uuid']);

        $task->delete();

        return $task;
    }
}
