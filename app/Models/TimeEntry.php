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
        'uuid',
        'active',
        'task_uuid',
        'start_time',
        'end_time',
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
