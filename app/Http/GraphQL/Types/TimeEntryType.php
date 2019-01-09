<?php

namespace App\Http\GraphQL\Types;

use App\Models\TimeEntry;

class TimeEntryType
{
    public function userUuid(TimeEntry $timeEntry)
    {
        return $timeEntry->user_uuid;
    }

    public function taskUuid(TimeEntry $timeEntry)
    {
        return $timeEntry->task_uuid;
    }

    public function startTime(TimeEntry $timeEntry)
    {
        return $timeEntry->start_time;
    }

    public function endTime(TimeEntry $timeEntry)
    {
        return $timeEntry->end_time;
    }
}
