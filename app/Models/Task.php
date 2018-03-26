<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Task
 *
 * @property-read \App\Models\Project                                              $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeEntry[] $timeEntries
 * @mixin \Eloquent
 */
class Task extends Model
{
    protected $fillable = [
        'description',
        'active',
        'user_id',
        'eta',
        'project_id',
        'created_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function totalDuration($date)
    {
        return $this->timeEntries()
                    ->whereNotNull('endTime')
                    ->whereDate('startTime', '!=', $date)
                    ->select(\DB::raw('SUM(TIME_TO_SEC(TIMEDIFF(`endTime`, `startTime`))) as total'))
                    ->first()
            ->total;
    }

    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

}
