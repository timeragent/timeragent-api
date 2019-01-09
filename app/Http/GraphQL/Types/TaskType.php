<?php

namespace App\Http\GraphQL\Types;

use App\Models\Task;

class TaskType
{
    public function userUuid(Task $task)
    {
        return $task->user_uuid;
    }

    public function projectUuid(Task $task)
    {
        return $task->project_uuid;
    }

    public function total(Task $task, $args)
    {
        return $task->totalDuration($args['date']);
    }

    public function timeEntries(Task $task, $args)
    {
        if (isset($args['date'])) {
            return $task->timeEntries()->whereDate('start_time', $args['date'])->get();
        } else {
            return $task->timeEntries;
        }
    }

    public function createdAt(Task $task)
    {
        return $task->created_at;
    }


}
