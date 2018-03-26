<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TasksDuration
 *
 * @property-read \App\Models\Task $task
 * @mixin \Eloquent
 */
class TasksDuration extends Model
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
