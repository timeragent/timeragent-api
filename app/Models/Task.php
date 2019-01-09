<?php

namespace App\Models;

/**
 * App\Models\Task
 *
 * @property-read \App\Models\Project                                              $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeEntry[] $timeEntries
 * @mixin \Eloquent
 */
class Task extends BaseModel
{
    protected $fillable = [
        'uuid',
        'description',
        'user_uuid',
        'eta',
        'project_uuid',
        'created_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function totalDuration($date)
    {
        return $this->timeEntries()
                    ->where('end_time', '!=', '0000-00-00 00:00:00')
                    ->whereDate('start_time', '!=', $date)
                    ->select(\DB::raw('SUM(TIME_TO_SEC(TIMEDIFF(`end_time`, `start_time`))) as total'))
                    ->first()
            ->total;
    }

    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
