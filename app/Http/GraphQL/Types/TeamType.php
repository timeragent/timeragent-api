<?php

namespace App\Http\GraphQL\Types;

use App\Models\Organization;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;

class TeamType
{
    public function ownerType(Team $team)
    {
        return $team->owner_type;
    }

    public function ownerUuid(Team $team)
    {
        return $team->owner_uuid;
    }

    public function ownerName(Team $team)
    {
        if ($team->owner_type === 'organization') {
            $organization = Organization::where('uuid', $team->owner_uuid)->first();

            return $organization->name;
        }
        $user = User::where('uuid', $team->owner_uuid)->first();

        return $user->first_name . " " . $user->last_name;
    }

    public function users(Team $team, $args)
    {
        if (isset($args['projectUuid'])) {
            return Project::where('uuid', $args['projectUuid'])
                          ->first()
                          ->users()
                          ->whereHas(
                              'teams', function ($query) use ($team) {
                              $query->where('uuid', $team->uuid);
                          }
                          )
                          ->withPivot('cost_rate', 'time_limit')
                          ->get();
        }

        return $team->users;
    }

    public function createdAt(Team $team)
    {
        return $team->created_at;
    }


}
