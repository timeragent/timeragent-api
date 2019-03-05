<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\TimeEntry;
use Carbon\Carbon;

class TimeEntryMutator
{
    public function createTimeEntry($rootValue, array $args)
    {
        $time_entry_data = $args['timeEntry'];

        $timeEntry             = new TimeEntry();
        $timeEntry->uuid       = $time_entry_data['uuid'];
        $timeEntry->active     = $time_entry_data['active'];
        $timeEntry->task_uuid  = $time_entry_data['taskUuid'];
        $timeEntry->start_time = $time_entry_data['startTime'];
        $timeEntry->end_time   = $time_entry_data['endTime'];
        $timeEntry->save();

        return $timeEntry;
    }

    public function updateTimeEntry($root, $args)
    {
        $timeEntry = TimeEntry::find($args['timeEntry']['uuid']);

        $time_entry_data = $args['timeEntry'];

        $timeEntry->active     = $time_entry_data['active'];
        $timeEntry->task_uuid  = $time_entry_data['taskUuid'];
        $timeEntry->start_time = $time_entry_data['startTime'];
        $timeEntry->end_time   = $time_entry_data['endTime'];
        $timeEntry->save();

        return $timeEntry;
    }

    public function stopTimeEntry($root, $args)
    {
        $timeEntry = TimeEntry::findOrFail($args['uuid']);

        $start_time = Carbon::parse($timeEntry->start_time);

        // Remove time entry if it has less then 60 seconds
        if ($start_time->diffInSeconds(new Carbon) < 60) {
            return $this->deleteTimeEntry(null, ['uuid' => $timeEntry->uuid]);
        }

        $timeEntry->active = false;
        $timeEntry->end_time = new Carbon;
        $timeEntry->save();

        return $timeEntry;
    }

    public function deleteTimeEntry($root, $args)
    {
        $timeEntry = TimeEntry::find($args['uuid']);

        $timeEntry->delete();

        return $timeEntry;
    }
}
