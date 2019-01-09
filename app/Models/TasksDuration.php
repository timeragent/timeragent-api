<?php

namespace App\Models;

/**
 * App\Models\TasksDuration
 *
 * @property-read \App\Models\Task $task
 * @mixin \Eloquent
 */
class TasksDuration extends BaseModel
{
    protected $table = 'tasks_duration';

    protected $fillable = [
        'active',
        'task_id',
        'startTime',
        'spendTime',
        'endTime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
