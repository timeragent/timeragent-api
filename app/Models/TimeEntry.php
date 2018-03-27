<?php

namespace App\Models;

/**
 * App\Models\TimeEntry
 *
 * @property-read \App\Models\Task $task
 * @mixin \Eloquent
 */
class TimeEntry extends BaseModel
{
    protected $table = 'time_entries';

    protected $fillable = [
        'active',
        'task_id',
        'startTime',
        'spendTime',
        'endTime',
    ];

//    public function setStartTimeAttribute($startTime)
//    {
//        $this->attributes['startTime'] = date('Y-m-d ') . $startTime;
//    }
//
//    public function getStartTimeAttribute($startTime)
//    {
//        return date('H:i', strtotime($startTime));
//    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
